<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ChatbotAutoResponse;
use App\Models\MLResponse;
use Illuminate\Support\Facades\Cache;

class MLModelService
{
    private $pythonPath;
    private $modelPath;
    
    public function __construct()
    {
        $this->pythonPath = $this->findWorkingPythonPath();
        $this->modelPath = config('ml.model_path', base_path('ml_model'));
    }

    /**
     * Find a working Python executable path
     */
    private function findWorkingPythonPath()
    {
        $primaryPath = config('ml.python_path', 'python');
        $fallbackPaths = config('ml.python_fallback_paths', []);
        
        // Test primary path first
        if ($this->testPythonPath($primaryPath)) {
            Log::info('Using primary Python path', ['path' => $primaryPath]);
            return $primaryPath;
        }
        
        // Try fallback paths
        foreach ($fallbackPaths as $path) {
            // Expand environment variables
            $expandedPath = $this->expandPath($path);
            if ($this->testPythonPath($expandedPath)) {
                Log::info('Using fallback Python path', ['path' => $expandedPath]);
                return $expandedPath;
            }
        }
        
        // If no working path found, log error and return primary path as last resort
        Log::error('No working Python path found', [
            'primary' => $primaryPath,
            'fallbacks_tested' => $fallbackPaths
        ]);
        
        return $primaryPath;
    }

    /**
     * Expand environment variables in path
     */
    private function expandPath($path)
    {
        // Replace common environment variables
        $path = str_replace('%USERPROFILE%', env('USERPROFILE', ''), $path);
        $path = str_replace('~', env('USERPROFILE', ''), $path);
        
        return $path;
    }

    /**
     * Test if a Python path is working
     */
    private function testPythonPath($pythonPath)
    {
        try {
            $result = Process::timeout(5)->run([$pythonPath, '--version']);
            return $result->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Test Python installation and return detailed information
     */
    public function testPythonInstallation()
    {
        try {
            $testScript = $this->modelPath . '/test_python.py';
            $command = [$this->pythonPath, $testScript];
            
            Log::info('Testing Python installation', [
                'python_path' => $this->pythonPath,
                'test_script' => $testScript,
                'script_exists' => file_exists($testScript)
            ]);
            
            $result = Process::timeout(10)->run($command);
            
            if ($result->successful()) {
                $output = $result->output();
                $pythonInfo = json_decode($output, true);
                
                if (json_last_error() === JSON_ERROR_NONE) {
                    return [
                        'success' => true,
                        'python_info' => $pythonInfo,
                        'python_path' => $this->pythonPath
                    ];
                } else {
                    return [
                        'success' => false,
                        'error' => 'Invalid JSON response from Python test',
                        'raw_output' => $output
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'error' => 'Python test script failed: ' . $result->errorOutput(),
                    'python_path' => $this->pythonPath,
                    'exit_code' => $result->exitCode()
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Exception during Python test: ' . $e->getMessage(),
                'python_path' => $this->pythonPath
            ];
        }
    }
    
    /**
     * Get motor compatibility list from Product database
     */
    public function getMotorCompatibilityFromDB()
    {
        try {
            // Get all motor types from product option values
            $motorOptions = ProductOptionValue::whereHas('productOption', function($query) {
                $query->where('option_name', 'motor_type');
            })->where('is_available', true)->get();
            
            $motors = $motorOptions->map(function($option) {
                return strtolower($option->display_value);
            })->unique()->values()->toArray();
            
            // Fallback to default list if no motors found in DB
            if (empty($motors)) {
                $motors = [
                    "honda beat", "honda vario", "honda revo x",
                    "yamaha vega force", "yamaha jupiter z1",
                    "suzuki address fi", "suzuki smash fi",
                    "tvs dazz", "viar star nx", "honda nmax", 
                    "honda revo", "honda pcx", "honda aerox", 
                    "honda scoopy", "honda vespa"
                ];
            }
            
            return $motors;
        } catch (\Exception $e) {
            Log::error('Error fetching motor compatibility from DB: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get detailed product compatibility information
     */
    public function getProductCompatibilityFromDB()
    {
        try {
            // Get products with motor type options
            $productCompatibility = ProductOptionValue::with([
                'productOption.product' => function($query) {
                    $query->select('id', 'name', 'category', 'stock', 'is_active');
                }
            ])
            ->whereHas('productOption', function($query) {
                $query->where('option_name', 'motor_type');
            })
            ->select('id', 'product_option_id', 'value', 'display_value', 'is_available')
            ->get();

            $products = $productCompatibility->map(function($optionValue) {
                $product = $optionValue->productOption->product;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category,
                    'motor_type' => $optionValue->display_value,
                    'motor_value' => $optionValue->value,
                    'stock' => $product->stock,
                    'is_available' => $optionValue->is_available && $product->is_active,
                    'product_active' => $product->is_active,
                    'option_available' => $optionValue->is_available
                ];
            });

            return $products;
        } catch (\Exception $e) {
            Log::error('Error fetching product compatibility from DB: ' . $e->getMessage());
            return collect([]);
        }
    }
    
    /**
     * Get response dictionary from database with caching
     */
    private function getResponseDictionary()
    {
        $cacheKey = config('ml.cache.response_dict_key');
        $cacheTTL = config('ml.cache.ttl');

        return Cache::remember($cacheKey, $cacheTTL, function () {
            return MLResponse::getResponseDictionary();
        });
    }
    
    /**
     * Public method to get response dictionary from database (for controller use)
     */
    public function getResponseDictFromDB()
    {
        try {
            return $this->getResponseDictionary();
        } catch (\Exception $e) {
            \Log::error('MLModelService::getResponseDictFromDB failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // Fallback: try to get responses directly without cache
            try {
                return MLResponse::where('is_active', true)
                    ->get()
                    ->pluck('response', 'intent_key')
                    ->toArray();
            } catch (\Exception $fallbackError) {
                \Log::error('MLModelService fallback also failed', [
                    'error' => $fallbackError->getMessage()
                ]);
                return [];
            }
        }
    }
    
    /**
     * Clean Unicode characters for Windows compatibility
     */
    private function cleanUnicodeForWindows($text)
    {
        // Replace common Unicode characters that cause encoding issues
        $replacements = [
            '💰' => '[PRICE]',
            '📅' => '[SCHEDULE]', 
            '📝' => '[REGISTER]',
            '🚚' => '[DELIVERY]',
            '📍' => '[LOCATION]',
            '❓' => '[HELP]',
            '🔧' => '[SERVICE]',
            '📞' => '[PHONE]',
            '📱' => '[MOBILE]',
            '📦' => '[STOCK]',
            '🛒' => '[SHOP]',
            '⚙️' => '[GEAR]',
            '🎉' => '[PROMO]',
            '🌟' => '[STAR]',
            '🏠' => '[HOME]',
            '⭐' => '[RATING]',
            '✅' => '[OK]',
            '🎯' => '[TARGET]',
            '💼' => '[BUSINESS]',
            '🔥' => '[HOT]',
            '⚡' => '[FAST]',
            '🏍️' => '[MOTOR]',
            '💬' => '[CHAT]'
        ];
        
        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }
    
    /**
     * Predict intent using ML model
     */
    public function predictIntent($userMessage)
    {
        try {
            Log::info('MLModelService::predictIntent started', ['message' => $userMessage]);
            
            // Get dynamic data from database
            $motors = $this->getMotorCompatibilityFromDB();
            Log::info('Motors fetched', ['count' => count($motors), 'motors' => $motors]);
            
            $responses = $this->getResponseDictionary();
            Log::info('Responses fetched', ['count' => count($responses), 'responses' => array_keys($responses)]);
            
            // Prepare the Python script execution
            $scriptPath = $this->modelPath . '/predict_api.py';
            Log::info('Script path', ['path' => $scriptPath, 'exists' => file_exists($scriptPath)]);
            
            // Pass data as JSON arguments
            $motorJson = json_encode($motors, JSON_UNESCAPED_UNICODE);
            $responseJson = json_encode($responses, JSON_UNESCAPED_UNICODE);
            $messageJson = json_encode($userMessage, JSON_UNESCAPED_UNICODE);
            
            Log::info('JSON arguments prepared', [
                'motorJson_length' => strlen($motorJson),
                'responseJson_length' => strlen($responseJson),
                'messageJson_length' => strlen($messageJson)
            ]);
            
            $command = [
                $this->pythonPath,
                $scriptPath,
                $messageJson,
                $motorJson,
                $responseJson
            ];
            
            Log::info('Command to execute', ['command' => $command]);
            
            // Execute Python script with timeout - use try/catch for encoding issues
            $timeout = config('ml.script_timeout', 30);
            $result = Process::timeout($timeout)->run($command);
            
            Log::info('Process execution result', [
                'successful' => $result->successful(),
                'exit_code' => $result->exitCode(),
                'error_output_length' => strlen($result->errorOutput())
            ]);
            
            if ($result->successful()) {
                $output = $result->output();
                
                // Handle potential encoding issues on Windows
                if (empty($output) && !empty($result->errorOutput())) {
                    // Sometimes output goes to stderr due to encoding issues
                    $output = $result->errorOutput();
                }
                
                Log::info('Python script output', ['output' => $output, 'output_length' => strlen($output)]);
                
                if (!empty($output)) {
                    // Clean up any BOM or extra whitespace that might cause JSON issues
                    $output = trim($output);
                    if (substr($output, 0, 3) === "\xEF\xBB\xBF") {
                        $output = substr($output, 3);
                    }
                    
                    $prediction = json_decode($output, true);
                    
                    if (json_last_error() === JSON_ERROR_NONE) {
                        Log::info('Prediction successful', ['prediction' => $prediction]);
                        return [
                            'success' => true,
                            'prediction' => $prediction
                        ];
                    } else {
                        Log::error('Invalid JSON response from ML model', [
                            'output' => $output,
                            'json_error' => json_last_error_msg(),
                            'raw_bytes' => bin2hex($output)
                        ]);
                        return [
                            'success' => false,
                            'error' => 'Invalid response format from ML model: ' . json_last_error_msg()
                        ];
                    }
                } else {
                    Log::error('Empty output from ML model');
                    return [
                        'success' => false,
                        'error' => 'Empty output from ML model'
                    ];
                }
            } else {
                $errorOutput = $result->errorOutput();
                $output = $result->output();
                
                Log::error('ML Model execution failed', [
                    'exit_code' => $result->exitCode(),
                    'error_output' => $errorOutput,
                    'output' => $output,
                    'python_path' => $this->pythonPath,
                    'command' => $command
                ]);
                
                // Check for common Python path issues
                if (str_contains($errorOutput, 'is not recognized as an internal or external command') ||
                    str_contains($errorOutput, 'No such file or directory')) {
                    return [
                        'success' => false,
                        'error' => 'Python executable not found. Please check Python installation and PATH configuration. Current Python path: ' . $this->pythonPath
                    ];
                }
                
                return [
                    'success' => false,
                    'error' => 'ML model execution failed: ' . ($errorOutput ?: $output ?: 'Unknown error')
                ];
            }
            
        } catch (\Exception $e) {
            Log::error('ML Model Service Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'error' => 'Internal server error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Check if message needs ML prediction (not covered by existing auto responses)
     */
    public function shouldUseMlPrediction($userMessage)
    {
        // First check if any existing auto response can handle this
        $existingResponse = $this->findExistingAutoResponse($userMessage);
        
        if ($existingResponse) {
            return false; // Use existing auto response
        }
        
        return true; // Use ML prediction
    }
    
    /**
     * Find existing auto response for the message
     */
    private function findExistingAutoResponse($userMessage)
    {
        $autoResponses = ChatbotAutoResponse::where('is_active', true)
            ->orderBy('priority', 'desc')
            ->get();
            
        foreach ($autoResponses as $response) {
            if ($this->matchesAutoResponse($userMessage, $response)) {
                return $response;
            }
        }
        
        return null;
    }
    
    /**
     * Check if message matches auto response criteria
     */
    private function matchesAutoResponse($message, $autoResponse)
    {
        $message = strtolower($message);
        $keyword = strtolower($autoResponse->keyword);
        
        switch ($autoResponse->match_type) {
            case 'exact':
                return $message === $keyword;
            case 'starts_with':
                return str_starts_with($message, $keyword);
            case 'ends_with':
                return str_ends_with($message, $keyword);
            case 'contains':
            default:
                return str_contains($message, $keyword);
        }
    }
    
    /**
     * Get comprehensive response including ML prediction and auto responses
     */
    public function getComprehensiveResponse($userMessage)
    {
        // Check existing auto responses first
        $existingResponse = $this->findExistingAutoResponse($userMessage);
        
        if ($existingResponse) {
            return [
                'type' => 'auto_response',
                'response' => $existingResponse->response,
                'source' => 'database',
                'matched_keyword' => $existingResponse->keyword
            ];
        }
        
        // Use ML prediction for unknown queries
        $mlResult = $this->predictIntent($userMessage);
        
        if ($mlResult['success']) {
            $responseDict = $this->getResponseDictionary();
            $responses = [];
            $detectedIntents = $mlResult['prediction']['intents'] ?? [];
            
            // Get responses for detected intents
            foreach ($detectedIntents as $intent) {
                if (isset($responseDict[$intent])) {
                    $responses[] = $responseDict[$intent];
                    // Increment usage count
                    MLResponse::where('intent_key', $intent)->increment('usage_count');
                }
            }
            
            if (!empty($responses)) {
                return [
                    'type' => 'ml_prediction',
                    'response' => $responses,
                    'source' => 'ml_model',
                    'confidence' => $mlResult['prediction']['confidence'] ?? 0,
                    'detected_intents' => $detectedIntents
                ];
            }
        }
        
        // Fallback response
        return [
            'type' => 'fallback',
            'response' => ['Maaf, saya tidak dapat memahami pertanyaan Anda. Silakan hubungi customer service untuk bantuan lebih lanjut.'],
            'source' => 'fallback',
            'error' => $mlResult['error'] ?? null
        ];
    }
} 
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DocumentationController extends Controller
{
    /**
     * Show documentation index with all available systems
     */
    public function index()
    {
        $systems = $this->getAvailableSystems();
        
        // Read the README.md file content for the overview
        $readmePath = base_path('README.md');
        $readmeContent = '';
        
        if (file_exists($readmePath)) {
            $readmeContent = file_get_contents($readmePath);
        } else {
            $readmeContent = '# Documentation\n\nNo README.md file found in the project root.';
        }
        
        return view('admin.documentation', compact('systems', 'readmeContent'));
    }

    /**
     * Show specific system documentation
     */
    public function show($system)
    {
        $systemInfo = $this->getSystemInfo($system);
        
        if (!$systemInfo) {
            abort(404, 'Documentation not found');
        }
        
        $filePath = resource_path("docs/{$system}.md");
        
        if (!file_exists($filePath)) {
            abort(404, 'Documentation file not found');
        }
        
        $content = file_get_contents($filePath);
        
        // Read README.md as fallback (though we're showing specific system content)
        $readmePath = base_path('README.md');
        $readmeContent = '';
        
        if (file_exists($readmePath)) {
            $readmeContent = file_get_contents($readmePath);
        } else {
            $readmeContent = '# Documentation\n\nNo README.md file found in the project root.';
        }
        
        return view('admin.documentation', compact('systemInfo', 'content', 'system', 'readmeContent'));
    }

    /**
     * Get system information for display
     */
    private function getSystemInfo($system)
    {
        $systems = $this->getAvailableSystems();
        return $systems[$system] ?? null;
    }

    /**
     * Search documentation content
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json(['results' => []]);
        }

        $results = [];
        $docPath = resource_path('docs');
        
        if (File::exists($docPath)) {
            $files = File::files($docPath);
            
            foreach ($files as $file) {
                if ($file->getExtension() === 'md') {
                    $content = File::get($file->getPathname());
                    $systemName = str_replace('.md', '', $file->getFilename());
                    
                    // Search in content
                    if (stripos($content, $query) !== false) {
                        $systemInfo = $this->getSystemInfo($systemName);
                        
                        // Extract relevant lines
                        $lines = explode("\n", $content);
                        $relevantLines = [];
                        
                        foreach ($lines as $lineNumber => $line) {
                            if (stripos($line, $query) !== false) {
                                $relevantLines[] = [
                                    'line' => $lineNumber + 1,
                                    'content' => $line,
                                    'context' => $this->getLineContext($lines, $lineNumber)
                                ];
                            }
                        }
                        
                        $results[] = [
                            'system' => $systemName,
                            'title' => $systemInfo['title'] ?? $systemName,
                            'matches' => count($relevantLines),
                            'lines' => array_slice($relevantLines, 0, 5) // Limit to 5 matches per file
                        ];
                    }
                }
            }
        }

        return response()->json(['results' => $results]);
    }

    /**
     * Get context around a line
     */
    private function getLineContext($lines, $lineNumber, $contextLines = 2)
    {
        $start = max(0, $lineNumber - $contextLines);
        $end = min(count($lines) - 1, $lineNumber + $contextLines);
        
        $context = [];
        for ($i = $start; $i <= $end; $i++) {
            $context[] = [
                'line' => $i + 1,
                'content' => $lines[$i],
                'highlight' => $i === $lineNumber
            ];
        }
        
        return $context;
    }

    /**
     * Export documentation as PDF
     */
    public function export($system, $format = 'pdf')
    {
        $validSystems = [
            'landing-page-system',
            'product-system', 
            'email-system',
            'message-system',
            'chat-system'
        ];

        if (!in_array($system, $validSystems)) {
            abort(404, 'Documentation not found');
        }

        $docPath = resource_path("docs/{$system}.md");
        
        if (!File::exists($docPath)) {
            abort(404, 'Documentation file not found');
        }

        $content = File::get($docPath);
        $systemInfo = $this->getSystemInfo($system);
        
        if ($format === 'pdf') {
            // You can implement PDF generation here using libraries like TCPDF or DomPDF
            // For now, return the markdown content
            return response($content, 200, [
                'Content-Type' => 'text/markdown',
                'Content-Disposition' => "attachment; filename=\"{$system}-documentation.md\""
            ]);
        }

        return response($content, 200, [
            'Content-Type' => 'text/markdown',
            'Content-Disposition' => "attachment; filename=\"{$system}-documentation.md\""
        ]);
    }

    private function getAvailableSystems()
    {
        return [
            'landing-page-system' => [
                'title' => 'Landing Page System',
                'description' => 'Comprehensive content management system for website sections and dynamic content',
                'category' => 'Content Management',
                'version' => '1.0.0',
                'lastUpdated' => 'December 2024',
                'icon' => 'bx-browser',
                'color' => 'primary'
            ],
            'product-system' => [
                'title' => 'Product System',
                'description' => 'Advanced e-commerce solution with configurable options and inventory management',
                'category' => 'E-commerce',
                'version' => '1.0.0',
                'lastUpdated' => 'December 2024',
                'icon' => 'bx-package',
                'color' => 'success'
            ],
            'email-system' => [
                'title' => 'Email System',
                'description' => 'Professional email system for admin notifications and communication',
                'category' => 'Communication',
                'version' => '1.0.0',
                'lastUpdated' => 'December 2024',
                'icon' => 'bx-envelope',
                'color' => 'info'
            ],
            'message-system' => [
                'title' => 'Message System',
                'description' => 'Customer communication platform with support tickets and inquiries',
                'category' => 'Communication',
                'version' => '1.0.0',
                'lastUpdated' => 'December 2024',
                'icon' => 'bx-message',
                'color' => 'warning'
            ],
            'chat-system' => [
                'title' => 'Chat System',
                'description' => 'Basic customer communication interface for demonstration purposes',
                'category' => 'Communication',
                'version' => '1.0.0',
                'lastUpdated' => 'December 2024',
                'icon' => 'bx-chat',
                'color' => 'danger'
            ]
        ];
    }
} 
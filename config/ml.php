<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ML Model Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration settings for the ML model
    | integration in the chatbot system.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Python Executable Path
    |--------------------------------------------------------------------------
    |
    | The path to the Python executable. This can be:
    | - 'python' (if Python is in PATH)
    | - Full path to python.exe
    | - 'py' (Python launcher on Windows)
    |
    */
    'python_path' => env('ML_PYTHON_PATH', 'python3'),

    /*
    |--------------------------------------------------------------------------
    | Alternative Python Paths
    |--------------------------------------------------------------------------
    |
    | Fallback paths to try if the primary python_path fails
    |
    */
    'python_fallback_paths' => [
        'python',
        'py',
        'C:\Python311\python.exe',
        'C:\Python310\python.exe',
        'C:\Python39\python.exe',
        env('USERPROFILE') . '\AppData\Local\Programs\Python\Python311\python.exe',
        env('USERPROFILE') . '\AppData\Local\Programs\Python\Python310\python.exe',
        env('USERPROFILE') . '\AppData\Local\Microsoft\WindowsApps\python.exe',
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for ML model files and paths
    |
    */
    'model_path' => base_path('ml_model'),
    'script_timeout' => env('ML_SCRIPT_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for caching ML responses and data
    |
    */
    'cache' => [
        'response_dict_key' => 'ml_response_dictionary',
        'motor_list_key' => 'ml_motor_compatibility',
        'ttl' => env('ML_CACHE_TTL', 3600), // 1 hour in seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Encoding Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for handling text encoding issues on Windows
    |
    */
    'encoding' => [
        'clean_unicode' => env('ML_CLEAN_UNICODE', true),
        'use_ascii_fallback' => env('ML_USE_ASCII_FALLBACK', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Files
    |--------------------------------------------------------------------------
    |
    | The names of the ML model files.
    |
    */
    'model_files' => [
        'classifier' => 'chat_model_v2.pkl',
        'vectorizer' => 'vectorizer_v2.pkl',
        'label_encoder' => 'label_encoder_v2.pkl',
        'sub_intent_patterns' => 'sub_intent_patterns.pkl',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Script
    |--------------------------------------------------------------------------
    |
    | The name of the Python API script file.
    |
    */
    'api_script' => 'predict_api.py',

    /*
    |--------------------------------------------------------------------------
    | Timeout Settings
    |--------------------------------------------------------------------------
    |
    | Timeout settings for the ML model API calls.
    |
    */
    'timeout' => [
        'execution' => env('ML_EXECUTION_TIMEOUT', 30), // seconds
        'idle' => env('ML_IDLE_TIMEOUT', 10), // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Confidence Threshold
    |--------------------------------------------------------------------------
    |
    | Minimum confidence threshold for ML predictions.
    | Predictions below this threshold will fall back to default responses.
    |
    */
    'confidence_threshold' => env('ML_CONFIDENCE_THRESHOLD', 0.1),

    /*
    |--------------------------------------------------------------------------
    | Fallback Settings
    |--------------------------------------------------------------------------
    |
    | Settings for fallback behavior when ML model fails.
    |
    */
    'fallback' => [
        'enabled' => env('ML_FALLBACK_ENABLED', true),
        'default_response' => 'Maaf, saya tidak dapat memahami pertanyaan Anda saat ini. Silakan hubungi customer service untuk bantuan lebih lanjut.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Enable/disable logging for ML model operations.
    |
    */
    'logging' => [
        'enabled' => env('ML_LOGGING_ENABLED', true),
        'level' => env('ML_LOGGING_LEVEL', 'info'), // debug, info, warning, error
    ],
]; 
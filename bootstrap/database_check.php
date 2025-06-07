<?php

/**
 * Database connectivity check before session loading
 * This runs before Laravel bootstrap to prevent database session errors
 */

// Run this check for all routes (since sessions use database)
if (isset($_SERVER['REQUEST_URI'])) {
    
    $isAdminRoute = strpos($_SERVER['REQUEST_URI'], '/admin') === 0;
    
    // Get database configuration from .env file
    $envPath = __DIR__ . '/../.env';
    $envVars = [];
    
    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && substr($line, 0, 1) !== '#') {
                list($key, $value) = explode('=', $line, 2);
                $envVars[trim($key)] = trim($value, '"\'');
            }
        }
    }
    
    $dbHost = $envVars['DB_HOST'] ?? '127.0.0.1';
    $dbPort = $envVars['DB_PORT'] ?? '3306';
    $dbDatabase = $envVars['DB_DATABASE'] ?? '';
    $dbUsername = $envVars['DB_USERNAME'] ?? '';
    $dbPassword = $envVars['DB_PASSWORD'] ?? '';
    
    // Test database connection
    $isDatabaseConnected = false;
    
    try {
        if (class_exists('PDO')) {
            $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbDatabase}";
            $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
                PDO::ATTR_TIMEOUT => 3,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $pdo->query('SELECT 1');
            $isDatabaseConnected = true;
        }
    } catch (Exception $e) {
        $isDatabaseConnected = false;
    }
    
    // If database is not connected, show error page immediately
    if (!$isDatabaseConnected) {
        // Set content type
        header('Content-Type: text/html; charset=UTF-8');
        header('HTTP/1.1 503 Service Unavailable');
        
        if ($isAdminRoute) {
            // Show admin database error page
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .error-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-card { background: white; border-radius: 20px; padding: 60px 40px; text-align: center; box-shadow: 0 25px 45px rgba(0,0,0,0.1); max-width: 500px; }
        .error-icon { font-size: 80px; color: #fd7e14; margin-bottom: 30px; }
        .error-title { font-size: 48px; font-weight: 800; color: #fd7e14; margin-bottom: 20px; }
        .btn-retry { background: #fd7e14; border-color: #fd7e14; }
        .btn-retry:hover { background: #e36414; border-color: #e36414; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-icon">
                <i class="bx bx-data"></i>
            </div>
            <div class="error-title">DB</div>
            <h2 class="mb-3">Database Connection Lost</h2>
            <p class="text-muted mb-4">Unable to connect to the database. Please try again in a few minutes.</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <button class="btn btn-retry text-white me-md-2" onclick="location.reload()">
                    <i class="bx bx-refresh me-1"></i>Try Again
                </button>
                <a href="/" class="btn btn-outline-primary">
                    <i class="bx bx-home me-1"></i>Go Home
                </a>
            </div>
            <div class="mt-4">
                <small class="text-muted">The system will automatically retry the connection.</small>
            </div>
        </div>
    </div>
    
    <script>
        // Auto-retry every 30 seconds
        let retryCount = 0;
        const maxRetries = 10;
        
        function autoRetry() {
            if (retryCount < maxRetries) {
                retryCount++;
                console.log("Auto-retry attempt " + retryCount + "/" + maxRetries);
                setTimeout(() => location.reload(), 30000);
            }
        }
        
        // Start auto-retry after 30 seconds
                 setTimeout(autoRetry, 30000);
     </script>
 </body>
 </html>';
        } else {
            // Show non-admin database error page using the original 404-page styling
            echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Database Error - Page Error</title>
<link rel="shortcut icon" href="landing/images/favicon.ico">
<link rel="stylesheet" href="landing/css/master.css">
<link rel="stylesheet" href="landing/css/responsive.css">
</head>
<body>

<!--=== Loader Start ======-->
<div id="loader-overlay">
  <div class="loader-wrapper">
    <div class="scoda-pulse"></div>
  </div>
</div>
<!--=== Loader End ======-->

<!--=== Wrapper Start ======-->
<div class="wrapper white-bg">
  <!--=== page-title-section start ===-->
  <section class="vh-height page_404 white-bg">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-10 centerize-col text-center">
            <div class="four-zero-four-bg">
              <h1 class="dark-color">DATABASE ERROR</h1>
            </div>
            <div class="content-box">
              <h2 class="cardo-font">Database Connection Lost</h2>
              <p class="cardo-font dark-color lead">We\'re experiencing database connectivity issues. Please try again in a few minutes.</p>
              <p class="mt-30">
                <a href="javascript:location.reload()" class="btn btn-color btn-square">TRY AGAIN</a>
                <a href="/" class="btn btn-color btn-square">GO TO HOME</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=== page-title-section end ===-->

</div>
<!--=== Wrapper End ======-->

<!--=== Javascript Plugins ======-->
<script src="landing/js/jquery.min.js"></script>
<script src="landing/js/validator.js"></script>
<script src="landing/js/plugins.js"></script>
<script src="landing/js/master.js"></script>
<script src="landing/js/bootsnav.js"></script>

<script>
// Auto-retry database connection every 30 seconds
let retryCount = 0;
const maxRetries = 10;

function autoRetryConnection() {
    if (retryCount < maxRetries) {
        retryCount++;
        console.log("Auto-retry attempt " + retryCount + "/" + maxRetries);
        setTimeout(() => location.reload(), 30000);
    }
}

// Start auto-retry after 30 seconds
setTimeout(autoRetryConnection, 30000);
</script>

<!--=== Javascript Plugins End ======-->

</body>
</html>';
        }
        exit;
    }
} 
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use PDOException;
use Throwable;

class DatabaseErrorHandler
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if this is an admin route and if we should handle database errors
        if ($request->is('admin') || $request->is('admin/*')) {
            // Try to test database connection early for admin routes
            if (!$this->isDatabaseConnected()) {
                return $this->handleDatabaseError($request, new \Exception('Database connection failed'));
            }
        }
        
        try {
            return $next($request);
        } catch (QueryException $e) {
            return $this->handleDatabaseError($request, $e);
        } catch (PDOException $e) {
            return $this->handleDatabaseError($request, $e);
        } catch (Throwable $e) {
            // Check if the error message indicates a database connection issue
            if ($this->isDatabaseConnectionError($e)) {
                return $this->handleDatabaseError($request, $e);
            }
            
            throw $e;
        }
    }
    
    /**
     * Test if database connection is available
     */
    protected function isDatabaseConnected(): bool
    {
        try {
            // Try to get PDO connection
            $pdo = \DB::connection()->getPdo();
            
            // Try a simple query to ensure the connection works
            $pdo->query('SELECT 1');
            
            return true;
        } catch (Throwable $e) {
            // Log the specific error for debugging
            \Log::debug('Database connection test failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if the exception is related to database connection
     */
    protected function isDatabaseConnectionError(Throwable $e): bool
    {
        $message = strtolower($e->getMessage());
        
        $connectionErrors = [
            'connection refused',
            'no connection could be made',
            'connection failed',
            'can\'t connect to mysql',
            'mysql server has gone away',
            'lost connection',
            'access denied for user',
            'unknown database',
            'sqlstate[hy000]',
            'sqlstate[08006]',
            'sqlstate[08001]',
        ];
        
        foreach ($connectionErrors as $error) {
            if (strpos($message, $error) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Handle database connection errors
     */
    protected function handleDatabaseError(Request $request, Throwable $e)
    {
        // Log the error for debugging
        \Log::error('Database Connection Error: ' . $e->getMessage(), [
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
        ]);
        
        // Check if this is an admin route
        if ($request->is('admin') || $request->is('admin/*')) {
            // If it's an AJAX request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'db_error',
                    'message' => 'Database connection error. Please try again later.',
                ], 503);
            }
            
            // Return custom admin error page
            return response()->view('admin.page-error', [
                'errorCode' => 'db_error',
                'exception' => $e,
            ], 503);
        }
        
        // For non-admin routes, use the error-page template
        return response()->view('errors.error-page', [
            'errorCode' => $errorCode,
            'exception' => $e,
        ], (int) $errorCode);
    }
} 
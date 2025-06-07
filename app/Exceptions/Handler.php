<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Database\QueryException;
use PDOException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    
    /**
     * Report or log an exception.
     */
    public function report(Throwable $exception)
    {
        // Don't report database connection errors to avoid log spam
        if ($exception instanceof QueryException || $exception instanceof PDOException) {
            return;
        }
        
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Check if this is an admin route
        if ($request->is('admin') || $request->is('admin/*')) {
            return $this->renderAdminError($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Render admin-specific error pages
     */
    protected function renderAdminError(Request $request, Throwable $e)
    {
        $errorCode = '500'; // Default to 500
        
        // Determine error code based on exception type
        if ($e instanceof NotFoundHttpException) {
            $errorCode = '404';
        } elseif ($e instanceof AccessDeniedHttpException) {
            $errorCode = '403';
        } elseif ($e instanceof QueryException || $e instanceof PDOException) {
            // Database connection/query errors
            $errorCode = 'db_error';
            
            // Log database errors for debugging
            \Log::error('Database Error in Admin: ' . $e->getMessage(), [
                'exception' => $e,
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip(),
            ]);
        } elseif ($e instanceof HttpException) {
            $errorCode = (string) $e->getStatusCode();
        }
        
        // If it's an AJAX request, return JSON response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'error' => $errorCode,
                'message' => $this->getErrorMessage($errorCode),
            ], (int) $errorCode);
        }
        
        // Check if user is authenticated as admin
        $isAdminAuthenticated = auth('admin')->check();
        
        // If admin is not authenticated and trying to access protected routes, redirect to login
        if (!$isAdminAuthenticated && $request->is('admin/*') && !$request->is('admin/login*')) {
            return redirect()->route('admin.login');
        }
        
        // Return custom admin error page
        return response()->view('admin.page-error', [
            'errorCode' => $errorCode,
            'exception' => $e,
        ], (int) $errorCode);
    }

    /**
     * Get user-friendly error message
     */
    protected function getErrorMessage($errorCode)
    {
        $messages = [
            '404' => 'The page you are looking for could not be found.',
            '403' => 'You do not have permission to access this resource.',
            '500' => 'An internal server error occurred.',
            '503' => 'The service is temporarily unavailable.',
            'db_error' => 'Database connection error. Please try again later.',
        ];

        return $messages[$errorCode] ?? 'An unexpected error occurred.';
    }

    /**
     * Convert an authentication exception into a response.
     */
    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        // Check if this is an admin route
        if ($request->is('admin') || $request->is('admin/*')) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Unauthenticated.'], 401)
                : redirect()->route('admin.login');
        }

        return $request->expectsJson()
            ? response()->json(['message' => 'Unauthenticated.'], 401)
            : redirect()->guest(route('login'));
    }
} 
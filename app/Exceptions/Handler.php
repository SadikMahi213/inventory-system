<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        
        // Handle authentication for API routes
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            
            // Check if the request is for a download template route
            if (str_contains($request->path(), 'download-template')) {
                // Store the intended URL for redirection after login
                session(['url.intended' => $request->url()]);
                return redirect()->route('login')->with('error', 'Please log in to download templates.');
            }
            
            return redirect()->guest(route('login'));
        });
        
        // Handle 404 errors with user-friendly messages
        $this->renderable(function (NotFoundHttpException $e, $request) {
            // Check if the request is for a download template route
            if (str_contains($request->path(), 'download-template')) {
                if (!Auth::check()) {
                    // Store the intended URL for redirection after login
                    session(['url.intended' => $request->url()]);
                    return redirect()->route('login')->with('error', 'Please log in to download templates.');
                }
                
                return response()->view('errors.404', [], 404);
            }
        });
    }
}
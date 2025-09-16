<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

abstract class Controller
{
    protected function throttle(Request $request, string $key, int $maxAttempts = 60, int $decay = 60): void
    {
        $signature = $key . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($signature, $maxAttempts)) {
            abort(429, 'Too Many Requests');
        }
        RateLimiter::hit($signature, $decay);
    }
}

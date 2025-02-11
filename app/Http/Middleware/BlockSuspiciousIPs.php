<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockSuspiciousIPs
{

    private $maxAttempts = 30;
    private $blockMinutes = 1;
    private $decayMinutes = 1;

    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $key = $this->throttleKey($ip);

        // IP bloccato --> error 429
        if (Cache::has($key . ':blocked')) {
            return response()->json([
                'alert' => "You are sending too many requests. Try again after $this->blockMinutes minute(s)."
            ], 429);
        }

        // IP ha già fatto richieste --> incrementa il contatore
        if (Cache::has($key)) {
            $attempts = Cache::increment($key);
        } else {
            Cache::add($key, 1, $this->decayMinutes * 60);
            $attempts = 1;
        }

        // limite supearto --> blocco dell'IP
        if ($attempts > $this->maxAttempts) {
            Cache::put($key . ':blocked', true, $this->blockMinutes * 60);
            Log::warning("IP $ip has been blocked for $this->blockMinutes minute(s) due to too many attempts.");
            return response()->json([
                'alert' => "Your IP has been blocked. Try again after $this->blockMinutes minute(s)."
            ], 429);
        }

        return $next($request);
    }


    protected function throttleKey($ip)
    {
        return 'throttle:' . sha1($ip);
    }
}
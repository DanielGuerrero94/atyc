<?php

namespace App\Http\Middleware;

use Closure;
use Log;

class Logging
{
    private $start;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->start = microtime(true);

        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->end = microtime(true);

        $this->log($request);
    }

    protected function log($request)
    {
        $duration = $this->end - $this->start;
        $url = $request->url();        
        $method = $request->getMethod();
        $ip = $request->getClientIp();
        $user = $request->user();
        $query = json_encode($request->only('order_by','filtros'));

        $log = "{$ip} user:{$user->name} {$method}@{$url} query:{$query} - {$duration}ms";

        Log::info($log);
    }
}

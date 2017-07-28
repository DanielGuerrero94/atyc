<?php

namespace App\Http\Middleware;

use Closure;

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
        //Le saco el http://*/atyc/public
        $url = substr($request->url(),strpos($request->url(),'atyc')+12);
        $method = $request->getMethod();
        $ip = $request->getClientIp();
        $user = $request->user();
        //Saco de la request los datos que me trae el datatable de jquery
        $query = $request->except([
            'draw','columns','order','start','length','search','_'
        ]);

        $json = array(
            'ip' => $ip,
            'user' => $user->id,
            'method' => $method,
            'url' => $url,
            'query' => $request->all(),
            'duration' => $duration
        );

        $query = json_encode($query);

        $log = "{$ip} user:{$user->name} {$method}@{$url} query:{$query} - {$duration}ms";        

        //logger($log);
        //logger(json_encode($json));
    }
}

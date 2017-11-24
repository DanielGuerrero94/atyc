<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Symfony\Component\HttpFoundation\Cookie;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
    	/*'areasTematicas/set'*/
    ];

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
    	$sessionToken = $request->session()->token();

    	$token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN-ATYC');

    	if (! $token && $header = $request->header('X-XSRF-TOKEN-ATYC')) {
    		$token = $this->encrypter->decrypt($header);
    	}

    	if (! is_string($sessionToken) || ! is_string($token)) {
    		return false;
    	}

    	return hash_equals($sessionToken, $token);
    }

    /**
     * Add the CSRF token to the response cookies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addCookieToResponse($request, $response)
    {
    	$config = config('session');

    	$response->headers->setCookie(
    		new Cookie(
    			'XSRF-TOKEN-ATYC', $request->session()->token(), Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
    			$config['path'], $config['domain'], $config['secure'], false
    		)
    	);

    	return $response;
    }
}

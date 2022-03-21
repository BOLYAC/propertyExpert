<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DiviceVerification
{
    // Selected MAC addresses
    public $restrictedIp = ['E4-A8-DF-FC-A4-08'];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//        $d  = $request->route('mac_address');
        $d = $request->fullUrl();
        dd($d);
        if (in_array(auth()->user()->mac_address, $this->restrictedIp)) {
            return $next($request);
        }
        return response()->json(['message' => "You are not allowed to access this site."]);

    }
}

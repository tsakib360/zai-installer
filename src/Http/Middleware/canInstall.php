<?php

namespace Tsakib360\ZaiInstaller\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class canInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $installedLogFile = storage_path('installed');

        if (file_exists($installedLogFile)) {
            return redirect('/');
        }

        return $next($request);
    }
}

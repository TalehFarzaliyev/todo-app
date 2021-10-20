<?php

namespace App\Http\Middleware;

use Closure;

class Todo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty($_SESSION['user_id']) and !isset($_SESSION['user_id']))
        {
            $_SESSION['user_id'] = md5(session_id());
        }
        return $next($request);
    }
}

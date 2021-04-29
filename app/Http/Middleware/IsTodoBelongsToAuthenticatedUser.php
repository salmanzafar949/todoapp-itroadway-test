<?php

namespace App\Http\Middleware;

use App\Models\Todo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsTodoBelongsToAuthenticatedUser
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
        if (auth()->check())
        {
           $todo = Todo::findOrFail($request->route('todo'));

           return $todo->user_id === auth()->id()
               ? $next($request)
               : \response([
                   'error' => 'This todo does not belongs to you'
               ],Response::HTTP_FORBIDDEN);
        }

        return response([
            'error' => 'Unauthenticated'
        ],Response::HTTP_UNAUTHORIZED);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class OAuthCheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role) //aqui adicionamos um parametro para o middleware
    {
        $id = Authorizer::getResourceOwnerId();
        $user = $this->userRepository->find($id);

        if($user->role <> $role) {
            abort(403,'Access Forbidden');
        }

        return $next($request);
    }


}

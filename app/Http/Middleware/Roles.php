<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
        $routeName = Route::getFacadeRoot()->current()->uri();
        $route = explode('/', $routeName);
        //$roleRoutes = Role::distinct()->whereNotNull('allowed_route')->pluck('allowed_route')->toArray();

        if (auth()->check()) {
            if (!in_array($route[0], $this->roleRoutes())){
                return $next($request);

            }else {
                if ($route[0] != $this->userRoutes()) {
                    $path = $route[0] == $this->userRoutes() ? $route[0]. '.login' : '' . $this->userRoutes(). '.index';
                    return redirect()->route($path);

                } else {
                    return $next($request);
                }
            }
        } else{
            $routeDestination = in_array($route[0], $this->roleRoutes()) ? $route[0]. '.login' : 'login';
            $path = $route[0] != '' ? $routeDestination : $this->userRoutes(). '.index';
            return redirect()->route($path);

        }

    
        
    }
    
    protected function roleRoutes()
    {

        if (!Cache::has('role_routes')) {
            Cache::forever('role_routes', Role::distinct()->whereNotNull('allowed_route')->pluck('allowed_route')->toArray()
        );

        }

        return  Cache::get('role_routes');
    }


    protected function userRoutes()
    {

        if (!Cache::has('user_routes')) {
            Cache::forever('user_routes', auth()->user()->roles[0]->allowed_route);

        }

        return  Cache::get('user_routes');
    }
}

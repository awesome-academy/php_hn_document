<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        $admin_role = Role::where('name', config('user.role_admin'))->first();
        $user = Auth::user();
        if ($user->role_id === $admin_role->id) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}

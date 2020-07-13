<?php

namespace App\Http\Middleware;

use Closure;

class OnlyBranchAccess
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
    if (auth()->user()->cabang->hq) {
      return redirect('only-branch-access');
    }

    return $next($request);
  }
}

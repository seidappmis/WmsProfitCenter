<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Auth\LoginController as BaseLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseLoginController
{
  /**
   * Overide application's login form from BaseLoginController
   *
   * @return \Illuminate\Http\Response
   */
  public function showLoginForm()
  {
    return view('auth.login');
  }

  /**
   * Override Attempt to log the user into the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return bool
   */
  protected function attemptLogin(Request $request)
  {
    $credentials              = $this->credentials($request);
    $credentials['user_type'] = 'admin';

    return $this->guard()->attempt(
      $credentials, $request->filled('remember')
    );
  }

}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public $successStatus = 200;

  public function login(Request $request)
  {
    $user = User::leftjoin('wms_user_scanner', 'wms_user_scanner.userid', '=', 'users.username')
      ->whereNotNull('wms_user_scanner.userid')
      ->where('username', request('username'))
      ->first();

    if (!$user) {
      // return an error response
      return response()->json([
        'message' => 'Unauthorized',
      ], 401);
    }

    if (!Hash::check(request('password'), $user->password)) {
      // return an error response
      return response()->json([
        'message' => 'Unauthorized',
      ], 401);
    }
    // https://laravel.com/docs/5.8/passport#managing-personal-access-tokens
    $tokenResult = $user->createToken('Personal Access Token');
    $token       = $tokenResult->token;

    // if ($request->remember_me) {
    //   // kasih expired seminggu
    //   $token->expires_at = Carbon::now()->addWeeks(1);
    // }
    $token->expires_at = Carbon::now()->addWeeks(1);

    // save token expired kalo gak remember me expirednya default sekitar 5 jam
    $token->save();

    return response()->json([
      'access_token' => $tokenResult->accessToken,
      'token_type'   => 'Bearer',
      'expires_at'   => Carbon::parse(
        $tokenResult->token->expires_at
      )->toDateTimeString(),
      'user'         => $user,
    ]);
  }
}

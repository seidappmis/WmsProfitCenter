<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
  public function changePassword(Request $request){
    // Input validation
    $request->validate([
      'old_password'     => 'required',
      'new_password'     => 'required',
      'new_password_confirm' => 'required',
    ]);

    // If new password different from confirm password
    if ($request->input('new_password') != $request->input('new_password_confirm')) {
        return sendError('New Password not match!', []);
    }

    // Check if old password same as database
    $user = Auth::user();

    if (!Hash::check($request['old_password'], $user->password)) {
        $return['status'] = false;
        $return['message'] = 'Wrong Old Password.';
        return $return;
    }

    $user->password = Hash::make($request->input('new_password'));
    $user->save();

    return sendSuccess('Success change password.', $user);
  }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    public function sendResetLinkEmail(Request $request)
    {
        // バリデーション処理
        Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'email' => 'exists:users'
            ],
            [
                'email.required' => 'このフィールドを入力してください。',
                'email.exists' => '登録あるメールアドレスが見つかりません。'
            ]
        )->validate();
        // パスワードリセットメールの送信
        $response = Password::sendResetLink(
            $request->only('email')
        );

        return view("auth.passwords.reset_send");
    }
}

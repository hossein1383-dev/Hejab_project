<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ipe\Sdk\Facades\SmsIr;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
        ]);

        try {
            $otpCode = mt_rand(100000, 999999);
            $loginToken = Str::random(60); // توکن یکتا

            $user = User::updateOrCreate(
                ['cellphone' => $request->cellphone],
                [
                    'otp' => $otpCode,
                    'login_token' => $loginToken,
                ],
            );

            // ارسال پیامک حاوی کد OTP
            $this->sendOtpSms($request->cellphone, $otpCode);

            return response()->json(['login_token' => $loginToken], 200);
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    private function sendOtpSms($mobile, $otpCode)
    {
        $templateId = 351359; // شناسه الگوی پیامکی (واقعی)
        $parameters = [
            [
                'name' => 'Code',
                'value' => $otpCode, // کد تولیدشده را ارسال می‌کنیم
            ],
        ];

        // ارسال با استفاده از Facade SmsIr
        SmsIr::verifySend($mobile, $templateId, $parameters);
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'login_token' => 'required',
        ]);
        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();
            if ($user->otp == $request->otp) {
                Auth::login($user, $remember = true);
                return response()->json(['message' => 'ورود با موفقیت انجام شد'], 200);
            } else {
                return response()->json(['message' => 'کد ورود نادرست است'], 422);
            }
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'login_token' => 'required',
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();
            $otpCode = mt_rand(100000, 999999);
            $loginToken = Str::random(60);

            $user->update([
                'otp' => $otpCode,
                'login_token' => $loginToken,
            ]);

            // ارسال پیامک با کد جدید
            $this->sendOtpSms($user->cellphone, $otpCode);

            return response()->json(['login_token' => $loginToken], 200);
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('index');
    }
}

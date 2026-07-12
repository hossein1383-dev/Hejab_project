<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ipe\Sdk\Facades\SmsIr;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $user = User::where('cellphone', $request->cellphone)->first();
            $otpCode = mt_rand(100000, 999999);
            $loginToken = Hash::make('FBScslddsh$&clsdc*dcncd@DCD');

            if ($user) {
                $user->update([
                    'otp' => $otpCode,
                    'login_token' => $loginToken,
                ]);
            } else {
                $user = User::create([
                    'cellphone' => $request->cellphone,
                    'otp' => $otpCode,
                    'login_token' => $loginToken,
                ]);
            }
            return response()->json(['login_token' => $loginToken], 200);
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
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
            $loginToken = Hash::make('FBScslddsh$&clsdc*dcncd@DCD');

            $user->update([
                'otp' => $otpCode,
                'login_token' => $loginToken,
            ]);

            // $mobile = $request->cellphone;
            // $templateId = 208525; // شناسه الگو واقعی
            // $parameters = [
            //     [
            //         'name' => 'Code',
            //         'value' => rand(10000, 99999),
            //     ],
            // ];

            // $response = SmsIr::verifySend($mobile, $templateId, $parameters);

            // dd($response);

            return response()->json(['login_token' => $loginToken], 200);
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('index');
    }
}

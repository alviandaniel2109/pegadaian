<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Validation;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function index()
    {
        $data = [
            'action' => route('auth.doLogin')
        ];
        return view('pages.gate.login', $data);
    }

    public function doLogin(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $errors = Validator::make(
            $request->all(),
            $rules,
            Validation::ValidationMessage()
        );

        if ($errors->fails()) {
            return response()->json([
                'status' => 'failed',
                'messages' => $errors->errors()->all()
            ]);
        }

        DB::beginTransaction();

        try {
            $login = User::where('user_name', $request->username)->first();

            if (!$login) {
                return response()->json([
                    'status' => 'failed',
                    'messages' => ['Username Gagal Ditemukan']
                ]);
            }

            if (!Hash::check($request->password, $login->password)) {
                return response()->json([
                    'status' => 'failed',
                    'messages' => ['Password Salah Silahkan Ulangi Sekali Lagi']
                ]);
            }

            Auth::login($login);

            return response()->json([
                'status' => 'success',
                'messages' => 'Sukses Login',
                'url' => route('dashboard.index')
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'messages' => [
                    ['Gagal Login'],
                    ['Pesan : ' . $e->getMessage()]
                ],
            ]);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'messages' => [
                    ['Gagal Logout'],
                    ['Message : '. $e->getMessage()]
                ],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Sukses Logout',
            'url' => route('auth.login')
        ]);
    }
}

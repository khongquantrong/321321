<?php

namespace App\Http\Controllers\API\V1;

use App\Events\LogHistoryLogin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rules;

class AuthenController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $user = User::query()->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return \response()->json([
                'error' => trans('auth.failed')
            ], Response::HTTP_BAD_REQUEST);
        }

        $token = $user->createToken(__CLASS__);

        LogHistoryLogin::dispatch($user, $token);

        return \response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

//        Dòng naày quan trọng nhất
//        Nó tạo ra token để truy cập
        $token = $user->createToken(__CLASS__);

        return \response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        /** @var User $user */
        $user = \request()->user();

        // Xóa thằng phiên đăng nhập hiện tại
        // $user->currentAccessToken()->delete();

        // Xóa tất cả phiên đăng nhập của chính user hiện tại
//        $user->tokens()->delete();

        // Xóa theo ID
//        $tokenId = $user->currentAccessToken()->id;
//        $user->tokens()->where('id', $tokenId)->delete();

        return \response()->json([], Response::HTTP_OK);
    }
}

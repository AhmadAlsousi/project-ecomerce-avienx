<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Enum\Users\UserStatusEnum;
use App\Http\Controllers\APIController;

use App\Http\Requests\User\Auth\LoginUserRequest;
use App\Http\Requests\User\VerifyRequest;
use App\Http\Resources\LoginUsersResource;
use App\Http\Resources\User\LoginUsersResource as UserLoginUsersResource;
use App\Models\User;

use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\JWTGuard;

class LoginUserController extends APIController
{
    public function loginCustomer(LoginUserRequest $request)
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['email'])->first();
        /** @var JWTGuard $guard */
        $guard = auth('api');
        if (!$user) {
            return $this->sendError('no found user', 400);
        }
        if ($user->type->value == 'customer') {
            return $this->sendError('the user is not customer', 400);
        }
        if ($user->email_verified_at == null) {
            return $this->sendError('user is not verify', 400);
        }
        $token = $guard->attempt($credentials);

        if (!$token) {
            throw ValidationException::withMessages([
                'email' => [
                    'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
                ],
            ]);
        }

        return $this->sendResponce(
            $token,
            'success',
            200
        );
    }
    public function loginAdmin(LoginUserRequest $request)
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['email'])->first();
        /** @var JWTGuard $guard */
        $guard = auth('api');
        if ($user) {
            if ($user->type->value == 'admin') {
                $token = $guard->attempt($credentials);

                if (!$token) {
                    throw ValidationException::withMessages([
                        'email' => [
                            'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
                        ],
                    ]);
                }

                return $this->sendResponce(
                    $token,
                    'success',
                    200
                );
            } else {
                return $this->sendError('the user is not admin', 400);
            }
        } else {
            return $this->sendError('no found user', 400);
        }
    }
    public function loginVendor(LoginUserRequest $request)
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['email'])->first();
        // dd($user->email_verified_at);

        /** @var JWTGuard $guard */

        $guard = auth('api');
        // dd($user->type->value);

        if (!$user) {
            return $this->sendError('no found user', 400);
        }
        if ($user->type->value != 'vendor') {
            return $this->sendError('the user is not vendor', 400);
        }
        if ($user->email_verified_at == null) {
            return $this->sendError('user is not verify', 400);
        }
        $token = $guard->attempt($credentials);

        if (!$token) {
            throw ValidationException::withMessages([
                'email' => [
                    'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
                ],
            ]);
        }

        return $this->sendResponce(
            $token,
            'success',
            200
        );
    }
    public function infoUser()
    {
        $info = auth('api')->user();
        return $this->sendResponce($info, 'success', 200);;
    }
    public function verify(VerifyRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (! $user) {
            return $this->sendError('User not found.', 404);
        }

        if ($user->Number_of_attempts >= 4) {
            // dd('hij');
            $user->status = UserStatusEnum::BLOCKED->value;
            $user->save();
            return $this->sendError('User blocked.', 403);
        }

        if ($user->number_verify !== $data['verify']) {
            $user->increment('number_of_attempts');
            $user->status = UserStatusEnum::ACTIVE->value;
            return $this->sendError('Invalid verification code.', 422);
        }

        $user->update([
            'email_verified_at' => now()
        ]);
        $user->status = UserStatusEnum::ACTIVE->value;
        $user->save();

        return $this->sendResponce(
            UserLoginUsersResource::make($user->fresh()),
            'Account confirmed.',
            200
        );
    }
    public function logout()
    {
        /** @var JWTGuard $guard */
        $guard =   auth('api');
        $guard->logout();


        return $this->sendResponce(null, 'نجح تسجيل الخروج', 200);
    }
    public function refresh()
    {
        /** @var JWTGuard $guard */
        $guard = auth('api');
        $newToken = $guard->refresh();

        return $this->sendResponce($newToken, 'success', 200);
    }
}

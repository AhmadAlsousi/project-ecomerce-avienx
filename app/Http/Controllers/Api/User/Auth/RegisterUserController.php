<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\APIController;
use App\Http\Requests\Admin\Auth\RegisterAdminRequest;

use App\Http\Requests\User\Auth\RegisterUserRequest;
use App\Http\Requests\Vendor\Auth\RegisterVendorRequest;
use App\Http\Resources\RegisterUsersResource;
use App\Jobs\Users\MailSendJob;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Tymon\JWTAuth\JWTGuard;

class RegisterUserController extends APIController
{
    //Register:: Admin & Customer & Vendor
    //Register:: Customer
    public function create(RegisterUserRequest $request)
    {
        $data = $request->validated();
 if ($data['type'] == 'customer') {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'type' => 'customer',
            'status' => 'active',
        ]);
       

            Customer::create([
                'user_id' => $user->id,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'gender' => $data['gender'] ?? null,
            ]);
        } else {
            return $this->sendError('Invalid user type', 400);
        }



 $code = Str::upper(Str::random(6));
            $user->number_verify=$code;
            $user->Number_of_attempts=$user->Number_of_attempts + 1;
            $user->save();
        // /** @var JWTGuard $guard */
        // $guard = auth('api');

        // $token = $guard->login($user);
        // dd();
        MailSendJob::dispatch($user);

        return $this->sendResponce(
            RegisterUsersResource::make($user),
            'success',
            201
        );
    }
    //Register:: Admin
    public function create_admin(RegisterAdminRequest $request)
    {
        $data = $request->validated();
        if ($data['type'] == 'admin') {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => $data['password'],
                'type' => $data['type'],
                'status' => 'active',
            ]);

            $admin = Admin::create([
                'user_id' => $user->id,
                'department' => $data['department']
            ]);}
             else {
            return $this->sendError('Invalid user type', 400);
        }
            // /** @var JWTGuard $guard */
            // $guard = auth('api');

            // $token = $guard->login($user);
            $code = Str::upper(Str::random(6));
            $user->number_verify = $code;
            $user->Number_of_attempts = $user->Number_of_attempts + 1;
            $user->save();
        MailSendJob::dispatch($user);


    return $this->sendResponce(
            RegisterUsersResource::make($user),
            'success',
            201
        );
        
    }
    //Register:: Vendor
    public function create_vendor(RegisterVendorRequest $request)
    {
        $data = $request->validated();
        if ($data['type'] == 'vendor') {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => $data['password'],
                'type' => $data['type'],
                'status' => 'active',
            ]);
            $vendor = Vendor::create([
                'user_id' => $user->id,
                'store_name' => $data['store_name'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'business_registration_number' => $data['business_registration_number'],
                'is_approved' => $data['is_approved'],


            ]);
        } else {
            return $this->sendError('Invalid user type', 400);
        }
        // /** @var JWTGuard $guard */
        // $guard = auth('api');

        // $token = $guard->login($user);
        $code = Str::upper(Str::random(6));
        $user->number_verify = $code;
        $user->Number_of_attempts = $user->Number_of_attempts + 1;
        $user->save();
        $result = [
            'type_user' => $user->type,
            'data' => $vendor,
            // 'token' => $token
        ];
        MailSendJob::dispatch($user);

         return $this->sendResponce(
            RegisterUsersResource::make($user),
            'success',
            201
        );
    }
}

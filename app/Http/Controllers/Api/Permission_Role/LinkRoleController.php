<?php

namespace App\Http\Controllers\Api\Permission_Role;

use App\Enum\Users\UserTypeEnum;
use App\Http\Controllers\APIController;
use App\Http\Requests\Authoriz\Link\RoleLinkRequest;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\JWTGuard;

class LinkRoleController extends APIController
{
    public function linkVendor(RoleLinkRequest $request)
    {
        /** @var JWTGuard $guard */
        $guard = auth('api');

        if (! $guard->check()) {
            return $this->sendError(
                'User is not authenticated',
                401
            );
        }

        $user = $guard->user();
        if($user->email_verified_at==null){
         return $this->sendError(
                'Account must be verified',
                400
            );
            }

        if ($user->type !== UserTypeEnum::VENDOR) {
            return $this->sendError(
                'User is not of type vendor',
                403
            );
        }

        $roleName = $request->validated();

        $role = Role::query()
            ->where('name', $roleName)
            ->where('guard_name', 'api')
            ->first();

        if (! $role) {
            return $this->sendError(
                'Role does not exist for the api guard',
                404
            );
        }

        if ($user->hasRole($role)) {
            return $this->sendError(
                'User already has this role',
                409
            );
        }

        $user->assignRole($role);

        return $this->sendResponce(
            null,
            'The role was assigned to the user successfully',
            200
        );
    }
    public function linkAdmin(RoleLinkRequest $request)
    {
        /** @var JWTGuard $guard */
        $guard = auth('api');

        if (! $guard->check()) {
            return $this->sendError(
                'User is not authenticated',
                401
            );
        }

        $user = $guard->user();
        if($user->email_verified_at==null){
         return $this->sendError(
                'Account must be verified',
                400
            );
            }

        if ($user->type !== UserTypeEnum::ADMIN) {
            return $this->sendError(
                'User is not of type Admin',
                403
            );
        }

        $roleName = $request->validated();

        $role = Role::query()
            ->where('name', $roleName)
            ->where('guard_name', 'api')
            ->first();

        if (! $role) {
            return $this->sendError(
                'Role does not exist for the api guard',
                404
            );
        }

        if ($user->hasRole($role)) {
            // dd( $user->hasRole($role));
            return $this->sendError(
                'User already has this role',
                409
            );
        }

        $user->assignRole($role);

        return $this->sendResponce(
            null,
            'The role was assigned to the user successfully',
            200
        );
    }
}
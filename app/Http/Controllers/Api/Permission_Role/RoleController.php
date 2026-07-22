<?php

namespace App\Http\Controllers\Api\Permission_Role;

use App\Enum\Users\UserTypeEnum;
use App\Http\Controllers\APIController;
use App\Http\Requests\Authoriz\Link\RoleLinkRequest;
use App\Http\Requests\Authoriz\RoleCreateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends APIController
{
    public function index() {}
    public function create(RoleCreateRequest $request)
    {
        $data = $request->validated();
        $Role = Role::create($data);
        return $this->sendResponce($Role, ' success', 200);
    }
    public function indexadmin()
    {
        $peradmin = Role::Where('guard_name', 'admin')->get();
        return $this->sendResponce($peradmin, 'success', 200);
    }
    public function indexvendor()
    {
        $peradmin = Role::Where('guard_name', 'vendor')->get();
        return $this->sendResponce($peradmin, 'success', 200);
    }
   
}

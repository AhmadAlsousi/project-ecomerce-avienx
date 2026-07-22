<?php

namespace App\Http\Controllers\Api\Permission_Role;

use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authoriz\PermissionCreateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends APIController
{
       public function create(PermissionCreateRequest $request){
        $data=$request->validated();
        $Role=Permission::create($data);
        return $this->sendResponce($Role ,' success',200) ;
    }
    public function indexadmin(){
        $peradmin=Permission::Where('guard_name','admin')->get();
        return $this->sendResponce($peradmin,'success',200);
       }
       public function indexvendor()
       {
        $peradmin=Permission::Where('guard_name','vendor')->get();
        return $this->sendResponce($peradmin,'success',200);
       }
}

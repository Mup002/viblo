<?php

namespace Database\Seeders;

use App\Models\Permission;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
class PermissionRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $role;
    protected $permission;
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }
    public function run(): void
    {
        //
        $permissions = $this->permission->whereBetween('permission_id',[2,5])->get();
        $role =  $this->role->find(1);

        foreach($permissions as $permissions)
        {
            DB::table('permission_role')->insert([
                'permission_id' => $permissions->permission_id,
                'role_id' => $role->role_id,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }
    }
}

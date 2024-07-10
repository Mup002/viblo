<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $users;
    protected $roles;
    public function __construct(User $users ,Role $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }
    public function run(): void
    {
        //
        $user = $this->users->all();
        $role = $this->roles->find(1);
        foreach($user as $u)
        {

            DB::table('user_role')->insert([
                'user_id' => $u->user_id,
                'role_id' => $role->role_id,
                'created_at' => now(),
                'updated_at' =>now(),
            ]);
        };
    }
}

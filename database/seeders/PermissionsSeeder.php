<?php

namespace Database\Seeders;

use App\Modules\Users\Enums\UserRolesEnums;
use App\Utils\PermissionsKeyEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /*
         * seed Permissions table
         */
        $permissions   = PermissionsKeyEnum::values();
        foreach ($permissions as $permission){
            Permission::create([
                'name' => $permission
            ]);
        }
        // seed roles table
        $role = Role::create([
            "name" => UserRolesEnums::SUPER_ADMIN(),
            "description"=>"Full system access and user management with admin management"
        ]);
        $rolePermissions = Permission::whereIn("name"  ,[
            PermissionsKeyEnum::MANAGE_ADMINS(),
            PermissionsKeyEnum::MANAGE_JOB(),
            PermissionsKeyEnum::MANAGE_ROLES(),
            PermissionsKeyEnum::MANAGE_USER(),
            PermissionsKeyEnum::VIEW_STATS()

        ])->get();
        $role->givePermissionTo($rolePermissions);
        $role = Role::create([
            "name" => UserRolesEnums::ADMIN(),
            "description"=>"Full system access and user management But can't change admins users"
        ]);
        $role->givePermissionTo([
            PermissionsKeyEnum::MANAGE_JOB(),
            PermissionsKeyEnum::MANAGE_ROLES(),
            PermissionsKeyEnum::MANAGE_USER(),
            PermissionsKeyEnum::VIEW_STATS()

        ]);
        $role =Role::create([
            "name" => UserRolesEnums::RECRUITER(),
            "description"=>"Can post jobs and manage applications"
        ]);
        $role->givePermissionTo([
            PermissionsKeyEnum::MANAGE_OWN_JOBS(),
            PermissionsKeyEnum::VIEW_APPLICATIONS(),
            PermissionsKeyEnum::CREATE_JOBS(),
            PermissionsKeyEnum::AI_REQUEST_ANALYZE_APPLICANT(),
        ]);
        $role =Role::create([
            "name" => UserRolesEnums::JOBSEEKER(),
            "description"=>"Can browse and apply to jobs"
        ]);
        $role->givePermissionTo([
            PermissionsKeyEnum::MANAGE_PROFILE(),
            PermissionsKeyEnum::APPLY_TO_JOB(),
            PermissionsKeyEnum::VIEW_JOBS(),
            PermissionsKeyEnum::AI_REQUEST_ANALYZE_PROFILE(),
            PermissionsKeyEnum::EXPORT_CV()

        ]);
        $role =Role::create([
            "name" => UserRolesEnums::USER(),
            "description"=>"Basic platform access"
        ]);
        $role->givePermissionTo([
            PermissionsKeyEnum::VIEW_PUBLIC_CONTENT()

        ]);


    }
}

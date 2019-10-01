<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $adminPermissions = ['manage-users', 'view-users', 'create-users', 'edit-users', 'delete-users'];
        foreach($adminPermissions as $ap)
        {
            $permission = Permission::create(['name' => $ap]);
            $adminRole->givePermissionTo($permission);
        }
        $adminUser = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('1234')
        ]);
        $adminUser->assignRole($adminRole);

        $editorRole = Role::create(['name' => 'Editor']);
        $editorPermissions = ['manage-users', 'view-users'];
        foreach($editorPermissions as $ep)
        {
            $permission = Permission::firstOrCreate(['name' => $ep]);
            $editorRole->givePermissionTo($permission);
        }
        $editorUser = User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@supervisor.com',
            'password' => Hash::make('1234')
        ]);
        $editorUser->assignRole($editorRole);

        $userRole = Role::create(['name' => 'User']);
        $generalUser = User::create([
            'name' => 'Secretário',
            'email' => 'secretario@secretario.com',
            'password' => Hash::make('1234')
        ]);
        $generalUser->assignRole($userRole);
    }
}

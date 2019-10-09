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
        $adminPermissions = ['relatorio', 'manage-users', 'view-users', 'create-users', 'edit-users',  'delete-users', 'ver-processo', 'create-processo', 'update-processo'];
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

        $editorRole = Role::create(['name' => 'Supervisor']);
        $editorPermissions = ['manage-users', 'view-users', 'create-users', 'edit-users', 'ver-processo', 'update-processo','ver-pendencias'];
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

        $userRole = Role::create(['name' => 'Secritário']);
        $userPermissions = ['manage-users', 'view-users', 'create-users', 'edit-users', 'ver-processo','ver-pendencias'];
        foreach($userPermissions as $up)
        {
            $permission = Permission::firstOrCreate(['name' => $up]);
            $userRole->givePermissionTo($permission);
        }
        $generalUser = User::create([
            'name' => 'Secretário',
            'email' => 'secretario@secretario.com',
            'password' => Hash::make('1234')
        ]);
        $generalUser->assignRole($userRole);
    }
}

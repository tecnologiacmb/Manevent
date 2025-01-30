<?php

namespace Database\Seeders;

use Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class User_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name'=>'ver-admin']);
        Permission::create(['name'=>'crear-admin']);
        Permission::create(['name'=>'actualizar-admin']);
        Permission::create(['name'=>'eliminar-admin']);
        Permission::create(['name'=>'ver-usuario']);
        Permission::create(['name'=>'crear-usuario']);
        Permission::create(['name'=>'actualizar-usuario']);
        Permission::create(['name'=>'eliminar-usuario']);

        $admin_usuario = User::query()->create([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('123456'),
            'email_verified_at'=>now()
        ]);

        $role_admin=Role::create(['name'=>'super-admin']);
        $admin_usuario->assignRole($role_admin);
        $permission_admin=Permission::query()->pluck('name');
        $role_admin->syncPermissions($permission_admin);

        $role_usuario=Role::create(['name'=>'usuario']);
        $role_usuario->syncPermissions('ver-usuario','crear-usuario','actualizar-usuario','eliminar-usuario');





    }
}

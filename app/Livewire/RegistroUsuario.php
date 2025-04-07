<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class RegistroUsuario extends Component
{
    use WithPagination;

    public $usuarios;
    public $model_has_roles;
    public $roles;
    public $open_edit = false;
    public $post_edit_id;
    public $open = false;
    public $create_usuario = [
        'name' => null,
        'email' => null,
        'password' => null,
        'confirmar_password' => null
    ];
    public $create_rol;

    protected $listeners = ['delete'];

    public function mount() {}

    public function crear()
    {
        $this->open = true;
    }

    public function seve()
    {
        if ($this->create_usuario['password'] == $this->create_usuario['confirmar_password']) {
            // Crear el usuario
            $usuario = User::create([
                'name' => $this->create_usuario['name'],
                'email' => $this->create_usuario['email'],
                'password' => Hash::make($this->create_usuario['password']),
            ]);

            // Obtener el rol seleccionado
            $rolSeleccionado = Role::where('id', $this->create_rol)->first();

            if ($rolSeleccionado) { // Asegurarte de que el rol existe
                $usuario->assignRole($rolSeleccionado); // Asignar el rol al usuario

                // Asignar permisos según el tipo de rol
                if ($rolSeleccionado->name == 2) {
                    $permissions = Permission::orderBy('id', 'desc')->take(4)->get();
                    $rolSeleccionado->syncPermissions($permissions);
                } else {
                    $permissions = Permission::orderBy('id', 'desc')->take(8)->get();
                    $rolSeleccionado->syncPermissions($permissions);
                }
                $rolSeleccionado->syncPermissions($permissions); // Sincronizar permisos
            } else {
                session()->flash('error', 'El rol seleccionado no existe.');
                return;
            }

            // Resetear formularios y cerrar modal
            $this->reset(['create_usuario', 'create_rol']);
            $this->dispatch('alert');
            $this->open = false;

            return $usuario;
        } else {
            // Contraseñas no coinciden
            $this->dispatch('alert_error', 'Las contraseñas no coinciden.');
        }
    }

    public function edit($edit_id)
    {
        $this->open_edit = true;
        $this->post_edit_id = $edit_id;
        $user = User::find($edit_id);
        $this->create_usuario["name"] = $user->name;
        $this->create_usuario["email"] = $user->email;
        $this->create_rol = $user->roles->first()->id;
    }
    public function update()
    {
        $user = User::find($this->post_edit_id);
        $user->update([
            'name' => $this->create_usuario['name'],
            'email' => $this->create_usuario['email']
        ]);
        $rolSeleccionado = Role::where('id', $this->create_rol)->first();
        $user->syncRoles([$rolSeleccionado]);
        if ($rolSeleccionado->name == 2) {
            $permissions = Permission::orderBy('id', 'desc')->take(4)->get();
            $rolSeleccionado->syncPermissions($permissions);
        } else {
            $permissions = Permission::orderBy('id', 'desc')->take(8)->get();
            $rolSeleccionado->syncPermissions($permissions);
        }
        $this->reset(['create_usuario', 'create_rol', 'post_edit_id', 'open_edit']);
        $this->dispatch('alert_update');
    }
    public function confirm_delete($delete_id)
    {
        $this->dispatch('alert_delete', $delete_id);
    }
    public function delete($delete_id)
    {
        $User = User::find($delete_id);
        $User->delete();
    }
    public function render()
    {
        $usuarios = DB::table('model_has_roles')
            ->join('users', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'users.email', 'model_has_roles.role_id as id_rol', 'roles.name as roles_name')->orderBy('users.id', 'desc')->where('users.id', '!=', 1)->paginate(5);
        $roles = Role::all();
        $this->roles = $roles;
        return view('livewire.registro-usuario', ['users' => $usuarios, 'roles' => $roles]);
    }
}

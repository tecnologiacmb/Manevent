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
    public $open_contraseña = false;
    public $post_contraseña;
    public $open = false;
    public $create_usuario = [
        'name' => null,
        'email' => null,
        'password' => null,
        'confirmar_password' => null
    ];
    public $update_usuario = [
        'name' => null,
        'email' => null,
        'password' => null,
        'confirmar_password' => null
    ];
    public $update_contraseña_users = [
        'password' => null,
        'confirmar_password' => null
    ];
    public $create_rol;
    public $update_rol;
    protected $listeners = ['delete'];
    public $showPassword = false;
    public $registrar = false;
    public $actualizar = false;
    public $cambio_contraseña = false;

    public function mount() {}

    public function crear()
    {
        $this->open = true;
    }
    public function validar_registro()
    {
        $this->registrar = true;
        $this->actualizar = false;
        $this->cambio_contraseña = false;
    }
    public function validar_actualizacion()
    {
        $this->actualizar = true;
        $this->registrar = false;
        $this->cambio_contraseña = false;
    }
    public function validar_cambio_contraseña()
    {
        $this->cambio_contraseña = true;
        $this->registrar = false;
        $this->actualizar = false;
    }
    public function rules(): array
    {
        if ($this->registrar == true) {
            $this->actualizar = false;
            $this->cambio_contraseña = false;
            return [
                "create_usuario.name" => 'required|string|max:49|regex:/^[a-zA-Z\s]+$/',
                "create_usuario.email" => 'required|email|max:60|unique:users,email',
                "create_usuario.password" => 'required|string|min:6',
                "create_usuario.confirmar_password" => 'required|string|min:6',
                "create_rol" => 'required|integer',
            ];
        } else if ($this->actualizar == true) {
            $this->registrar = false;
            $this->cambio_contraseña = false;
            return [
                "update_usuario.name" => 'required|string|max:49|regex:/^[a-zA-Z\s]+$/',
                "update_usuario.email" => 'required|email|max:60',
                "update_rol" => 'required|integer',
            ];
        } else if ($this->cambio_contraseña == true) {
            $this->registrar = false;
            $this->actualizar = false;
            return [
                "update_contraseña_users.password" => 'required|string|min:8',
                "update_contraseña_users.confirmar_password" => 'required|string|min:8',
            ];
        } else {
            return [];
        }
    }
    public function messages(): array
    {
        if ($this->registrar == true) {
            $this->actualizar = false;
            $this->cambio_contraseña = false;
            return [
                "create_usuario.name.required" => __('El campo nombre es obligatorio.'),
                "create_usuario.name.string" => __('El campo nombre debe ser una cadena de texto.'),
                "create_usuario.name.max" => __('El campo nombre no debe ser mayor a 49 letras.'),
                "create_usuario.name.regex" => __('El campo nombre solo acepta letras.'),
                "create_usuario.email.required" => __('El campo email es obligatorio.'),
                "create_usuario.email.email" => __('El campo email debe tener la sintaxis correcta.'),
                "create_usuario.email.max" => __('El campo email no debe ser mayor a 60 letras.'),
                "create_usuario.email.unique" => __('El email ya se encuentra registrado.'),
                "create_usuario.password.required" => __('El campo contraseña es obligatorio.'),
                "create_usuario.password.string" => __('El campo contraseña debe ser una cadena de texto.'),
                "create_usuario.password.min" => __('El campo contraseña debe tener al menos 6 caracteres.'),
                "create_usuario.confirmar_password.required" => __('El campo confirmar contraseña es obligatorio.'),
                "create_usuario.confirmar_password.string" => __('El campo confirmar contraseña debe ser una cadena de texto.'),
                "create_usuario.confirmar_password.min" => __('El campo confirmar contraseña debe tener al menos 6 caracteres.'),
                "create_rol.required" => __('El campo rol es obligatorio.'),
                "create_rol.integer" => __('El campo rol debe ser un numero.'),
            ];
        } else if ($this->actualizar == true) {
            $this->registrar = false;
            $this->cambio_contraseña = false;
            return [
                "update_usuario.name.required" => __('El campo nombre es obligatorio.'),
                "update_usuario.name.string" => __('El campo nombre debe ser una cadena de texto.'),
                "update_usuario.name.max" => __('El campo nombre no debe ser mayor a 49 letras.'),
                "update_usuario.name.regex" => __('El campo nombre solo acepta letras.'),
                "update_usuario.email.required" => __('El campo email es obligatorio.'),
                "update_usuario.email.email" => __('El campo email debe tener la sintaxis correcta.'),
                "update_usuario.email.max" => __('El campo email no debe ser mayor a 60 letras.'),
                "update_rol.required" => __('El campo rol es obligatorio.'),
                "update_rol.integer" => __('El campo rol debe ser un numero.'),
            ];
        } else if ($this->cambio_contraseña == true) {
            $this->registrar = false;
            $this->actualizar = false;
            return [
                "update_contraseña_users.password.required" => __('El campo contraseña es obligatorio.'),
                "update_contraseña_users.password.string" => __('El campo contraseña debe ser una cadena de texto.'),
                "update_contraseña_users.password.min" => __('El campo contraseña debe tener al menos 8 caracteres.'),
                "update_contraseña_users.confirmar_password.required" => __('El campo confirmar contraseña es obligatorio.'),
                "update_contraseña_users.confirmar_password.string" => __('El campo confirmar contraseña debe ser una cadena de texto.'),
                "update_contraseña_users.confirmar_password.min" => __('El campo confirmar contraseña debe tener al menos 8 caracteres.'),
            ];
        } else {
            return [];
        }
    }


    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }
    public function seve()
    {
        $this->validate();
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
        $this->update_usuario["name"] = $user->name;
        $this->update_usuario["email"] = $user->email;
        $this->update_rol = $user->roles->first()->id;
    }
    public function contraseña($edit_id)
    {
        $this->open_contraseña = true;
        $this->post_contraseña = $edit_id;
    }
    public function update()
    {
        $this->validate();

        $user = User::find($this->post_edit_id);
        $user->update([
            'name' => $this->update_usuario['name'],
            'email' => $this->update_usuario['email']
        ]);
        $rolSeleccionado = Role::where('id', $this->update_rol)->first();
        $user->syncRoles([$rolSeleccionado]);
        if ($rolSeleccionado->name == 2) {
            $permissions = Permission::orderBy('id', 'desc')->take(4)->get();
            $rolSeleccionado->syncPermissions($permissions);
        } else {
            $permissions = Permission::orderBy('id', 'desc')->take(8)->get();
            $rolSeleccionado->syncPermissions($permissions);
        }
        $this->reset(['update_usuario', 'update_rol', 'post_edit_id', 'open_edit']);
        $this->dispatch('alert_update');
    }
    public function update_contraseña()
    {
        $this->validate();

        if ($this->update_contraseña_users['password'] == $this->update_contraseña_users['confirmar_password']) {
            $user = User::find($this->post_contraseña);
            $user->update([
                'password' => Hash::make($this->update_contraseña_users['password'])

            ]);
            $this->reset(['update_contraseña_users','post_contraseña', 'open_contraseña']);
            $this->dispatch('alert_update_contraseña');
        } else {
            $this->dispatch('alert_error');
        }
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

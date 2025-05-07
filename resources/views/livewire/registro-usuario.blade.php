<div>
    <div class="w-full max-[500px]:w-full mb-2">
        <div
            class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] justify-between">
            <div>
                <img src="{{ asset('storage/image/usuario.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute left-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            </div>
            <div>
                <p class="text-center text-black text-2xl pt-8 group-hover:text-green-800">Listado de usuarios</p>
            </div>

            <div>
                <x-button
                    class=" absolute right-[8%] top-[50%] translate-y-[-50%] shadow hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                    wire:click="crear">
                    Registrar
                </x-button>
            </div>
        </div>
    </div>

    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto overflow-y-hidden">
        <table class="w-full text-center table-auto min-w-max">
            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Nombre</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Correo</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Rol</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Opciones</p>
                    </th>

                </tr>
            </thead>

            <tbody>
                @foreach ($users as $usuario)
                    <tr>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $usuario->name }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $usuario->email }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $usuario->roles_name }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <x-button class="bg-blue-500 hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                                wire:click="edit({{ $usuario->id }})">
                                <i class="bi bi-pencil-square"></i>
                            </x-button>
                            <x-danger-button class="bg-red-700" wire:click="confirm_delete({{ $usuario->id }})">
                                <i class="bi bi-trash-fill"></i>
                            </x-danger-button>
                            <x-button
                                class=" bg-yellow-500 hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-400"
                                wire:click="contraseña({{ $usuario->id }})">
                                <i class="bi bi-exclamation-triangle-fill"></i> </x-button>
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>
        <div>
            {{ $users->links() }}
        </div>

        <form wire:submit="seve">
            <x-dialog-modal wire:model="open">
                <x-slot name="title">
                    Registrar Usuario
                </x-slot>

                <x-slot name="content">
                    <div class="mb-4">
                        <x-label for="">Nombre</x-label>
                        <x-input class="w-full" wire:model="create_usuario.name" />
                        @error('create_usuario.name')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Correo</x-label>
                        <x-input type="email" class="w-full" wire:model="create_usuario.email" />
                        @error('create_usuario.email')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Contraseña</x-label>
                        <x-input class="w-full" wire:model="create_usuario.password" />
                        @error('create_usuario.password')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Confirmar Contraseña</x-label>
                        <x-input class="w-full" wire:model="create_usuario.confirmar_password" />
                        @error('create_usuario.confirmar_password')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Rol</x-label>
                        <x-select class="w-full" wire:model="create_rol">
                            <option value="">Selecciona un Rol de acceso</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                            @endforeach
                        </x-select>
                        @error('create_rol')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex justify-end">
                        <x-danger-button class="mr-2" wire:click="$set('open',false)">
                            Cancelar
                        </x-danger-button>

                        <x-button wire:click="validar_registro()">
                            Registrar
                        </x-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </form>
        <form wire:submit="update">
            <x-dialog-modal wire:model="open_edit">
                <x-slot name="title">
                    Actualizar Usuario
                </x-slot>

                <x-slot name="content">
                    <div class="mb-4">
                        <x-label for="">Nombre</x-label>
                        <x-input class="w-full" wire:model="update_usuario.name" />
                        @error('update_usuario.name')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Correo</x-label>
                        <x-input type="email" class="w-full" wire:model="update_usuario.email" />
                        @error('update_usuario.email')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Rol</x-label>
                        <x-select class="w-full" wire:model="update_rol">
                            <option value="">Selecciona un Rol de acceso</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                            @endforeach
                        </x-select>
                        @error('update_rol')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex justify-end">
                        <x-danger-button class="mr-2" wire:click="$set('open_edit',false)">
                            Cancelar
                        </x-danger-button>

                        <x-button wire:click="validar_actualizacion()">
                            Actualizar
                        </x-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </form>
        <form wire:submit="update_contraseña">
            <x-dialog-modal wire:model="open_contraseña">
                <x-slot name="title">
                    Cambiar Contraseña
                </x-slot>

                <x-slot name="content">

                    <div class="mb-4">
                        <x-label for="password">Contraseña</x-label>
                        <div class="relative">
                            <x-input type="{{ $showPassword ? 'text' : 'password' }}" class="w-full"
                                wire:model="update_contraseña_users.password" id="password" />
                        </div>
                        @error('update_contraseña_users.password')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="confirm_password">Confirmar Contraseña</x-label>
                        <div class="relative">
                            <x-input type="{{ $showPassword ? 'text' : 'password' }}" class="w-full"
                                wire:model="update_contraseña_users.confirmar_password" id="confirm_password" />
                        </div>
                        @error('update_contraseña_users.confirmar_password')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <h1 class="text-center text-xl text-red-800">
                        ¿ Estas seguro de querer cambiar la contraseña ?
                    </h1>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex justify-end">
                        <x-danger-button class="mr-2" wire:click="$set('open_contraseña',false)">
                            NO
                        </x-danger-button>

                        <x-button type="submit" wire:click="validar_cambio_contraseña()">
                            SI
                        </x-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </form>

    </div>
    @push('js')
        <script>
            Livewire.on('alert', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "El registro ha sido exitoso!",
                    icon: "success"
                });
            })
            Livewire.on('alert_error', function() {
                Swal.fire({
                    title: "Error!",
                    text: "¡No coincide la contraseña!",
                    icon: "danger"
                });
            })
            Livewire.on('alert_update', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "Los datos han sido actualizados!",
                    icon: "success"
                });
            })
            Livewire.on('alert_update_contraseña', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "La contraseña ha sido actualizados!",
                    icon: "success"
                });
            })
            Livewire.on('alert_delete', post_id => {
                Swal.fire({
                    title: "¿Estas seguro?",
                    text: "¡No podras revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¿Si, eliminalo!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.dispatch('delete', post_id)
                        Swal.fire({
                            title: "Borrado!",
                            text: "Eliminacion exitosa.",
                            icon: "success"
                        });
                    }
                });

            })
        </script>
    @endpush
</div>

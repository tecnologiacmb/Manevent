<div>
    <div class=" bg-white shadow rounded-lg p-4 mb-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="pl-8">
                <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal normal-case">
                    Datos personales
                </h1>
            </div>
        </div>


    </div>
    <form wire:submit="update">
        <div class="bg-white shadow-md rounded-xl p-6">
            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4">
                    <x-label for="">Cedula</x-label>
                    <x-input class="w-full" wire:model="post_update.cedula" />
                    @error('post_update.cedula')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Nombre</x-label>
                    <x-input class="w-full" wire:model="post_update.nombre" />
                    @error('post_update.nombre')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Apellido</x-label>
                    <x-input class="w-full" wire:model="post_update.apellido" />
                    @error('post_update.apellido')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Telefono</x-label>
                    <x-input type="number" class="w-full" wire:model="post_update.telefono" />
                    @error('post_update.telefono')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Correo</x-label>
                    <x-input type="email" class="w-full" wire:model="post_update.correo" />
                    @error('post_update.correo')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">direccion</x-label>
                    <x-input class="w-full" wire:model="post_update.direccion" />
                    @error('post_update.direccion')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Fecha de nacimineto</x-label>
                    <x-input type="date" class="w-full" wire:model="post_update.fecha_nacimiento" />
                    @error('post_update.fecha_nacimiento')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Estado</x-label>
                    <x-select class="w-full" wire:model.change="post_update.estado_id">
                        <option value="">Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}"> {{ $estado->estado }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="mb-4">
                    <x-label for="">Ciudad </x-label>
                    <x-select class="w-full" wire:model="post_update.ciudad_id">
                        <option value="">Seleccione la ciudad</option>
                        @if (!empty($post_update['ciudades']))
                            @foreach ($post_update['ciudades'] as $ciudad)
                                <option
                                    value="{{ $ciudad->id }}"{{ $post_update['ciudad_id'] == $ciudad->id ? 'selected' : '' }}>
                                    {{ $ciudad->ciudad }}</option>
                            @endforeach
                        @endif
                    </x-select>
                </div>
            </div>
            <div class="flex justify-end">
                <x-danger-button wire:click="confirm_delete({{ $this->post_edit_id }})">
                    <i class="bi bi-trash-fill"></i>
                </x-danger-button>

                <x-button>
                    Actualizar
                </x-button>
            </div>
        </div>


    </form>
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('alert_update', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "Los datos han sido actualizados!",
                    icon: "success",
                    didClose: () => {
                        // Obtener la URL de la ruta con nombre usando una variable JavaScript
                        const url =
                            "{{ route('vista_usuarios') }}"; // Esta línea se procesa en el servidor
                        window.location.href = url; // Redirección en el cliente (navegador)
                    }
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
                            icon: "success",
                            didClose: () => {
                                // Obtener la URL de la ruta con nombre usando una variable JavaScript
                                const url =
                                    "{{ route('vista_usuarios') }}"; // Esta línea se procesa en el servidor
                                window.location.href = url; // Redirección en el cliente (navegador)
                            }
                        });
                    }
                });

            })
        </script>
    @endpush
</div>

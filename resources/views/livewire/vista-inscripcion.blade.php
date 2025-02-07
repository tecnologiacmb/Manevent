<div>
    <form wire:submit="update">
        <div class="grid grid-cols-3 gap-4">
            <div class="mb-4">
                <x-label for="">N° Orden</x-label>
                <x-input class="w-full" wire:model="post_update.cedula" />
                @error('post_update.cedula')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Cedula</x-label>
                <x-input class="w-full" wire:model="post_update.nombre" />
                @error('post_update.nombre')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Recorrido</x-label>
                <x-input class="w-full" wire:model="post_update.apellido" />
                @error('post_update.apellido')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Mesa</x-label>
                <x-input type="number" class="w-full" wire:model="post_update.telefono" />
                @error('post_update.telefono')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">IP</x-label>
                <x-input type="email" class="w-full" wire:model="post_update.correo" />
                @error('post_update.correo')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Monto</x-label>
                <x-input class="w-full" wire:model="post_update.direccion" />
                @error('post_update.direccion')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Fecha</x-label>
                <x-input type="date" class="w-full" wire:model="post_update.fecha_nacimiento" />
                @error('post_update.fecha_nacimiento')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
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

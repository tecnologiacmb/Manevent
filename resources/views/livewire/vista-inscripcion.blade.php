<div class="bg-white shadow-md rounded-xl p-6">
    <form wire:submit="update">
        <div class="grid grid-cols-3 gap-4">
            <div class="mb-4">
                <x-label for="">Evento</x-label>
                <x-input class="w-full" wire:model="post_update.evento_id" />
                @error('post_update.evento_id')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Cedula</x-label>
                <x-input class="w-full" wire:model="post_update.participante_id" />
                @error('post_update.participante_id')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Metodo pago</x-label>
                <x-input class="w-full" wire:model="post_update.metodo_pago_id" />
                @error('post_update.metodo_pago_id')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <x-label for="">Grupo</x-label>
                <x-input class="w-full" wire:model="post_update.grupo_id" />
                @error('post_update.grupo_id')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">numero</x-label>
                <x-input class="w-full" wire:model="post_update.numero_id" />
                @error('post_update.numero_id')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">categoria</x-label>
                <x-input class="w-full" wire:model="post_update.categoria_habilitada_id" />
                @error('post_update.categoria_habilitada_id')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">mesa</x-label>
                <x-input class="w-full" wire:model="post_update.mesa_id" />
                @error('post_update.mesa_id')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Fecha pago</x-label>
                <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                @error('post_update.datos.fecha')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Monto $</x-label>
                <x-input class="w-full" wire:model="post_update.datos.monto" />
                @error('post_update.datos.monto')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Monto Bs</x-label>
                <x-input class="w-full" wire:model="post_update.monto_pagado_bs" />
                @error('post_update.monto_pagado_bs')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Referencia</x-label>
                <x-input class="w-full" wire:model="post_update.datos.referencia" />
                @error('post_update.datos.referencia')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">ip</x-label>
                <x-input class="w-full" wire:model="post_update.ip" />
                @error('post_update.ip')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">nomenclatura</x-label>
                <x-input class="w-full" wire:model="post_update.nomenclatura" />
                @error('post_update.nomenclatura')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">recorrido</x-label>
                <x-input class="w-full" wire:model="post_update.recorrido_id" />
                @error('post_update.recorrido_id')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="">Fecha de inscripcion</x-label>
                <x-input type="date" class="w-full" wire:model="post_update.created_at" />
                @error('post_update.created_at')
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

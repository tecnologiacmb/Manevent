<div>
    <div class=" bg-white shadow rounded-lg p-4 mb-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="pl-8">
                <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal normal-case
">
                    Evento: {{ $this->post_update['evento_id'] }}.
                </h1>
            </div>
            <div class="justify-items-end pr-8">
                <h1 class="mt-2 font-black text-2xl text-gray-800 leading-tight text-normal normal-case
">
                    Grupo: {{ $this->post_update['grupo_id'] }}
                </h1>
            </div>
        </div>
        <div class="flex items-center justify-start py-0">

            <h1 class="pl-8 font-black text-sm text-black leading-tight text-normal normal-case
">
                Monto Total: {{ $this->post_update['grupo_precio'] }} $
            </h1>
            <h1 class="pl-6 font-black text-sm text-black leading-tight text-normal normal-case
">
                Monto Total: {{ $this->post_update['monto_pagado_bs'] }} Bs
            </h1>
            <h1 class="pl-6 font-black text-sm text-black leading-tight text-normal normal-case
">
                Tasa dolar: {{ $this->post_update['dolar_id'] }} Bs
            </h1>

        </div>
    </div>
    <div class="bg-white shadow-md rounded-xl p-6">
        <form wire:submit="update">
            <div class="grid grid-cols-3 gap-4">

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
                    <x-label for="">recorrido</x-label>
                    <x-input class="w-full" wire:model="post_update.recorrido_id" />
                    @error('post_update.recorrido_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                @if (!isset($post_update['datos']['fecha_mixto']))
                <div class="mb-4">
                    <x-label for="">Fecha pago</x-label>
                    <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                    @error('post_update.datos.fecha')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                    @if (isset($post_update['datos']['monto_Bs']))
                        <div class="mb-4">
                            <x-label for="">Monto Bs</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.monto_Bs" />
                            @error('post_update.datos.monto_Bs')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <div class="mb-4">
                            <x-label for="">Monto $</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.monto_$" />
                            @error('post_update.datos.monto_$')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-4">
                        <x-label for="">Referencia</x-label>
                        <x-input class="w-full" wire:model="post_update.datos.referencia" />
                        @error('post_update.datos.referencia')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                @else
                    @if (isset($post_update['datos']['monto_mixto_Bs']))
                        <div class="mb-4">
                            <x-label for="">Fecha pago</x-label>
                            <x-input type="date" class="w-full" wire:model="post_update.datos.fecha_mixto" />
                            @error('post_update.datos.fecha_mixto')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Monto Bs</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.monto_mixto_Bs" />
                            @error('post_update.datos.monto_mixto_Bs')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Referencia</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.referencia_mixto" />
                            @error('post_update.datos.referencia_mixto')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @if (isset($post_update['datos']['monto_Bs']))
                            <div class="mb-4">
                                <x-label for="">Fecha pago</x-label>
                                <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                                @error('post_update.datos.fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Monto Bs</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.monto_Bs" />
                                @error('post_update.datos.monto_Bs')
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
                        @else
                            <div class="mb-4">
                                <x-label for="">Fecha pago</x-label>
                                <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                                @error('post_update.datos.fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Monto Bs</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.monto_$" />
                                @error('post_update.datos.monto_4')
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
                        @endif
                    @else
                    <div class="mb-4">
                        <x-label for="">Fecha pago</x-label>
                        <x-input type="date" class="w-full" wire:model="post_update.datos.fecha_mixto" />
                        @error('post_update.datos.fecha_mixto')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                        <div class="mb-4">
                            <x-label for="">Monto $</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.monto_mixto_$" />
                            @error('post_update.datos.monto_mixto_$')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Referencia</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.referencia_mixto" />
                            @error('post_update.datos.referencia_mixto')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @if (isset($post_update['datos']['monto_Bs']))
                            <div class="mb-4">
                                <x-label for="">Fecha pago</x-label>
                                <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                                @error('post_update.datos.fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Monto Bs</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.monto_Bs" />
                                @error('post_update.datos.monto_Bs')
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
                        @else
                            <div class="mb-4">
                                <x-label for="">Fecha pago</x-label>
                                <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                                @error('post_update.datos.fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Monto Bs</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.monto_$" />
                                @error('post_update.datos.monto_4')
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
                        @endif

                    @endif
                @endif


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
</div>

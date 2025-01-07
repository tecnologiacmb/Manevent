<div>
    <div class="bg-white shadow rounded-lg p-4 pl-12 pr-12 mb-4 flex items-center justify-between ">
        <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal">
            Eventos Registrados
        </h1>
        <x-button class="shadow" wire:click="crear">
            Agregar
        </x-button>
    </div>
    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-hidden overflow-y-hidden">


        <table class="w-full text-left table-auto min-w-max">
            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Id
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Nombre del Evento
                        </p>
                    </th>

                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Inicio
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Finaliza
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            estado
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                        </p>
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    @foreach ($posts as $eventos)
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $eventos->id }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $eventos->nombre }}
                            </p>
                        </td>


                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $eventos->fecha_inicio }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $eventos->fecha_finalizacion }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $eventos->estado }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50 space-x-8">
                            <x-button class="bg-blue-500" wire:click="edit({{ $eventos->id }})">
                                <i class="bi bi-pencil-square"></i>
                            </x-button>

                            <x-danger-button wire:click="confirm_delete({{ $eventos->id }})">
                                <i class="bi bi-trash-fill"></i>
                            </x-danger-button>
                        </td>
                    @endforeach
                </tr>

            </tbody>

        </table>

        <div>
            {{ $posts->links() }}
        </div>

        <form wire:submit="seve">
            <x-dialog-modal wire:model="open">
                <x-slot name="title">
                    Actualizar Post
                </x-slot>

                <x-slot name="content">

                    <div class="mb-4">
                        <x-label for="">Nombre del Evento</x-label>
                        <x-input class="w-full" wire:model="post_create.nombre" />
                        @error('post_create.nombre')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">


                        <div class="mb-4">
                            <x-label for="">Lugar</x-label>
                            <x-input class="w-full" wire:model="post_create.lugar_evento" />
                            @error('post_create.lugar_evento')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Inicia</x-label>
                            <x-input type="date" class="w-full" wire:model="post_create.fecha_inicio" />
                            @error('post_create.fecha_inicio')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Finaliza</x-label>
                            <x-input type="date" class="w-full" wire:model="post_create.fecha_finalizacion" />
                            @error('post_create.fecha_finalizacion')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                        </div>



                        <div class="mb-4">
                            <x-label for="">Fecha de Realización</x-label>
                            <x-input type="date" class="w-full" wire:model="post_create.fecha_evento" />
                            @error('post_create.fecha_evento')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Estado</x-label>
                            <x-select class="w-full" wire:model="post_create.estado">
                                <option value="" disabled>Seleccione un Estado</option>
                                <option value="0">Deshabilitado</option>
                                <option value="1">Habilitado</option>
                            </x-select>
                            @error('post_create.estado')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex justify-end">
                        <x-danger-button class="mr-2" wire:click="$set('open',false)">
                            Cancelar
                        </x-danger-button>

                        <x-button>
                            Agregar
                        </x-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </form>

        <form wire:submit="update">
            <x-dialog-modal wire:model="open_edit">
                <x-slot name="title">
                    Actualizar Post
                </x-slot>

                <x-slot name="content">

                    <div class="mb-4">
                        <x-label for="">Nombre del Evento</x-label>
                        <x-input class="w-full" wire:model="post_update.nombre" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">


                        <div class="mb-4">
                            <x-label for="">Lugar</x-label>
                            <x-input class="w-full" wire:model="post_update.lugar_evento" />
                        </div>
                        <div class="mb-4">
                            <x-label for="">Inicia</x-label>
                            <x-input type="date" class="w-full" wire:model="post_update.fecha_inicio" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Finaliza</x-label>
                            <x-input type="date" class="w-full" wire:model="post_update.fecha_finalizacion" />
                        </div>



                        <div class="mb-4">
                            <x-label for="">Fecha de Realización</x-label>
                            <x-input type="date" class="w-full" wire:model="post_update.fecha_evento" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Estado</x-label>
                            <x-select class="w-full" wire:model="post_update.estado">
                                <option value="" disabled>Seleccione un Estado</option>
                                <option value="0">Deshabilitado</option>
                                <option value="1">Habilitado</option>
                            </x-select>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex justify-end">
                        <x-danger-button class="mr-2" wire:click="$set('open_edit',false)">
                            Cancelar
                        </x-danger-button>

                        <x-button>
                            Actualizar
                        </x-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </form>

        @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('alert', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "El registro ha sido exitoso!",
                    icon: "success"
                });
            })
            Livewire.on('alert_update', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "Los datos han sido actualizados!",
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

                        Livewire.dispatch('delete',post_id)
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

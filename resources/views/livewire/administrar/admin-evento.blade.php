<div>
    <div class="w-full max-[500px]:w-full mb-2">
        <div
            class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] justify-between">
            <div>
                <img src="{{ asset('storage/image/evento.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute left-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            </div>
            <div>
                <p class="text-center text-black text-2xl px-56 pt-8 group-hover:text-green-800">Registro de Eventos</p>
            </div>

            <div>
                <x-button
                    class=" absolute right-[8%] top-[50%] translate-y-[-50%] shadow hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                    wire:click="crear">
                    Registrar
                </x-button>
            </div>
            <br>
        </div>
    </div>

    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-hidden overflow-y-hidden">


        <table class="w-full text-center table-auto min-w-max">
            <thead>
                <tr>

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
                            Opciones
                        </p>
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($posts as $eventos)
                    <tr>

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
                        <td class="p-4 border-b border-blue-gray-50">
                            <x-button class="bg-blue-500 hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                                wire:click="edit({{ $eventos->id }})">
                                <i class="bi bi-pencil-square"></i>
                            </x-button>

                            <x-danger-button wire:click="confirm_delete({{ $eventos->id }})">
                                <i class="bi bi-trash-fill"></i>
                            </x-danger-button>
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>

        <div>
            {{ $posts->links() }}
        </div>

        <form wire:submit="seve">
            <x-dialog-modal wire:model="open">
                <x-slot name="title">
                    Registrar
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
                                <option value="">Seleccione un Estado</option>
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

                        <x-button wire:click="validar1()">
                            Registrar
                        </x-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </form>

        <form wire:submit="update">
            <x-dialog-modal wire:model="open_edit">
                <x-slot name="title">
                    Actualizar
                </x-slot>

                <x-slot name="content">

                    <div class="mb-4">
                        <x-label for="">Nombre del Evento</x-label>
                        <x-input class="w-full" wire:model="post_update.nombre" />
                        @error('post_update.nombre')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-label for="">Lugar</x-label>
                            <x-input class="w-full" wire:model="post_update.lugar_evento" />
                            @error('post_update.lugar_evento')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Inicia</x-label>
                            <x-input type="date" class="w-full" wire:model="post_update.fecha_inicio" />
                            @error('post_update.fecha_inicio')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Finaliza</x-label>
                            <x-input type="date" class="w-full" wire:model="post_update.fecha_finalizacion" />
                            @error('post_update.fecha_finalizacion')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="mb-4">
                            <x-label for="">Fecha de Realización</x-label>
                            <x-input type="date" class="w-full" wire:model="post_update.fecha_evento" />
                            @error('post_update.fecha_evento')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Estado</x-label>
                            <x-select class="w-full" wire:model="post_update.estado">
                                <option value="">Seleccione un Estado</option>
                                <option value="0">Deshabilitado</option>
                                <option value="1">Habilitado</option>
                            </x-select>
                            @error('post_update.estado')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex justify-end">
                        <x-danger-button class="mr-2" wire:click="$set('open_edit',false)">
                            Cancelar
                        </x-danger-button>

                        <x-button wire:click="validar2()">
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

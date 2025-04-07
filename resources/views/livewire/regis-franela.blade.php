<div>

    <div class="bg-white shadow rounded-lg p-2 mb-2 flex items-center justify-between">
        <h1 class="font-black text-2xl text-gray-800 leading-tight text-center py-2 ml-4">
            Listado de prendas
        </h1>
        <div class="justify-items-end pr-12">
            <x-button class="shadow" wire:click="crear">
                Agregar
            </x-button>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4 mb-2 px-8">
        <input type="text" wire:model.live="query" placeholder="Buscar..."
            class="w-1/3 px-8 mt-2 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />
        <x-select wire:model.live="eventoId" class="ml-2 mt-2">
            <option value="">Todos los eventos</option>
            @foreach ($eventos as $evento)
                <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
            @endforeach
        </x-select>
        <input class="ml-4" type="radio" name="genero" wire:model.live="genero" value="Masculino"> Masculino
        <input class="ml-4" type="radio" name="genero" wire:model.live="genero" value="Femenino"> Femenino
        <x-button class="ml-6 bg-red-700 hover:bg-slate-300 " wire:click="limpiar()" type="reset">Cancelar</x-button>
    </div>
    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto overflow-y-hidden">
        <table class="w-full text-center table-auto min-w-max">

            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Categoria</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Talla</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Agregadas</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Disponibles</p>
                    </th>

                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Genero</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Acciones
                        </p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $prenda)
                    <tr>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $prenda->prenda_categories_nombre }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $prenda->prenda_talla }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $prenda->cantidad }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                @if ($prenda->restadas == 0)
                                    {{ $prenda->cantidad }}
                                @else
                                    {{ $prenda->restadas }}
                                @endif
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $prenda->sexo }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">

                            <x-button class="bg-blue-500 shadow" wire:click="edit({{ $prenda->id }})">
                                Agregar
                            </x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $users->links() }}
        </div>
    </div>



    <form wire:submit="seve">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Registrar Prendas
            </x-slot>

            <x-slot name="content">
                <div class="grid grid-cols-2 gap-4">

                    <div class="mb-4">
                        <x-label for="">Categoria</x-label>
                        <x-select class="w-full" wire:model="create_prenda.prenda_category_id">
                            <option value="">Seleccione un Estado</option>
                            @foreach ($categorias as $categoria)
                                <option value=" {{ $categoria->id }}">
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </x-select>
                        @error('create_prenda.prenda_category_id')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Talla</x-label>
                        <x-select class="w-full" wire:model="create_prenda.prenda_talla_id">
                            <option value="">Seleccione un Estado</option>
                            @foreach ($tallas as $talla)
                                <option value=" {{ $talla->id }}">
                                    {{ $talla->talla }}
                                </option>
                            @endforeach
                        </x-select>
                        @error('create_prenda.prenda_talla_id')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Cantidad </x-label>
                        <x-input class="w-full" type="number" wire:model="create_prenda.cantidad" />
                        @error('create_prenda.cantidad')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Sexo</x-label>
                        <x-select class="w-full" wire:model="create_prenda.sexo"
                            wire:change="select_sexo($event.target.value)">
                            <option value="">Seleccione un Estado</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Masculino">Masculino</option>

                        </x-select>
                        @error('create_prenda.sexo')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Estado</x-label>
                        <x-select class="w-full" wire:model="create_prenda.estado">
                            <option value="">Seleccione un Estado</option>
                            <option value="0">Deshabilitado</option>
                            <option value="1">Habilitado</option>
                        </x-select>
                        @error('create_prenda.estado')
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
        <x-dialog-modal wire:model="open_update">
            <x-slot name="title">
                Actualizar Datos
            </x-slot>

            <x-slot name="content">
                <div class="grid grid-cols-2 gap-4">

                    <div class="mb-4">
                        <x-label for="">Categoria {{ $create_prenda['prenda_category_id'] }}</x-label>
                        <x-select class="w-full" wire:model="create_prenda.prenda_category_id">
                            <option value="">Seleccione un Estado</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </x-select>
                        @error('create_prenda.prenda_category_id')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Talla {{ $create_prenda['prenda_talla_id'] }}</x-label>
                        <x-select class="w-full" wire:model="create_prenda.prenda_talla_id">
                            <option value="">Seleccione un Estado</option>
                            @foreach ($tallas as $talla)
                                <option value="{{ $talla->id }}">{{ $talla->talla }}
                                </option>
                            @endforeach
                        </x-select>
                        @error('create_prenda.prenda_talla_id')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Cantidad </x-label>
                        <x-input class="w-full" type="number" wire:model="create_prenda.cantidad" />
                        @error('create_prenda.cantidad')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Sexo</x-label>
                        <x-select class="w-full" wire:model="create_prenda.sexo"
                            wire:change="select_sexo($event.target.value)">
                            <option value="">Seleccione un Estado</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Masculino">Masculino</option>

                        </x-select>
                        @error('create_prenda.sexo')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Estado</x-label>
                        <x-select class="w-full" wire:model="create_prenda.estado">
                            <option value="">Seleccione un Estado</option>
                            <option value="0">Deshabilitado</option>
                            <option value="1">Habilitado</option>
                        </x-select>
                        @error('create_prenda.estado')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button class="mr-2" wire:click="$set('open_update',false)">
                        Cancelar
                    </x-danger-button>

                    <x-button>
                        Agregar
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

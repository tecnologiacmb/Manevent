<div>
    <div class="bg-white shadow rounded-lg p-2 mb-4 flex items-center justify-between">
        <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal">
            Lista de Grupos Registrados
        </h1>
        <x-button class="shadow" wire:click="agg">
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
                            Tipo
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Name
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Costo $
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Costo Bs
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Status
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
                @foreach ($posts as $post)
                    @foreach ($recorridos as $recorrido)
                        @if ($post->recorrido_id == $recorrido->id)
                            <tr>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $post->id }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $recorrido->nombre }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $post->nombre }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $post->precio }} $
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $this->calculo($post->precio) }} Bs
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $post->estado }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <a href="#"
                                        class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $posts->links() }}
        </div>
    </div>

    <form wire:submit="seve">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar Post
            </x-slot>

            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="">Categoria </x-label>
                    <x-select class="w-full" wire:model="postCreate.recorrido_id">
                        <option value="">Seleccione una categoria</option>
                        @foreach ($recorridos as $post)
                            <option value="{{ $post->id }}">
                                {{ $post->nombre }}</option>
                        @endforeach
                    </x-select>
                </div>


                <div class="mb-4">
                    <x-label for="">Nombre</x-label>
                    <x-input class="w-full" wire:model="postCreate.nombre" />
                </div>

                <div class="h-28 grid grid-cols-3 gap-4 content-start ">
                    <div class="mb-4">
                        <x-label for="">Costo $</x-label>
                        <x-input class="w-full" type="number" step="0.01" wire:model="postCreate.precio" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Valor</x-label>
                        <x-input class="w-full" type="number" wire:model="postCreate.cantidad" />
                    </div>


                    <div class="mb-4">
                        <x-label for="">Status</x-label>
                        <x-select class="w-full" wire:model="postCreate.estado">
                            <option value="" disabled>Seleccione un Estado</option>
                            <option value="0">Deshabilitado</option>
                            <option value="1">Habilitado</option>


                        </x-select>
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
</div>
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
    </script>
@endpush
</div>

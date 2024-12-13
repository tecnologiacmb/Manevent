<div>
    <div class="bg-white shadow rounded-lg p-2 mb-4 flex items-center justify-between">
        <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal">
            Lista de Bancos Registrados
        </h1>
        <x-button class="shadow" wire:click="agg">
            Agregar
        </x-button>
    </div>

    <div class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-hidden overflow-y-hidden">


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
                            Name
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Codigo
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            status
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
                    @foreach ($posts as $post)
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->id }}
                            </p>
                        </td>

                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->name }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->codigo }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->status }}
                            </p>
                        </td>

                        <td class="p-4 border-b border-blue-gray-50">
                            <a href="#"
                                class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                Edit
                            </a>
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
                    Actualizar Post
                </x-slot>

                <x-slot name="content">
                    <div class="mb-4">
                        <x-label for="">Banco</x-label>
                        <x-input class="w-full" wire:model="postCreate.name" />
                    </div>
                    <div class="mb-4">
                        <x-label for="">Codigo</x-label>
                        <x-input type="number" class="w-full" wire:model="postCreate.codigo" />
                    </div>
                    <div class="mb-4">
                        <x-label for="">Estado</x-label>
                        <x-select class="w-full" wire:model="postCreate.status">
                            <option value="">Seleccione un Estado</option>
                            <option value="0">Deshabilitado</option>
                            <option value="1">Habilitado</option>
                        </x-select>
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


</div>

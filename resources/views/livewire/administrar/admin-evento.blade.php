<div>
    <div class="bg-white shadow rounded-lg p-2 mb-4 flex items-center justify-between">
        <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal">
            Eventos Registrados
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
                @foreach ( $evento as $post )


                    <td class="p-4 border-b border-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                            {{$post->id}}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                            {{$post->name}}
                        </p>
                    </td>


                    <td class="p-4 border-b border-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                            {{$post->inicio}}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                            {{$post->finalizacion}}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                            {{$post->status}}
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <a href="#"
                            class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                            Edit
                        </a>

                  </td>

                @endforeach
            </tr>

        </tbody>

    </table>


    <form wire:submit="seve" >
        <x-dialog-modal wire:model="open" >
            <x-slot name="title">
                Actualizar Post
            </x-slot>

            <x-slot name="content">

                <div class="mb-4">
                    <x-label for="">Nombre del Evento</x-label>
                    <x-input  class="w-full" wire:model="post_create.name"  />
                </div>
                <div class="grid grid-cols-2 gap-4">


                <div class="mb-4">
                    <x-label for="">Lugar</x-label>
                    <x-input  class="w-full"  wire:model="post_create.lugar"/>
                </div>
                <div class="mb-4">
                    <x-label for="">Inicia</x-label>
                    <x-input type="date" class="w-full" wire:model="post_create.inicio" />
                </div>

                <div class="mb-4">
                    <x-label for="">Finaliza</x-label>
                    <x-input type="date" class="w-full" wire:model="post_create.finalizacion" />
                </div>



                <div class="mb-4">
                    <x-label for="">Fecha de Realización</x-label>
                    <x-input type="date" class="w-full"  wire:model="post_create.fecha_evento"/>
                </div>

                <div class="mb-4">
                    <x-label for="">Estado</x-label>
                    <x-select class="w-full" wire:model="post_create.status">
                        <option value="" disabled >Seleccione un Estado</option>
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

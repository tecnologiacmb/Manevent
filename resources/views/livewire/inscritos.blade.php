<div>
    <div class="bg-white shadow rounded-lg p-4 mb-2">
        <h1 class="font-black text-xl text-gray-800 leading-tight text-normal text-center">
            Inscripciones
        </h1>

        <div class="flex items-center">
            <input type="text" wire:model.live="query" placeholder="Buscar..."
                class="w-5/12 px-4 mt-2 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />

            <x-select wire:model.live="eventoId" class="ml-2 mt-2">
                <option value="">Todos los eventos</option>
                @foreach ($eventos as $evento)
                    <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                @endforeach
            </x-select>

            <label for="" class="ml-2">Inicio</label>
            <input type="date" wire:model.live="startDate"
                class="w-1/6 px-4 mt-2 ml-1 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />

            <label for="" class="ml-2">Fin</label>
            <input type="date" wire:model.live="endDate"
                class="w-1/6 px-4 mt-2 ml-1 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />

            <x-button class="ml-2 bg-red-700 hover:bg-slate-300 " wire:click="limpiar()"
                type="reset">Cancelar</x-button>
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
                            N° Orden
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            cedula
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Recorrido
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Mesa
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            IP
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Monto $
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Fecha
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Detalles
                        </p>
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($inscripciones as $inscripcion)
                    <tr>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $inscripcion->nomenclatura }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $inscripcion->cedula }}

                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $inscripcion->nombre_recorrido }}

                            </p>
                        </td>

                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $inscripcion->mesa_nombre }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $inscripcion->ip }}

                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $inscripcion->precio }}

                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $inscripcion->created_at }}

                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <x-button class="bg-blue-500"><a href="incripcion/vista_inscripcion/{{ $inscripcion->id }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </x-button>

                        </td>
                        {{--   <td class="p-4 border-b border-blue-gray-50">
                       <x-button class="bg-blue-500"><a href="#"
                               class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                               <i class="bi bi-pencil-square"></i>
                           </a></x-button>
                           <x-danger-button class="bg-blue-500"><a href="#"
                               class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                               <i class="bi bi-trash-fill"></i>
                           </a></x-danger-button>
                                 </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $inscripciones->links() }}
        </div>
    </div>


</div>

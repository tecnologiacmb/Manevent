<div>
    <div class="w-full max-[500px]:w-full mb-2">
        <div
            class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] justify-between">
            <div>
                <p class="pt-2 text-black text-2xl pl-8">Inscripciones</p>
                <p class="mx-4 text-black text-xl pl-4 group-hover:text-blue-900">Total:
                    {{ $this->cantidad_inscripcion }} </p>
            </div>
            <div>
                <p class="text-center text-black text-2xl pt-8 group-hover:text-green-800">Lista de Inscripciones</p>
            </div>

            <div>
                <img src="{{ asset('storage/image/inscripcion.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            </div>
            <br>
        </div>
    </div>

    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto overflow-y-hidden">
        <div class="flex items-center px-4 justify-between mb-8">
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

            <x-danger-button class="ml-2 mt-1 bg-red-700" wire:click="limpiar()" type="reset">Cancelar</x-danger-button>
        </div>
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
                            <x-button class="bg-blue-500 hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"><a
                                    href="incripcion/vista_inscripcion/{{ $inscripcion->id }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </x-button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $inscripciones->links() }}
        </div>
    </div>


</div>

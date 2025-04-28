<div>
    <div class="bg-white shadow rounded-lg p-4 mb-2">
        <h1 class="mx-2 font-black text-xl text-gray-800 leading-tight text-normal text-stard">
           Participantes Inscritos: {{ $ParticipanteEvento }}
        </h1>

        <div class="flex items-center">
            <input type="text" wire:model.live="query" placeholder="Buscar..."
                class="w-5/12 px-4 mt-2 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />
            <label for="" class="ml-2">Inicio</label>
            <input type="date" wire:model.live="startDate"
                class="w-1/6 px-4 mt-2 ml-1 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />

            <label for="" class="ml-2">Fin</label>
            <input type="date" wire:model.live="endDate"
                class="w-1/6 px-4 mt-2 ml-1 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300"
                style="display: block" />

            <input class="ml-2" type="radio" name="genero" wire:model.live="genero" value="1"> Hombre
            <input class="ml-2" type="radio" name="genero" wire:model.live="genero" value="2"> Mujer
            <x-danger-button class="ml-2 bg-red-700" wire:click="limpiar()" type="reset">Cancelar</x-danger-button>
        </div>
    </div>


    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto overflow-y-hidden">

        <table class="w-full text-center table-auto min-w-max">
            <thead>
                <tr>

                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Cedula
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Nombre
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Apellido
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Estado
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Ciudad
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Fecha de nacimiento
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
                @foreach ($user as $participante)
                    <tr>

                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $participante->cedula }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $participante->nombre }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $participante->apellido }}
                            </p>
                        </td>

                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $participante->estado_nombre }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $participante->ciudad_nombre }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $participante->fecha_nacimiento }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <x-button class="bg-blue-500 hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300">
                                <a href="/vista_usuarios/detalle/{{ $participante->id }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <div>
            {{ $user->links() }}
        </div>
    </div>

</div>

<div>
    <div class="w-full max-[500px]:w-full mb-2">
        <div
            class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] justify-between">
            <div>
                <p class="pt-2 text-black text-2xl pl-8">Participantes</p>
                <p class="mx-4 text-black text-xl pl-4 group-hover:text-blue-900">Total: {{ $ParticipanteEvento }} </p>
            </div>
            <div>
                <p class="text-center text-black text-2xl pt-8 group-hover:text-green-800">Lista de participantes</p>
            </div>

            <div>
                <img src="{{ asset('storage/image/participantes.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            </div>
            <br>
        </div>
    </div>
    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto overflow-y-hidden">
        <div class="flex items-center justify-between mb-8">
            <input type="text" wire:model.live="query" placeholder="Buscar..."
                class="w-1/5 px-8 mt-2 ml-4 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />
            <label for="" class="ml-1">Inicio</label>
            <input type="date" wire:model.live="startDate"
                class="w-1/6 px-4 mt-2 ml-1 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />

            <label for="" class="ml-1">Fin</label>
            <input type="date" wire:model.live="endDate"
                class="w-1/6 px-4 mt-2 ml-1 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300"
                style="display: block" />

            <input class="ml-2" type="radio" name="genero" wire:model.live="genero" value="1">
            <label for="" class="mr-2">Hombre</label>

            <input class="mr-2" type="radio" name="genero" wire:model.live="genero" value="2">
            <label for="" class="mr-2">Mujer</label>

            <x-danger-button class="mr-4 bg-red-700" wire:click="limpiar()" type="reset">Cancelar</x-danger-button>
        </div>
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

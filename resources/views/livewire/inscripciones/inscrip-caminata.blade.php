<div>
    <div class="w-full max-[500px]:w-full mb-2">
        <div
            class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] justify-between">
            <div>
                <p
                    class="px-12 text-center font-black text-2xl leading-tight text-normal pt-8 group-hover:text-green-800">
                    Selecione un Grupo para la Caminata</p>
            </div>
            <div>
                <img src="{{ asset('storage/image/caminar.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[30%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-20">
            </div>
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
                            Nombre
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Participantes
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
                            Opción

                        </p>
                    </th>
                </tr>
            </thead>

            <tbody class=" capitalize">

                @foreach ($grupos as $grupo)
                    @if ($grupo->recorrido_id == 1)
                        <tr>

                            <td class="p-4 border-b border-blue-gray-50">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $grupo->nombre }}
                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $grupo->cantidad }}
                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $grupo->precio }} $
                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $this->calculo($grupo->precio) }} Bs
                                </p>
                            </td>

                            <td class="p-4 border-b border-blue-gray-50">
                                <x-button
                                    class="bg-blue-500 hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"><a
                                        href="/caminata/inscripcion/{{ $grupo->id }} "
                                        class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                        <i class="bi bi-pencil-square"></i>
                                    </a></x-button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</div>

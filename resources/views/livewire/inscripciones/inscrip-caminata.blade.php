<div>
    <div class="bg-white shadow rounded-lg p-4 mb-4">
        <h1 class="font-black text-xl text-gray-800 leading-tight text-normal">
            Selecione un Grupo para la Caminata
        </h1>

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
                        </p>

                    </th>
                </tr>
            </thead>

            <tbody>

                @foreach ($grupos as $post)

                @if ($post->recorrido_id == 1)


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
                                {{ $post->name }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->costo }} $
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{$this->calculo( $post->costo) }} Bs
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <a href="#"
                                class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                Edit
                            </a>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <a href="/caminata-inscripcion?groupId={{ $post->id }} "  target="_blank"
                                class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900" >
                                Seleccionar
                            </a>
                        </td>
                    </tr>
                    @endif

                @endforeach
            </tbody>
        </table>
    </div>

</div>
</div>
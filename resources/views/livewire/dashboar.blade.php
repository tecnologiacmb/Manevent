<div>
    <div class="grid grid-cols-3 w-full gap-6 max-[500px]:grid-cols-1  max-[500px]:w-full ">

        <a href="{{ route('reporte') }}" :active="request() - > routeIs('reporte')">
            <div
                class="group w-full p-2 rounded-lg bg-white shadow-xl transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-green-800 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Carrera/Caminata</p>
                <p class=" mx-4 text-blue-800 text-xl pl-4 group-hover:text-blue-500">{{ $totalMontoPagado }} Bs</p>
                <p class="mx-4 text-green-800 text-md pl-4 group-hover:text-green-600">
                    {{ $this->calculo($totalMontoPagado) }} $
                </p>

                <img src="{{ asset('storage/image/dolars.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>

            </div>
        </a>
        <a href="{{ route('incripcion') }}" :active="request() - > routeIs('incripcion')">
            <div
                class="group w-full rounded-lg bg-white shadow-xl border-1 transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-pink-800 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Evento Carrera</p>

                <p class="mx-4 text-pink-500 text-2xl pl-6 group-hover:text-pink-400">{{ $EventoCarrera }}</p>

                <div class="mt-4 mx-4 bg-slate-200 rounded-full h-4 relative">
                    <div class="bg-blue-500 rounded-full h-4" style="width: {{ $PorcentajeCarrera }}%;"></div>
                    <p
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                        {{ $PorcentajeCarrera }}%</p>
                </div>

                <img src="{{ asset('storage/image/carrera.png') }}" alt="Imagen de participante"
                    class="pt-4 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>
            </div>
        </a>
        <a href="{{ route('incripcion') }}" :active="request() - > routeIs('incripcion')">
            <div
                class="group w-full rounded-lg bg-white shadow-xl border-1 transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-orange-700 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Evento Caminata</p>

                <p class="mx-4 text-orange-600 text-2xl pl-6 group-hover:text-orange-500">{{ $EventoCaminata }}</p>

                <div class="mt-4 mx-4 bg-slate-200 rounded-full h-4 relative">
                    <div class="bg-blue-500 rounded-full h-4" style="width: {{ $PorcentajeCaminata }}%;"></div>
                    <p
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                        {{ $PorcentajeCaminata }}%</p>
                </div>

                <img src="{{ asset('storage/image/caminar.jpg') }}" alt="Imagen de participante"
                    class="pt-4 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>
            </div>
        </a>

        <a href="{{ route('vista_usuarios') }}" :active="request() - > routeIs('vista_usuarios')">
            <div
                class="group w-full rounded-lg bg-white shadow-xl border-1 transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-blue-800 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Participantes</p>
                <p class="mx-4 text-blue-800  text-2xl pl-6 group-hover:text-blue-500">{{ $ParticipanteEvento }}</p>

                <div class="mt-4 mx-4 bg-slate-200 rounded-full h-4 relative">
                    <div class="bg-blue-500 rounded-full h-4" style="width: {{ $porcentaje }}%;"></div>
                    <p
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                        {{ $porcentaje }}%</p>
                </div>

                <img src="{{ asset('storage/image/participantes.png') }}" alt="Imagen de participante"
                    class="pt-4 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>
            </div>
        </a>
        <a href="{{ route('vista_usuarios') }}" :active="request() - > routeIs('vista_usuarios')">
            <div
                class="group w-full rounded-lg bg-white shadow-xl border-1 transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-red-800 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Hombres</p>
                <p class="mx-4 text-red-700 text-2xl pl-6 group-hover:text-red-600">{{ $ParticipanteHombre }}</p>

                <div class="mt-4 mx-4 bg-slate-200 rounded-full h-4 relative">
                    <div class="bg-blue-500 rounded-full h-4" style="width: {{ $PorcentajeHombre }}%;"></div>
                    <p
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                        {{ $PorcentajeHombre }}%</p>
                </div>

                <img src="{{ asset('storage/image/hombre.png') }}" alt="Imagen de participante"
                    class="pt-4 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>
            </div>
        </a>
        <a href="{{ route('vista_usuarios') }}" :active="request() - > routeIs('vista_usuarios')">
            <div
                class="group w-full rounded-lg bg-white shadow-xl border-1 transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-purple-800 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Mujeres</p>
                <p class="mx-4 text-purple-600 text-2xl pl-6 group-hover:text-purple-500">{{ $ParticipanteMujer }}</p>

                <div class="mt-4 mx-4 bg-slate-200 rounded-full h-4 relative">
                    <div class="bg-blue-500 rounded-full h-4" style="width: {{ $PorcentajeMujer }}%;"></div>
                    <p
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                        {{ $PorcentajeMujer }}%</p>
                </div>

                <img src="{{ asset('storage/image/women.png') }}" alt="Imagen de participante"
                    class="pt-4 group-hover:opacity-100 absolute right-[5%] top-[30%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-24">
                <br>
            </div>
        </a>

    </div>
    <div class="py-6 grid grid-cols-4 w-full gap-6 max-[500px]:grid-cols-1  max-[500px]:w-full ">
        <a href="{{ route('franelas') }}" :active="request() - > routeIs('franelas')">
            <div
                class="group w-full rounded-lg bg-white shadow-xl border-1 transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-blue-800 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Franelas</p>
                <p class="mx-4 text-yellow-700 text-xl pl-4 group-hover:text-yellow-600">Talla: S</p>
                <p class="mx-4 text-red-800 text-sm pl-4 group-hover:text-red-700">Disponibles: {{ $Franelas_S }}
                </p>

                <img src="{{ asset('storage/image/franela1.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>
            </div>
        </a>
        <a href="{{ route('franelas') }}" :active="request() - > routeIs('franelas')">
            <div
                class="group w-full rounded-lg bg-white shadow-xl border-1 transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-blue-800 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Franelas</p>
                <p class="mx-4 text-cyan-800 text-xl pl-4 group-hover:text-cyan-600">Talla: M</p>
                <p class="mx-4 text-red-800 text-sm pl-4 group-hover:text-red-700">Disponibles: {{ $Franelas_M }}
                </p>

                <img src="{{ asset('storage/image/franela3.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>
            </div>
        </a>
        <a href="{{ route('franelas') }}" :active="request() - > routeIs('franelas')">
            <div
                class="group w-full rounded-lg bg-white shadow-xl border-1  transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-blue-800 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Franelas</p>
                <p class="mx-4 text-lime-800 text-xl pl-4 group-hover:text-lime-700">Talla: L</p>
                <p class="mx-4 text-red-800 text-sm pl-4 group-hover:text-red-700">Disponibles: {{ $Franelas_L }}
                </p>

                <img src="{{ asset('storage/image/franela2.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>
            </div>
        </a>
        <a href="{{ route('franelas') }}" :active="request() - > routeIs('franelas')">
            <div
                class="group w-full rounded-lg bg-white shadow-xl border-1  transition relative duration-300 cursor-pointer hover:translate-y-[3px] text-black hover:text-blue-800 hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-xl pl-8">Franelas</p>
                <p class="mx-4 text-purple-800 text-xl pl-4 group-hover:text-purple-600">Talla: XL</p>
                <p class="mx-4 text-red-800 text-sm pl-4 group-hover:text-red-700">Disponibles: {{ $Franelas_XL }}
                </p>

                <img src="{{ asset('storage/image/franela4.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>
            </div>
        </a>

    </div>
    <div class="bg-white p-4 rounded-xl shadow-2xl font-semibold text-white max-w-sm mx-auto">
        @foreach ($rolSeleccionado as $user)
            @php
                // Comparar si el usuario en la lista es el usuario en sesión
                $isCurrentUser = $user->id_model_rol === $currentUserId;
            @endphp
            <div class="flex items-center space-x-4 p-3 rounded-lg">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && $user->profile_photo_path)
                    <!-- Fotos de perfil si existen -->
                    <img class="h-10 w-10 rounded-full object-cover"
                        src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                @else
                    <!-- Inicial si no -->
                    <span
                        class="inline-flex rounded-full bg-black h-10 w-10 items-center justify-center text-white font-semibold uppercase">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                @endif
                <div class="flex-1 flex items-center justify-between">
                    <p class="text-black font-semibold">{{ $user->name }}</p>
                    <p class="text-black font-semibold">{{ $user->rol_name }}</p>

                    <!-- Punto verde solo si es usuario en sesión: -->
                    <span class="{{ $isCurrentUser ? 'bg-green-500' : 'bg-red-500' }} h-3 w-3 rounded-full"></span>
                </div>
            </div>
        @endforeach

    </div>
     <div class="grid grid-cols-3 w-full gap-6 max-[500px]:grid-cols-1  max-[500px]:w-full ">

     </div>
</div>

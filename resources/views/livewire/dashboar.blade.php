<div>
    <div class="grid grid-cols-3 w-[960px] gap-6 max-[500px]:grid-cols-1  max-[500px]:w-full px-3">

        <div
            class="group w-full rounded-lg bg-slate-300  transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
            <p class="py-2 text-black text-xl pl-8">Carrera/Caminata</p>
            <p class="mx-4 text-black text-xl pl-4 group-hover:text-blue-900">{{ $totalMontoPagado }} Bs</p>
            <p class="mx-4 text-black text-md pl-4 group-hover:text-green-800">{{ $this->calculo($total) }}
                $</p>

            <img src="{{ asset('storage/image/dolar.png') }}" alt="Imagen de dolar almacenada en storage"
                class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            <br>
        </div>
        <div
            class="group w-full rounded-lg bg-slate-300 transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
            <p class="py-2 text-black text-xl pl-8">Evento Carrera</p>

            <p class="mx-4 text-black text-2xl pl-6 group-hover:text-blue-900">{{ $EventoCarrera }}</p>

            <div class="mt-4 mx-4 bg-gray-200 rounded-full h-4 relative">
                <div class="bg-blue-500 rounded-full h-4" style="width: {{ $PorcentajeCarrera }}%;"></div>
                <p class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                    {{ $PorcentajeCarrera }}%</p>
            </div>

            <img src="{{ asset('storage/image/corredor.png') }}" alt="Imagen de participante"
                class="pt-4 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            <br>
        </div>
        <div
            class="group w-full rounded-lg bg-slate-300 transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
            <p class="py-2 text-black text-xl pl-8">Evento Caminata</p>

            <p class="mx-4 text-black text-2xl pl-6 group-hover:text-blue-900">{{ $EventoCaminata }}</p>

            <div class="mt-4 mx-4 bg-gray-200 rounded-full h-4 relative">
                <div class="bg-blue-500 rounded-full h-4" style="width: {{ $PorcentajeCaminata }}%;"></div>
                <p class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                    {{ $PorcentajeCaminata }}%</p>
            </div>

            <img src="{{ asset('storage/image/caminar.png') }}" alt="Imagen de participante"
                class="pt-4 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            <br>
        </div>

        <a href="{{ route('vista_usuarios') }}" :active="request() - > routeIs('vista_usuarios')">
            <div
                class="group w-full rounded-lg bg-slate-300 transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
                <p class="py-2 text-black text-xl pl-8">Participantes</p>
                <p class="mx-4 text-black text-2xl pl-6 group-hover:text-blue-900">{{ $ParticipanteEvento }}</p>

                <div class="mt-4 mx-4 bg-gray-200 rounded-full h-4 relative">
                    <div class="bg-blue-500 rounded-full h-4" style="width: {{ $porcentaje }}%;"></div>
                    <p
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                        {{ $porcentaje }}%</p>
                </div>

                <img src="{{ asset('storage/image/participante.png') }}" alt="Imagen de participante"
                    class="pt-4 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
                <br>
            </div>
        </a>
        <div
            class="group w-full rounded-lg bg-slate-300 transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
            <p class="py-2 text-black text-xl pl-8">Hombres</p>
            <p class="mx-4 text-black text-2xl pl-6 group-hover:text-blue-900">{{ $ParticipanteEvento }}</p>

            <div class="mt-4 mx-4 bg-gray-200 rounded-full h-4 relative">
                <div class="bg-blue-500 rounded-full h-4" style="width: {{ $porcentaje }}%;"></div>
                <p class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                    {{ $porcentaje }}%</p>
            </div>

            <img src="{{ asset('storage/image/hombre.png') }}" alt="Imagen de participante"
                class="pt-4 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            <br>
        </div>
        <div
        class="group w-full rounded-lg bg-slate-300 transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
        <p class="py-2 text-black text-xl pl-8">Mujeres</p>
        <p class="mx-4 text-black text-2xl pl-6 group-hover:text-blue-900">{{ $ParticipanteEvento }}</p>

        <div class="mt-4 mx-4 bg-gray-200 rounded-full h-4 relative">
            <div class="bg-blue-500 rounded-full h-4" style="width: {{ $porcentaje }}%;"></div>
            <p
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm text-gray-700">
                {{ $porcentaje }}%</p>
        </div>

        <img src="{{ asset('storage/image/mujer.png') }}" alt="Imagen de participante"
            class="pt-4 group-hover:opacity-100 absolute right-[8%] top-[35%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
        <br>
    </div>
    </div>
    <div class="py-6 grid grid-cols-4 w-[960px] gap-6 max-[500px]:grid-cols-1  max-[500px]:w-full px-3">
        <div
            class="group w-full rounded-lg bg-slate-300  transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
            <p class="py-2 text-black text-xl pl-8">Franelas</p>
            <p class="mx-4 text-black text-xl pl-4 group-hover:text-blue-800">Talla: S</p>
            <p class="mx-4 text-black text-sm pl-4 group-hover:text-red-800">Disponibles: {{ $Franelas_S }}
            </p>

            <img src="{{ asset('storage/image/franela.png') }}" alt="Imagen de dolar almacenada en storage"
                class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            <br>
        </div>
        <div
            class="group w-full rounded-lg bg-slate-300  transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
            <p class="py-2 text-black text-xl pl-8">Franelas</p>
            <p class="mx-4 text-black text-xl pl-4 group-hover:text-blue-800">Talla: M</p>
            <p class="mx-4 text-black text-sm pl-4 group-hover:text-red-800">Disponibles: {{ $Franelas_M }}
            </p>

            <img src="{{ asset('storage/image/franela.png') }}" alt="Imagen de dolar almacenada en storage"
                class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            <br>
        </div>

        <div
            class="group w-full rounded-lg bg-slate-300  transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
            <p class="py-2 text-black text-xl pl-8">Franelas</p>
            <p class="mx-4 text-black text-xl pl-4 group-hover:text-blue-800">Talla: L</p>
            <p class="mx-4 text-black text-sm pl-4 group-hover:text-red-800">Disponibles: {{ $Franelas_L }}
            </p>

            <img src="{{ asset('storage/image/franela.png') }}" alt="Imagen de dolar almacenada en storage"
                class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            <br>
        </div>
        <div
            class="group w-full rounded-lg bg-slate-300  transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000]">
            <p class="py-2 text-black text-xl pl-8">Franelas</p>
            <p class="mx-4 text-black text-xl pl-4 group-hover:text-blue-800">Talla: Xl</p>
            <p class="mx-4 text-black text-sm pl-4 group-hover:text-red-800">Disponibles: {{ $Franelas_XL }}
            </p>

            <img src="{{ asset('storage/image/franela.png') }}" alt="Imagen de dolar almacenada en storage"
                class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            <br>
        </div>
    </div>

</div>

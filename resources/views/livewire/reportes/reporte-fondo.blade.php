<div>
    <div class="bg-white shadow rounded-lg p-4 mb-2 px-8">
        <input type="text" wire:model.live="query" placeholder="Buscar..."
            class="w-4/5 px-8 mt-2 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />

        <x-button class="ml-4 bg-red-700 hover:bg-slate-300 " wire:click="limpiar()" type="reset">Cancelar</x-button>
    </div>
    <div
        class="relative flex flex-col w-full h-full overflow-hidden text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto">
        <table class="w-full text-center table-auto min-w-max">
            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Cod_Inscrip</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Fecha</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Recorrido</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Cantidad</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Monto $</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Total Bs</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Detalles</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reporte as $report)
                    <tr>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $report->nomenclatura }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $report->created_at->format('d-m-Y') }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $report->recorrido }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $report->cantidad }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{--  @php
                                    $datos = json_decode($report->datos);
                                @endphp
                                @if (isset($datos->monto_Bs))
                                    {{ $datos->monto_Bs }}
                                @elseif(isset($datos->{'monto_$'}))
                                    {{ $datos->{'monto_$'} }}
                                @elseif(isset($datos->monto_mixto_Bs))
                                    {{ $datos->monto_mixto_Bs }}
                                @elseif(isset($datos->{'monto_mixto_$'}))
                                    {{ $datos->{'monto_mixto_$'} }}
                                @else
                                    asd
                                @endif --}}
                                {{ $report->precio }}</p>

                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $report->monto_pagado_bs }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <x-button class="bg-blue-500" wire:click="abrir('{{ $report->nomenclatura }}')">
                                <i class="bi bi-pencil-square"></i>
                            </x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <button type="button" wire:click="download()">Download</button>  {{-- {{ $inscripciones->links() }} --}}
        </div>
    </div>

    <x-dialog-report wire:model="open">
        <x-slot name="title">
            Detalles
        </x-slot>

        <x-slot name="content">
            <div class="">
                <table class="w-full text-center min-w-max shadow-md">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="p-4 border-b border-blue-300">Cod. Inscrip</th>
                            <th class="p-4 border-b border-blue-300">N° Referencia</th>
                            <th class="p-4 border-b border-blue-300">Cédula</th>
                            <th class="p-4 border-b border-blue-300">Recorrido</th>
                            <th class="p-4 border-b border-blue-300">Fecha</th>
                            <th class="p-4 border-b border-blue-300">Monto $</th>
                            <th class="p-4 border-b border-blue-300">Monto Bs</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @php
                            $totalBs = 0; // Inicializa la suma de montos en bolívares
                            $totalBsMixto = 0; // Inicializa la suma de montos mixtos en bolívares
                        @endphp

                        @if ($detalles)
                            @foreach ($detalles as $detalle)
                                @php
                                    $datos = json_decode($detalle->datos);
                                    // Sumar los montos en bolívares si existen
                                    if (isset($datos->monto_Bs)) {
                                        $totalBs += $datos->monto_Bs;
                                    } elseif (isset($datos->monto_mixto_Bs)) {
                                        $totalBsMixto += $datos->monto_mixto_Bs;
                                    }
                                @endphp
                                <tr class="hover:bg-blue-100 border-b border-blue-200 transition duration-200">
                                    <td class="p-4">{{ $detalle->nomenclatura }}</td>
                                    <td class="p-4">
                                        {{ isset($datos->referencia) ? $datos->referencia : $datos->referencia_mixta }}
                                    </td>
                                    <td class="p-4">{{ $detalle->cedula }}</td>
                                    <td class="p-4">{{ $detalle->recorrido }}</td>
                                    <td class="p-4">{{ $detalle->created_at->format('d-m-Y') }}</td>
                                    <td class="p-4">
                                        @if (isset($datos->monto_USD) || isset($datos->monto_mixto_USD))
                                            @if (isset($datos->monto_USD))
                                                {{ $datos->monto_USD }}
                                            @else
                                                {{ $datos->monto_mixto_USD }}
                                            @endif
                                        @else
                                            @if (isset($datos->monto_Bs))
                                                {{ $this->calcular($datos->monto_Bs) }}
                                            @else
                                                {{ $this->calcular($datos->monto_mixto_Bs) }}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        @if (isset($datos->monto_Bs) || isset($datos->monto_mixto_Bs))
                                            @if (isset($datos->monto_Bs))
                                                {{ $datos->monto_Bs }}
                                            @else
                                                {{ $datos->monto_mixto_Bs }}
                                            @endif
                                        @else
                                            @if (isset($datos->monto_Bs))
                                                {{ $this->calcular_Bs($datos->monto_USD) }}
                                            @else
                                                {{ $this->calcular_Bs($datos->monto_mixto_USD) }}
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="bg-blue-200">
                                <td colspan="6" class="p-4 text-right font-bold">Total:</td>
                                <td class="p-4 font-bold text-blue-700">
                                    {{ $totalBs + $totalBsMixto }}
                                    <!-- Muestra la suma total de bolívares y bolívares mixtos -->
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="7" class="p-4 text-center text-red-500">No hay detalles disponibles.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-danger-button class="mr-2" wire:click="$set('open', false)">
                    Cerrar
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-report>

</div>

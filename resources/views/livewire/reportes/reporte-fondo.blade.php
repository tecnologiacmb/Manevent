<div>
    <div class="w-full max-[500px]:w-full mb-2">
        <div
            class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] justify-between">
            <div>
                <p class="pt-2 text-black text-2xl pl-8 group-hover:text-green-800">Carrera/Caminata</p>
                <p class="mx-4 text-blue-700 text-xl pl-4 group-hover:text-blue-900">{{ $totalMontoPagado }} Bs</p>
                <p class="mx-4 text-green-700 text-md pl-4 group-hover:text-green-800">
                    {{ $this->calculo($totalMontoPagado) }} $</p>
            </div>
            <div>
                <p class="text-center text-black text-2xl pt-8 group-hover:text-green-800">Fondos Recaudados</p>
            </div>

            <div>
                <img src="{{ asset('storage/image/dolars.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute right-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            </div>
            <br>
        </div>

    </div>
    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto overflow-y-hidden">
        <div class="absolute w-full pb-4 pt-2 px-4">

            <x-select wire:model.live="eventoId" class="ml-2 mt-2">
                <option value="">Todos los eventos</option>
                @foreach ($eventos as $evento)
                    <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                @endforeach
            </x-select>
            <label for="" class="ml-1">Inicio</label>
            <input type="date" wire:model.live="dateFrom"
                class="w-1/6 px-2 mt-2 ml-1 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />
            <label for="" class="ml-1">Fin</label>
            <input type="date" wire:model.live="dateTo"
                class="w-1/6 px-2 mt-2 ml-1 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />

            <x-select class="w-1/6" wire:model="valor" wire:change=updateReporte($event.target.value)>
                <option value="">Tipo de Reporte</option>
                <option value="reporteDetallado">Reporte Detallado</option>
                <option value="reporteGlobal">Reporte Global</option>
            </x-select>

            @if ($GenerarReporte == 'reporteDetallado')
                <x-button class="ml-1 bg-red-700 hover:bg-red-400 focus:bg-red-400 active:bg-red-400" type="button"
                    wire:click='generateDetailedReport'>
                    PDF
                </x-button>
                <x-button class="ml-1 bg-green-700 hover:bg-green-400 focus:bg-green-400 active:bg-green-400"
                    type="button" wire:click='generateDetailedReportExcel'>
                    Excel
                </x-button>
            @elseif ($GenerarReporte == 'reporteGlobal')
                <x-button class="ml-1 bg-red-700 hover:bg-red-400 focus:bg-red-400 active:bg-red-400" type="button"
                    wire:click='generateReportGlobal'>
                    PDF
                </x-button>
                <x-button class="ml-1 bg-green-700 hover:bg-green-400 focus:bg-green-400 active:bg-green-400"
                    type="button" wire:click='generateGlobalReportExcel'>
                    Excel
                </x-button>
            @endif
            <hr class="mt-2 opacity-70">

        </div>
        <table class="mt-24 w-full text-center table-auto min-w-max">
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
                            Valor del $</p>
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

                                {{ $report->dolar }} Bs</p>

                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">

                                {{ $this->calculo($report->monto_a_pagar_bs) }} </p>

                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $report->monto_a_pagar_bs }}</p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <x-button class="bg-blue-500 hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                                wire:click="abrir('{{ $report->nomenclatura }}')">
                                <i class="bi bi-pencil-square"></i>
                            </x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>


        </div>
    </div>

    <x-dialog-report wire:model="open">
        <x-slot name="title">
            <h1 class="fons-bold text-2xl">Detalles de Inscripción</h1>
        </x-slot>
        <x-slot name="content">
            <div class="">
                <table class="w-full text-center min-w-max shadow-md">
                    <thead>
                        <tr class="text-white" style=" background-color: #12a612;">
                            <th class="p-4 border-b ">Cod. Inscrip</th>
                            <th class="p-4 border-b ">Cédula</th>
                            <th class="p-4 border-b ">Recorrido</th>
                            <th class="p-4 border-b ">Fecha</th>
                            <th class="p-4 border-b ">N°1 Referencia</th>
                            <th class="p-4 border-b ">Monto $</th>
                            <th class="p-4 border-b ">Monto Bs</th>
                            <th class="p-4 border-b ">N°2 Referencia</th>
                            <th class="p-4 border-b ">Monto $</th>
                            <th class="p-4 border-b ">Monto Bs</th>
                            <th class="p-4">Total Monto</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @php
                            $totalBs = 0; // Inicializa la suma de montos en bolívares
                            $totalBsMixto = 0; // Inicializa la suma de montos mixtos en bolívares
                            $totalMonto = 0; // Inicializa la suma total
                        @endphp

                        @if ($detalles)
                            @foreach ($detalles as $detalle)
                                @php
                                    $datos = json_decode($detalle->datos);
                                    $montoBs = $datos->monto_Bs ?? 0;
                                    $montoMixtoBs = $datos->monto_mixto_Bs ?? 0;

                                    // Sumar los montos en bolívares si existen
                                    $totalBs += $montoBs;
                                    $totalBsMixto += $montoMixtoBs;

                                    // Calcular el total monto en dólares y bolívares
                                    $montoUSD1 = $datos->monto_USD ?? 0;
                                    $montoUSD2 = $datos->monto_mixto_USD ?? 0;
                                    $totalMontoPorFila =
                                        $montoUSD1 * $detalle->dolar_precio +
                                        $montoUSD2 * $detalle->dolar_precio +
                                        $montoBs +
                                        $montoMixtoBs;
                                    $totalMonto += $totalMontoPorFila; // Suma total
                                @endphp
                                <tr class="border-b  transition duration-200">
                                    <td class="p-4">{{ $detalle->nomenclatura }}</td>
                                    <td class="p-4">{{ $detalle->cedula }}</td>
                                    <td class="p-4">{{ $detalle->recorrido }}</td>
                                    <td class="p-4">{{ $detalle->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $datos->referencia ?? 'N/A' }}</td>
                                    <td>{{ $montoUSD1 }}</td>
                                    <td>{{ $montoBs }}</td>
                                    <td>{{ $datos->referencia_mixto ?? 'N/A' }}</td>
                                    <td>{{ $montoUSD2 }}</td>
                                    <td>{{ $montoMixtoBs }}</td>
                                    <td>{{ $totalMontoPorFila }}</td>
                                </tr>
                            @endforeach

                            <tr style=" background-color: #59de4d31;">
                                <td colspan="10" class="p-4 text-right font-bold text-black">Total:</td>
                                <td class="p-4 font-bold text-black">
                                    {{ $totalMonto }}
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
                <x-danger-button class="mr-2" wire:click="$set('open', false,'detalles',null)">
                    Cerrar
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-report>

</div>

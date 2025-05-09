<style>
    .table-container {
        overflow-x: auto;
        /* Habilitar desplazamiento horizontal en pantallas pequeñas */
        width: auto;
        /* Cambiar de 100% a auto para que tome el ancho completo de la hoja */
        margin: -30px;
        /* Asegura que no haya margen */
    }

    table {
        width: 100vw;
        /* Asegura que la tabla use el ancho total de la ventana (viewport) */
        table-layout: auto;
        /* Permite que el ancho de las columnas se ajuste automáticamente */
    }

    .shadow-md {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Sombra suave */
    }

    .border-collapse {
        border-collapse: collapse;
        /* Colapsar bordes de la tabla */
    }

    thead {
        background-color: #f5f5f5;
        /* Color de fondo del encabezado */
    }

    th,
    td {
        padding: 10px;
        /* Aumenta el padding si es necesario para una mejor legibilidad */
        font-size: 12px;
        /* Tamaño de fuente */
        word-wrap: break-word;
        /* Permitir ruptura de palabras largas */
    }

    th {
        background-color: #12a612;
        /* Color de fondo para encabezados */
        color: #ffffff;
        /* Color de texto del encabezado */
        font-weight: bold;
        /* Texto en negrita */
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
        /* Color de fondo alterno en filas */
    }

    p {
        margin: 0;
        /* Eliminar márgenes en párrafos */
    }

    td {
        border-bottom: 1px solid #ddd;
        /* Separadores entre filas */
        white-space: nowrap;
        /* Asegura que el texto en celdas no se envuelva */
    }

    td:hover {
        background-color: #f1f1f1;
        /* Efecto hover en celdas */
    }

    .text-center {
        text-align: center;
        /* Alineación del texto en el centro */
    }

    .text-right {
        text-align: right;
        /* Alineación del texto a la derecha */
    }

    .font-bold {
        font-weight: bold;
        /* Texto en negrita */
    }

    .text-blue-700 {
        color: #1e3a8a;
        /* Color azul para total */
    }

    .text-red-500 {
        color: #ef4444;
        /* Color rojo para mensajes de error */
    }
</style>

<div class="table-container">
    <div style="margin-top: -4%;">
        <h1 class="text-center" style="margin-bottom: -1%;">Reporte del Día</h1>
        @if (isset($dateFromFormatted) && isset($dateToFormatted))
            <h2 class="text-center" style="margin-bottom: -2%;">{{ $dateFromFormatted }} Hasta {{ $dateToFormatted }}
            </h2>
        @endif

        <h4 class="text-center" style="margin-bottom: 1%;">Fondos recaudados por Fundamamas en el evento
            @if ($detalles)
                @if (!empty($eventoId))
                    en el evento: {{ $detalles->first()->evento }}
                @else
                    en todos los eventos
                @endif
            @endif
        </h4>
    </div>
    <table class="text-center min-w-max shadow-md border-collapse">
        <thead>
            <tr>
                <th class="p-4">Cod</th>
                <th class="p-4">Cédula</th>
                <th class="p-4">Recorr.</th>
                <th class="p-4">Fecha</th>
                <th class="p-4">Precio $</th>
                <th class="p-4">Refe. I</th>
                <th class="p-4">Monto$ I</th>
                <th class="p-4">MontoBs I</th>
                <th class="p-4">Refe. II</th>
                <th class="p-4">Monto$ II</th>
                <th class="p-4">MontoBs II</th>
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
                            $montoUSD1 * $detalle->dolar + $montoUSD2 * $detalle->dolar + $montoBs + $montoMixtoBs;
                        $totalMonto += $totalMontoPorFila; // Suma total
                    @endphp
                    <tr>
                        <td>{{ $detalle->nomenclatura }}</td>
                        <td>{{ $detalle->cedula }}</td>
                        <td>{{ $detalle->recorrido }}</td>
                        <td>{{ $detalle->created_at->format('d-m-Y') }}</td>
                        <td>{{ $detalle->dolar }}</td>
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
                    <td colspan="11" class="p-4 text-right font-bold">Total:</td>
                    <td class="p-4 font-bold">{{ $totalMonto }}
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="12" class="p-4 text-center text-red-500">No hay detalles disponibles.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div>
    <div>
        <h1>Reporte del Día</h1>
        @if (!empty($dateFromFormatted) && !empty($dateToFormatted))
            <h2>{{ $dateFromFormatted }} Hasta {{ $dateToFormatted }}</h2>
        @endif
        <br>

        <h4>Fondos recaudados por Fundamamas en el evento
            @if ($detalles)
                @if (!empty($eventoId))
                    en el evento: {{ $detalles->first()->evento }}
                @else
                    en todos los eventos
                @endif
            @endif
        </h4>
        <br>
    </div>

    <table>
        <thead>
            <tr>
                <th align="center">Cod</th>
                <th align="center">Cédula</th>
                <th align="center">Recorrido</th>
                <th align="center">Fecha</th>
                <th align="center">Precio $</th>
                <th align="center">Referencia I</th>
                <th align="center">Monto $ I</th>
                <th align="center">Monto Bs I</th>
                <th align="center">Referencia II</th>
                <th align="center">Monto $ II</th>
                <th align="center">Monto Bs II</th>
                <th align="center">Total Monto</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalBs = 0;
                $totalBsMixto = 0;
                $totalMonto = 0;
            @endphp

            @if ($detalles)
                @foreach ($detalles as $detalle)
                    @php
                        $datos = json_decode($detalle->datos);
                        $montoBs = $datos->monto_Bs ?? 0;
                        $montoMixtoBs = $datos->monto_mixto_Bs ?? 0;

                        $totalBs += $montoBs;
                        $totalBsMixto += $montoMixtoBs;

                        $montoUSD1 = $datos->monto_USD ?? 0;
                        $montoUSD2 = $datos->monto_mixto_USD ?? 0;
                        $totalMontoPorFila =
                            $montoUSD1 / $detalle->dolar + $montoUSD2 / $detalle->dolar + $montoBs + $montoMixtoBs;
                        $totalMonto += $totalMontoPorFila;
                    @endphp
                    <tr>
                        <td align="center">{{ $detalle->nomenclatura }}</td>
                        <td align="center">{{ $detalle->cedula }}</td>
                        <td align="center">{{ $detalle->recorrido }}</td>
                        <td align="center">{{ $detalle->created_at->format('d-m-Y') }}</td>
                        <td align="center">{{ $detalle->dolar }}</td>
                        <td align="center">{{ $datos->referencia ?? 'N/A' }}</td>
                        <td align="center">{{ $montoUSD1 }}</td>
                        <td align="center">{{ $montoBs }}</td>
                        <td align="center">{{ $datos->referencia_mixto ?? 'N/A' }}</td>
                        <td align="center">{{ $montoUSD2 }}</td>
                        <td align="center">{{ $montoMixtoBs }}</td>
                        <td align="center">{{ $totalMontoPorFila }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="11" align="right" class="font-bold">Total:</td>
                    <td class="font-bold text-blue" align="center">{{ $totalMonto }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="12" class="text-center text-red">No hay detalles disponibles.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

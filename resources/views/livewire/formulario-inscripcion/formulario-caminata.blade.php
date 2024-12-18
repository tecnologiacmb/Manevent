<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-5 gap-4 content-start ">

            <div class="mb-4 ">
                <x-label for="">{{ $evento->nombre }} </x-label>


            </div>

            {{--  @foreach ($grupo as $grupos)
                @if ($groupId == $grupos->id) --}}
            <div class="mb-4 ">
                <x-label for="">Grupo {{ $grupo->nombre }}</x-label>

            </div>
            <div class="mb-4 ">
                <x-label for="">Monto {{ $grupo->precio }} $</x-label>

            </div>
            <div class="mb-4 ">
                <x-label for="">Monto {{ $this->calculo($grupo->precio) }} Bs

                </x-label>
            </div>
            <div class="mb-4 ">
                <x-label for="">Tasa Dolar {{ $dolars->precio }} Bs</x-label>

            </div>

            {{--        @endif
            @endforeach --}}

        </div>
        @for ($i = 0; $i <= $grupo->cantidad - 1; $i++)
            <div class="container mx-auto">
                <div class="grid grid-cols-5 gap-4">

                    <div class="mb-4">
                        <x-label for="">Cedula </x-label>
                        <x-input class="w-full" wire:model="create_participante.{{ $i }}.cedula" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Nombre</x-label>
                        <x-input class="w-full" wire:model="create_participante.{{ $i }}.nombre" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Apellido</x-label>
                        <x-input class="w-full" wire:model="create_participante.{{ $i }}.apellido" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Telefono</x-label>
                        <x-input class="w-full" wire:model="create_participante.{{ $i }}.telefono" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Correo</x-label>
                        <x-input class="w-full" type="email"
                            wire:model="create_participante.{{ $i }}.correo" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Direccion</x-label>
                        <x-input class="w-full" wire:model="create_participante.{{ $i }}.direccion" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Fecha de Nacimiento</x-label>
                        <x-input class="w-full" type="date"
                            wire:model="create_participante.{{ $i }}.fecha_nacimiento"
                            wire:click="edad(value.fecha_nacimiento)" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Estado</x-label>
                        <x-select class="w-full" wire:model.change="create_participante.{{ $i }}.estado_id">
                            <option value="">Seleccione un Estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}"> {{ $estado->estado }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div class="mb-4">
                        <x-label for="">Ciudad </x-label>
                        <x-select class="w-full" wire:model="create_participante.{{ $i }}.ciudad_id">
                            <option value="">Seleccione la ciudad</option>
                            @if (!empty($create_participante[$i]['ciudades']))
                                @foreach ($create_participante[$i]['ciudades'] as $ciudad)
                                    <option value="{{ $ciudad->id }}">{{ $ciudad->ciudad }}</option>
                                @endforeach
                            @endif

                        </x-select>
                    </div>
                    {{-- selecion del metodo de pagos  --}}

                    <div class="mb-4">
                        <x-label for="">Metodo Realizado </x-label>
                        <input type="radio" name="pago_{{$i}}" value="1" wire:click="update_radio({{$i}},'1')" wire:model.live="create_inscripcion.{{$i}}.unico">Unico
                        <input type="radio" name="pago_{{$i}}" value="2" wire:click="update_radio({{$i}},'2')" wire:model.live="create_inscripcion.{{$i}}.mixto">Mixto

                    </div>
                </div>
                {{-- cuando el pago es unico --}}
                @if ($this->create_inscripcion[$i]['unico']== '1')

                <div>
                    <div class="grid grid-cols-5 gap-4">
                        <div>
                            <x-label for="">Pagos</x-label>
                            <x-select class="w-full" id="tipo_pago_{{ $i }}"
                                onchange="tipo_pago(event, '{{ $i }}')">
                                <option value="">Seleccione un pago</option>
                                <option value="bolivar">Bolivares Bs</option>
                                <option value="dolar">Dolares $</option>
                            </x-select>
                        </div>
                        {{-- si pago en $ --}}
                        <div  id="dolar_{{ $i }}">
                            <div class="mb-4">
                                <x-label for="">Monto pagado $</x-label>
                                <x-input type="number" class="w-full"
                                    wire:model="create_inscripcion.{{ $i }}.monto" />
                            </div>
                        </div>
                        {{-- si pago en bs --}}
                        <div  id="bolivar_{{ $i }}">
                            <div class="mb-4">
                                <x-label for="">Monto pagado Bs</x-label>
                                <x-input type="number" class="w-full"
                                    wire:model="create_inscripcion.{{ $i }}.monto" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-label for="">N° Referencia</x-label>
                            <x-input class="w-full" wire:model="create_inscripcion.{{ $i }}.referencia" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Fecha Del Pago</x-label>
                            <x-input type="date" class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.fecha" />
                        </div>
                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.metodo_pago_id">
                                <option value="">Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value="{{ $metodo_pagos->id }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </div>
                @endif

                @if ($this->create_inscripcion[$i]['mixto'] == '2' )

                {{-- cuando el pago es mixto --}}
                <div>
                    <div class="grid grid-cols-5 gap-4">
                        <div class="mb-4">
                            <x-label for="">Pagos</x-label>
                            <x-select class="w-full">
                                <option value="">Seleccione un pago</option>
                                <option value="1">Bolivares Bs</option>
                                <option value="2">Dolares $</option>
                            </x-select>
                        </div>

                        <div class="mb-4">
                            <x-label for="">N° Referencia</x-label>
                            <x-input class="w-full" wire:model="create_inscripcion.{{ $i }}.referencia" />
                        </div>
                        <div class="mb-4">
                            <x-label for="">Fecha Del Pago</x-label>
                            <x-input type="date" class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.fecha" />
                        </div>

                        {{-- si pago en $ --}}
                        <div class="mb-4">
                            <x-label for="">Monto pagado $</x-label>
                            <x-input type="number" class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.monto" />
                        </div>
                        {{-- si pago en bs --}}
                        <div class="mb-4">
                            <x-label for="">Monto pagado Bs</x-label>
                            <x-input type="number" class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.monto" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.metodo_pago_id">
                                <option value="" disabled>Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value="{{ $metodo_pagos->id }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>

                        <div class="mb-4">
                            <x-label for="">Pagos</x-label>
                            <x-select class="w-full">
                                <option value="">Seleccione un pago</option>
                                <option value="1">Bolivares Bs</option>
                                <option value="2">Dolares $</option>
                            </x-select>
                        </div>

                        <div class="mb-4">
                            <x-label for="">N° Referencia</x-label>
                            <x-input class="w-full" wire:model="create_inscripcion.{{ $i }}.referencia_mixto" />
                        </div>
                        <div class="mb-4">
                            <x-label for="">Fecha Del Pago</x-label>
                            <x-input type="date" class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.fecha_mixto" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Monto pagado $</x-label>
                            <x-input type="number" class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.monto_mixto" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Monto pagado Bs</x-label>
                            <x-input type="number" class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.monto_mixto" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full"
                                wire:model="create_inscripcion.{{ $i }}.metodo_pago_id">
                                <option value="" disabled>Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value="{{ $metodo_pagos->id }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </div>
                @endif


                <hr class="border-black"><br>
            </div>
        @endfor

        <div class="flex justify-end">
            <x-button>
                Agregar
            </x-button>
        </div>
    </form>

    <script>
        function showOnChange(e, posicion) {
            console.log('entre a la funcion')
            document.getElementById('unico_' + posicion).style.display = "none";
            document.getElementById('mixto_' + posicion).style.display = "none";
            var elem = document.getElementById("metodo_pagos_" + posicion);
            var value = elem.options[elem.selectedIndex].value;
            let valor_posicion = value + '_' + posicion

            if (valor_posicion == "unico_" + posicion) {
                document.getElementById('unico_' + posicion).style.display = "block";
                document.getElementById('mixto_' + posicion).style.display = "none";

            } else if (valor_posicion == "mixto_" + posicion) {
                document.getElementById('unico_' + posicion).style.display = "none";
                document.getElementById('mixto_' + posicion).style.display = "block";

            }

        }

        function tipo_pago(e, posicion) {
            document.getElementById('bolivar_' + posicion).style.display = "block";
            document.getElementById('dolar_' + posicion).style.display = "none";
            var elem = document.getElementById("tipo_pago_" + posicion);
            var value = elem.options[elem.selectedIndex].value;
            let valor_posicion = value + '_' + posicion

            if (valor_posicion == "bolivar_" + posicion) {
                document.getElementById('bolivar_' + posicion).style.display = "block";
                document.getElementById('dolar_' + posicion).style.display = "none";

            } else if (valor_posicion == "dolar_" + posicion) {
                document.getElementById('bolivar_' + posicion).style.display = "none";
                document.getElementById('dolar_' + posicion).style.display = "block";

            }

        }
    </script>

</div>

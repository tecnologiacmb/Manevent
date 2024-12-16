<div>



    <div class="grid grid-cols-5 gap-4 content-start ">
        @foreach ($evento as $eventos)
            <div class="mb-4 ">
                <x-label for="">{{ $eventos->nombre }} </x-label>

                <x-input class="w-full" nombre="groupId" value="{{ $eventos->id }}"
                    wire:model="create_inscripcion.evento_id" />
            </div>
        @endforeach
        {{--  @foreach ($grupo as $grupos)
            @if ($groupId == $grupos->id) --}}
        <div class="mb-4 ">
            <x-label for="">Grupo {{ $grupoP->nombre }}</x-label>
            <x-input class="w-full" nombre="groupId" wire:model="create_inscripcion.grupo_id" />
        </div>
        <div class="mb-4 ">
            <x-label for="">Monto {{ $grupoP->precio }} $</x-label>

        </div>
        <div class="mb-4 ">
            <x-label for="">Monto {{ $this->calculo($grupoP->precio) }} Bs
                <x-input wire:model="create_inscripcion.monto_pagado_bs"></x-input>
            </x-label>


        </div>
        <div class="mb-4 ">
            <x-label for="">Tasa Dolar {{ $dolars->last()->precio }} Bs</x-label>
            <x-input class="w-full" wire:model="create_inscripcion.dolar_id" />
        </div>

        <div class="mb-4" hidden>
            <x-label for="">Ip</x-label>
        </div>

        <div class="mb-4" hidden>
            <x-label for="">nomenclatura</x-label>
        </div>
        {{--        @endif
        @endforeach --}}

    </div>


    <form wire:submit="seve">

        <div class="container mx-auto">
            <div class="grid grid-cols-3 gap-4 ">
                <div class="mb-4">
                    <x-label for="">Cedula </x-label>
                    <x-input class="w-full" wire:model="create_participante.cedula" />
                </div>

                <div class="mb-4">
                    <x-label for="">Nombre</x-label>
                    <x-input class="w-full" wire:model="create_participante.nombre" />
                </div>

                <div class="mb-4">
                    <x-label for="">Apellido</x-label>
                    <x-input class="w-full" wire:model="create_participante.apellido" />
                </div>

                <div class="mb-4">
                    <x-label for="">Telefono</x-label>
                    <x-input class="w-full" wire:model="create_participante.telefono" />
                </div>

                <div class="mb-4">
                    <x-label for="">Correo</x-label>
                    <x-input class="w-full" type="email" wire:model="create_participante.correo" />
                </div>

                <div class="mb-4">
                    <x-label for="">Direccion</x-label>
                    <x-input class="w-full" wire:model="create_participante.direccion" />
                </div>
                <div class="mb-4">
                    <x-label for="">Fecha de Nacimiento</x-label>
                    <x-input class="w-full" type="date" wire:model="create_participante.fecha_nacimiento" />
                </div>

                <div class="mb-4">
                    <x-label for="">Estado</x-label>
                    <x-select class="w-full" wire:click="changeEvent($event.target.value)">
                        <option value="">Seleccione un Estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}"> {{ $estado->estado }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div class="mb-4">
                    <x-label for="">Ciudad</x-label>
                    <x-select class="w-full" wire:model="create_participante.ciudad_id">

                        <option value="">Seleccione la ciudad</option>
                        @foreach ($ciudad as $ciudades)
                            @if ($ciudades->estado_id == $opcion)
                                <option value="{{ $ciudades->id }}">{{ $ciudades->ciudad }}</option>
                            @endif
                        @endforeach

                    </x-select>
                </div>

                <div class="mb-4">
                    <x-label for="">Metodo Realizado</x-label>
                    <x-select class="w-full" wire:click="changeEvent2($event.target.value)">
                        <option value="" disabled>Seleccione un Metodo Pago</option>
                        <option value="1">Directo</option>
                        <option value="2">Mixto</option>

                    </x-select>
                </div>
            </div>

            <div class="grid grid-cols-5 gap-4 ">
                @if ($opcion2 == 2)

                    <div class="mb-4">
                        <x-label for="">Pagos</x-label>
                        <x-select class="w-full" wire:click="changeEvent3($event.target.value)">
                            <option value="">Seleccione un pago</option>
                            <option value="1">Bolivares Bs</option>
                            <option value="2">Dolares $</option>
                        </x-select>
                    </div>

                    <div class="mb-4">
                        <x-label for="">N° Referencia</x-label>
                        <x-input class="w-full" wire:model="create_inscripcion.referencia" />
                    </div>
                    <div class="mb-4">
                        <x-label for="">Fecha Del Pago</x-label>
                        <x-input type="date" class="w-full" wire:model="create_inscripcion.fecha" />
                    </div>

                    @if ($opcion3 == 2)
                        <div class="mb-4">
                            <x-label for="">Monto pagado $</x-label>
                            <x-input type="number" class="w-full" wire:model="create_inscripcion.monto" />
                        </div>
                    @elseif ($opcion3 == 1)
                        <div class="mb-4">
                            <x-label for="">Monto pagado Bs</x-label>
                            <x-input type="number" class="w-full" wire:model="create_inscripcion.monto" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full" wire:model="create_inscripcion.metodo_pago_id">
                                <option value="" disabled>Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value="{{ $metodo_pagos->id }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                    @endif
            </div>


            <div class="grid grid-cols-5 gap-4 ">
                <div class="mb-4">
                    <x-label for="">Pagos</x-label>
                    <x-select class="w-full" wire:click="changeEvent4($event.target.value)">
                        <option value="">Seleccione un pago</option>
                        <option value="1">Bolivares Bs</option>
                        <option value="2">Dolares $</option>
                    </x-select>
                </div>

                <div class="mb-4">
                    <x-label for="">N° Referencia</x-label>
                    <x-input class="w-full" wire:model="create_inscripcion.referencia" />
                </div>
                <div class="mb-4">
                    <x-label for="">Fecha Del Pago</x-label>
                    <x-input type="date" class="w-full" wire:model="create_inscripcion.fecha" />
                </div>

                @if ($opcion4 == 2)
                    <div class="mb-4">
                        <x-label for="">Monto pagado $</x-label>
                        <x-input type="number" class="w-full" wire:model="create_inscripcion.monto" />
                    </div>
                @elseif ($opcion4 == 1)
                    <div class="mb-4">
                        <x-label for="">Monto pagado Bs</x-label>
                        <x-input type="number" class="w-full" wire:model="create_inscripcion.monto" />
                    </div>
                    <div class="mb-4">
                        <x-label for="">Cuenta</x-label>
                        <x-select class="w-full" wire:model="create_inscripcion.metodo_pago_id">
                            <option value="" disabled>Seleccione la cuenta de pago</option>
                            @foreach ($metodo_pago as $metodo_pagos)
                                <option value="{{ $metodo_pagos->id }}">
                                    {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                @endif
            @else
                {{-- si el metodo de pago es uno solo --}}
                <div class="mb-4">
                    <x-label for="">Pagos</x-label>
                    <x-select class="w-full" wire:click="changeEvent4($event.target.value)">
                        <option value="">Seleccione un pago</option>
                        <option value="1">Bolivares Bs</option>
                        <option value="2">Dolares $</option>
                    </x-select>
                </div>

                <div class="mb-4">
                    <x-label for="">N° Referencia</x-label>
                    <x-input class="w-full" wire:model="create_inscripcion.referencia" />
                </div>
                <div class="mb-4">
                    <x-label for="">Fecha Del Pago</x-label>
                    <x-input type="date" class="w-full" wire:model="create_inscripcion.fecha" />
                </div>

                @if ($opcion4 == 2)
                    <div class="mb-4">
                        <x-label for="">Monto pagado $</x-label>
                        <x-input type="number" class="w-full" wire:model="create_inscripcion.monto" />
                    </div>
                @elseif ($opcion4 == 1)
                    <div class="mb-4">
                        <x-label for="">Monto pagado Bs</x-label>
                        <x-input type="number" class="w-full" wire:model="create_inscripcion.monto" />
                    </div>
                    <div class="mb-4">
                        <x-label for="">Cuenta</x-label>
                        <x-select class="w-full" wire:model="create_inscripcion.metodo_pago_id">
                            <option value="" disabled>Seleccione la cuenta de pago</option>
                            @foreach ($metodo_pago as $metodo_pagos)
                                <option value="{{ $metodo_pagos->id }}">
                                    {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                @endif

                @endif


            </div>

            <div class="flex justify-end">

                <x-button>
                    Agregar
                </x-button>
            </div>
        </div>
    </form>
</div>

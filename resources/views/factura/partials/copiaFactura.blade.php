<div class="copia" id="{{ $id }}">

    {{-- Fecha --}}
    <div class="campo" style="top:0.5cm; left:12cm;">
        {{ $diafecha }} de {{ ucfirst($mesLetra) }} del {{ $agefecha }}
    </div>

    {{-- Cliente --}}
    <div class="campo" style="top:1.3cm; left:2.2cm;">
        {{ $ventas[0]->nombre }}
    </div>

    {{-- RUC --}}
    <div class="campo" style="top:1.3cm; left:14cm;">
        {{ $ventas[0]->ruc }}-{{ $ventas[0]->digito }}
    </div>

    {{-- Dirección --}}
    <div class="campo" style="top:2cm; left:2.2cm;">
        {{ $ventas[0]->direccion }}
    </div>

    {{-- Teléfono --}}
    <div class="campo" style="top:2cm; left:14cm;">
        {{ $ventas[0]->telefono }}
    </div>

    {{-- Tabla de items --}}
    @php $y = 3.5; @endphp

    @foreach($detalles as $item)
        <div class="campo" style="top: {{ $y }}cm; left:1cm;">
            {{ $item->cantidad }}
        </div>

        <div class="campo" style="top: {{ $y }}cm; left:3cm;">
            {{ $item->descripcion }}
        </div>

        <div class="campo" style="top: {{ $y }}cm; left:14cm;">
            {{ number_format($item->subtotal, 0, ',', '.') }}
        </div>

        @php $y += 0.55; @endphp
    @endforeach

    {{-- Totales --}}
    <div class="campo" style="top:10cm; left:14cm;">
        {{ number_format($ventas[0]->total, 0, ',', '.') }}
    </div>

</div>

@if(session('error'))
    <div style="color: red; margin-bottom: 15px;">
        {{ session('error') }}
    </div>
@endif

<div style="text-align: right; margin-bottom: 20px;">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>
</div>

<form method="GET" action="{{ route('candidatos.index') }}">
    <h3>Filtrar por tecnologías:</h3>
    <label>
        <input type="checkbox" name="javascript" value="1" {{ request()->has('javascript') ? 'checked' : '' }}>
        JavaScript
    </label>
    <label>
        <input type="checkbox" name="php" value="1" {{ request()->has('php') ? 'checked' : '' }}>
        PHP
    </label>
    <label>
        <input type="checkbox" name="html" value="1" {{ request()->has('html') ? 'checked' : '' }}>
        HTML
    </label>
    <label>
        <input type="checkbox" name="css" value="1" {{ request()->has('css') ? 'checked' : '' }}>
        CSS
    </label>
    <button type="submit">Filtrar</button>
</form>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Fecha de Nacimiento</th>
            <th>Curriculum</th>
        </tr>
    </thead>
    <tbody>
        @foreach($candidatos as $candidato)
            <tr>
                <td>{{ $candidato->nombre }}</td>
                <td>{{ $candidato->apellidos }}</td>
                <td>{{ $candidato->fecha_nacimiento }}</td>
                <td>
                    @if($candidato->curriculum)
                        <a href="{{ route('candidatos.descargar-curriculum', $candidato->id) }}">
                            Descargar CV
                        </a>
                    @else
                        No disponible
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

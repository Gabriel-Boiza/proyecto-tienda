<form action="{{route('productos.store')}}" method="POST">
    @csrf
    <input type="text" name="nombre">
    <input type="submit">
</form>
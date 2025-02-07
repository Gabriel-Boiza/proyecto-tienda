<div>
    <form action='{{ route("categorias.store") }}' method="POST">
        @csrf
        <label for="nombre_categoria">Categoria</label>
        <input type="text" name="nombre_categoria" id="nombre_categoria">
        <input type="text" name="categoria_padre">

        <input type="submit">
    </form>
</div>
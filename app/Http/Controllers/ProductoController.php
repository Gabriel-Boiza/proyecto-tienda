<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Pedido;
use App\Models\Caracteristica;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Carrito;
use Illuminate\Support\Facades\Session;

class ProductoController extends Controller
{




    public function appAdmin(){
        $productos = Producto::withCount([
            'pedidos as total_vendidos' => function ($query) {
                $query->select(DB::raw('SUM(cantidad)'));
            }
        ])
        ->orderBy('total_vendidos', 'desc')
        ->limit(5)
        ->get();

        $pedidosActivos = Pedido::where('estado', 'enviado')->count();
        $totalPedidos = Pedido::sum('total'); 
        $clientesActivos = Cliente::count();
        $nombre = auth()->user()->name; // Accede al nombre del usuario autenticado
        $pedidosTotales = Pedido::count();


        $pedidos = Pedido::with('productos', 'cliente')->limit(3)->get();
        

        return view('app-admin.inicio', compact('productos', 'pedidos', 'pedidosActivos', 'totalPedidos', 'clientesActivos', 'nombre', 'pedidosTotales'));
    }
    
    public function favoritos(){
        $productos = Producto::whereRelation('categorias', 'nombre_categoria', 'destacado')->get();  
        $categorias = Categoria::withCount('productos')->get(); 
        //return response()->json($productos);
        return view('user/favoritos', compact('productos', 'categorias'));
    }
    
    public function destacados(){
        $productos = Producto::whereRelation('categorias', 'nombre_categoria', 'destacado')->get();  
        $categorias = Categoria::withCount('productos')->get(); 
        //return response()->json($productos);
        return view('user/inicio', compact('productos', 'categorias'));
    }

    public function userShow(string $id){
        $producto = Producto::with(['categorias', 'marca', 'caracteristicas'])->find($id);
        $imagenesAdicionales = DB::table('imagenes_adicionales')->where('id_producto', $id)->get();
        return view('user/mostrarProducto', compact('producto', 'imagenesAdicionales'));
    }

    public function obtenerProductos(){

        $productos = Producto::with('categorias')->get();   

        return response()->json($productos);
    }

    public function obtenerProductosBusqueda(Request $request){
        $productos = Producto::with('categorias')->where('nombre', 'LIKE', '%'.$request->valorBusqueda.'%')->get(); 
        
        return response()->json($productos);
    }
    
    public function index()
    {
        $productos = Producto::with('categorias')->get();

        return view('app-admin.productos.leer', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::select('id', 'nombre_categoria')->get()->toArray();
        $marcas = Marca::all();
        $caracteristicas = Caracteristica::all();
        return view("app-admin/productos/crear", compact('categorias', 'marcas', 'caracteristicas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'imagen_principal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'categorias' => 'nullable|array', 
            'marcas' => 'nullable|array', 
            'caracteristicas' => 'nullable|array', 
            'imagenes_adicionales' => 'nullable|array',
            'descuento' => 'integer',
            'personalizable' => 'boolean',
        ]);
    

        $rutaImagenPrincipal = "";
    
        if ($request->hasFile('imagen_principal')) {
            $imagenPrincipal = $request->file('imagen_principal');
            $rutaImagenPrincipal = $imagenPrincipal->store('productos', 'public'); 
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion, 
            'stock' => $request->stock,
            'imagen_principal' => $rutaImagenPrincipal,
            'fk_marca' => $request->marca,  
            'descuento' => $request->descuento,
            'personalizable' => $request->has('personalizable') ? true : false,
        ]);

        foreach($request->caracteristicas as $index => $caracteristica){
            DB::table('productos_caracteristicas')->insert([
                'id_producto' => $producto->id,
                'id_caracteristica' => $caracteristica, 
            ]);
        }

        if ($request->has('imagenes_adicionales')) {
            foreach ($request->file('imagenes_adicionales') as $imagenAdicional) {
                $rutaImagenAdicional = $imagenAdicional->store('productos', 'public'); 
    

                DB::table('imagenes_adicionales')->insert([
                    'id_producto' => $producto->id,
                    'imagen' => $rutaImagenAdicional,
                ]);
            }
        }

        if ($request->has('categorias') && count($request->categorias) > 0) {
            $producto->categorias()->attach($request->categorias);  
        }
    
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }
    
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::with(['categorias', 'marca', 'caracteristicas'])->find($id);
        $imagenesAdicionales = DB::table('imagenes_adicionales')
        ->where('id_producto', $id) 
        ->get();
        
        return view("app-admin.productos.mostrar", compact('producto', 'imagenesAdicionales'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::with(['categorias','marca', 'caracteristicas'])->findOrFail($id);
        $categorias = Categoria::all();
        $caracteristicas = Caracteristica::all();
        $marcas = Marca::all();
        $imagenesAdicionales = DB::table('imagenes_adicionales')
            ->where('id_producto', $id) 
            ->get();
    
        return view("app-admin.productos.editar", compact('producto', 'categorias','marcas','imagenesAdicionales', 'caracteristicas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'descuento' => 'integer',
            'imagen_principal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categorias' => 'nullable|array',
            'imagenes_adicionales' => 'nullable|array',
            'imagenes_eliminar' => 'nullable|array',
            'fk_marca' => 'required|exists:marcas,id', // Validamos que la marca exista

        ]);
    
        // Actualizar los datos principales del producto
        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'descuento' => $request->descuento,
            'personalizable' => $request->has('personalizable') ? true : false,
            'fk_marca' => $request->fk_marca, // Guardar la marca seleccionada
        ]);

        DB::table('productos_caracteristicas')->where('id_producto', $id)->delete();

        if(isset($request->caracteristicas)){
            foreach($request->caracteristicas as $index => $caracteristica){
                DB::table('productos_caracteristicas')->insert([
                    'id_producto' => $producto->id,
                    'id_caracteristica' => $caracteristica, 
                ]);
            }   
        }
    
        // Actualizar la imagen principal si se sube una nueva
        if ($request->hasFile('imagen_principal')) {
            // Eliminar la imagen anterior
            if ($producto->imagen_principal) {
                Storage::disk('public')->delete($producto->imagen_principal);
            }
    
            // Guardar la nueva imagen
            $rutaImagenPrincipal = $request->file('imagen_principal')->store('productos', 'public');
            $producto->update(['imagen_principal' => $rutaImagenPrincipal]);
        }

        // Eliminar las imágenes adicionales si se han seleccionado para eliminar
        if ($request->has('imagenes_eliminar')) {
            foreach ($request->imagenes_eliminar as $imagenId) {
                // Obtener la imagen a eliminar de la base de datos
                $imagen = DB::table('imagenes_adicionales')->where('id', $imagenId)->first();
                if ($imagen) {
                    // Eliminar el archivo de almacenamiento
                    Storage::disk('public')->delete($imagen->imagen);
                    
                    // Eliminar la entrada de la base de datos
                    DB::table('imagenes_adicionales')->where('id', $imagenId)->delete();
                }
            }
        }

        // Subir nuevas imágenes adicionales si las hay
        if ($request->hasFile('imagenes_adicionales')) {
            foreach ($request->file('imagenes_adicionales') as $imagenAdicional) {
                // Almacenar la imagen
                $rutaImagenAdicional = $imagenAdicional->store('productos', 'public');
                
                // Insertar la nueva imagen en la base de datos
                DB::table('imagenes_adicionales')->insert([
                    'id_producto' => $producto->id,
                    'imagen' => $rutaImagenAdicional,
                ]);
            }
        }

        if ($request->has('categorias')) {
            $producto->categorias()->sync($request->categorias);
        } else {
            $producto->categorias()->detach();
        }
        // Redirigir o retornar una respuesta
        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);

        // Obtener imágenes adicionales
        $imagenesAdicionales = DB::table('imagenes_adicionales')->where('id_producto', $id)->get();

        // Eliminar imágenes adicionales del almacenamiento
        foreach ($imagenesAdicionales as $imagen) {
            Storage::disk('public')->delete($imagen->imagen);
        }

        // Eliminar registros de imágenes adicionales de la base de datos
        DB::table('imagenes_adicionales')->where('id_producto', $id)->delete();

        // Eliminar la imagen principal del almacenamiento si existe
        if ($producto->imagen_principal) {
            Storage::disk('public')->delete($producto->imagen_principal);
        }

        // Eliminar el producto
        $producto->delete();

        return response()->json(['message' => 'Producto e imágenes eliminados correctamente']);
    }

    // ProductoController.php

    public function buscar(Request $request)
    {
        $query = $request->input('query');
        
        // Realizamos la búsqueda de productos que coincidan con el nombre o la descripción
        $productos = Producto::where('nombre', 'like', "%{$query}%")

                            ->get(['id', 'nombre', 'precio']); // Solo devolver los datos necesarios

        return response()->json($productos);
    }

    // En tu controlador
    public function getProductosStock() {

        $productos = Producto::select('nombre', 'stock')->orderBy('stock', 'desc')->get();

        return response()->json($productos);
    }
    public function guardarImagen(Request $request)
    {
        try {
            // Validar la imagen
            if (!$request->has('image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se ha proporcionado ninguna imagen'
                ], 400);
            }

            // Obtener la imagen en base64 y decodificarla
            $image = $request->input('image');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(40) . '.png';

            // Guardar la imagen
            Storage::disk('public')->put('products/' . $imageName, base64_decode($image));

            // Generar nombre aleatorio que empiece con "pers" seguido de 9 caracteres aleatorios
            $randomName = 'pers' . Str::random(9);

            // Crear el producto con todos los campos requeridos
            $product = new Producto();
            $product->nombre = $randomName;
            $product->precio = 5;
            $product->descripcion = 'Producto personalizado';
            $product->stock = 1;
            $product->imagen_principal = 'products/' . $imageName;
            $product->descuento = 0;
            $product->personalizable = true;
            $product->fk_marca = 1;

            DB::beginTransaction();
            try {
                $product->save();
                
                // Obtener el ID del cliente de la sesión
                $clienteId = Session::get('cliente_id');

                // Crear entrada en el carrito usando el modelo Carrito
                Carrito::create([
                    'cliente_id' => $clienteId,
                    'producto_id' => $product->id,
                    'cantidad' => 1
                ]);
                
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Producto añadido al carrito exitosamente',
                    'redirect' => '/carrito'
                ]);
                
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el producto: ' . $e->getMessage()
            ], 500);
        }
}


    
}

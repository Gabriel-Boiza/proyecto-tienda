<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProductoController extends Controller
{
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
        $producto = Producto::with(['categorias', 'marca'])->find($id);

        return view('user/mostrarProducto', compact('producto'));
    }

    public function obtenerProductos(){

        $productos = Producto::with('categorias')->get();   

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
        return view("app-admin/productos/crear", compact('categorias', 'marcas'));
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
            'imagenes_adicionales' => 'nullable|array',
            'descuento' => 'integer',
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
        ]);

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
        $producto = Producto::with(['categorias', 'marca'])->find($id);
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
        $producto = Producto::with(['categorias','marca'])->findOrFail($id);
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $imagenesAdicionales = DB::table('imagenes_adicionales')
            ->where('id_producto', $id) 
            ->get();
    
        return view("app-admin.productos.editar", compact('producto', 'categorias','marcas','imagenesAdicionales'));
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
            'fk_marca' => $request->fk_marca, // Guardar la marca seleccionada

        ]);
    
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


    
}

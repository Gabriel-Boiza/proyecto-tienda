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

    public function destacados(){
        $productos = Producto::whereRelation('categorias', 'nombre_categoria', 'destacado')->get();  
        $categorias = Categoria::withCount('productos')->get(); 
        //return response()->json($productos);
        return view('user/inicio', compact('productos', 'categorias'));
    }

    public function userShow(string $id){
        echo $id;
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
            'marca' => $request->marca,
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
        $producto = Producto::with('categorias')->find($id);
        $imagenesAdicionales = DB::table('imagenes_adicionales')
        ->where('id_producto', $id) 
        ->get();
        
        return view("app-admin.productos.mostrar", compact('producto', 'imagenesAdicionales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Producto::find($id)->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id); 
        $imagenesAdicionales = DB::table('imagenes_adicionales')->where('id_producto', $id)->pluck('imagen');
    

        if(!empty($imagenesAdicionales)){
            foreach($imagenesAdicionales as $indice => $imagen){

                $rutaImagenAdicional = storage_path("app/public/{$imagen}");
                if(file_exists($rutaImagenAdicional)){
                    unlink($rutaImagenAdicional);
                }
            
            }
        }

        if ($producto->imagen_principal) {
            $rutaImagen = storage_path("app/public/{$producto->imagen_principal}");
            
            if(file_exists($rutaImagen)){
                unlink($rutaImagen);
            }
        }
    
        $producto->delete();
    
        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
    
}

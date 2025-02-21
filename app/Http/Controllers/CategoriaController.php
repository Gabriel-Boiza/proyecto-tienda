<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Marca;
use Exception;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{

    public function userShow(string $id){
        $categorias = Categoria::with('productos')->find($id);
        

        
        $marcas = Marca::all();
        $precioMaximo = Producto::max('precio');
        $precioActual = $precioMaximo;
        $precioMinimo = Producto::min('precio');
        $marcasActuales = [];

        

        if(isset($_GET['precio'])){
            $precioActual = $_GET['precio'];
        }

        $productos = $categorias->productos()->where('precio', '<=', $precioActual)->paginate(6)->appends(request()->query());

        if(isset($_GET['marcas'])){
            $marcasActuales = $_GET['marcas'];
            $productos = $precioActual <= $precioMaximo 
            ? $productos = $categorias->productos()->whereIn('fk_marca', $marcasActuales)->where('precio', '<=', $precioActual)->paginate(6)->appends(request()->query()) 
            : $categorias->productos()->where('precio', '<=', $precioActual)->paginate(6)->appends(request()->query()) ;
            $marcasActuales = $_GET['marcas'];
        }

        

        return view('user.productos', compact('categorias', 'precioMaximo', 'precioMinimo', 'marcas', 'productos', 'precioActual', 'marcasActuales'));
        
    }

    public function obtenerCategorias(){
        $categorias = Categoria::all();

        return response()->json($categorias);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();

        return view("app-admin.categorias.leer", compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("categorias/crear_formulario");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'categoria' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s]+$/',
                Rule::unique('categorias', 'nombre_categoria')->ignore($request->id), // Si estás actualizando
            ],  //categoria es el valor que le paso por fetch
        ],
        [
            'categoria.required' => 'El nombre de la categoría es obligatorio.',
            'categoria.string' => 'El nombre de la categoría debe ser una cadena de texto.',
            'categoria.max' => 'El nombre de la categoría no puede exceder los 255 caracteres.',
            'categoria.regex' => 'El nombre de la categoría solo puede contener letras, números y espacios.',
            'categoria.unique' => 'Ya existe una categoría con ese nombre.',
        ]);
    

        Categoria::create([
            'nombre_categoria' => $request->input('categoria'), 
        ]);
    

        return response()->json(['message' => 'Categoría creada con éxito']); 
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
  
        $request->validate([
            'categoria' => 'required|string|max:255'
        ]);
    
        try {
 
            $categoria = Categoria::findOrFail($id);
            
            $categoria->nombre_categoria = $request->categoria;
            $categoria->save();

            $datos = ['message' => 'Categoría actualizada correctamente', 'categoria' => $categoria];

            return response()->json($datos);
    
        } catch (Exception $e) {

            return response()->json(['message' => 'Error al actualizar la categoría']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);
        $categoria->delete();

        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}

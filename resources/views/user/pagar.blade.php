@extends('welcome')

@section('content')
<div class="bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold flex items-center gap-3">
            <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Pago
        </h1>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Formulario de pago -->
        <div class="md:col-span-2">
            <div class="bg-gray-800 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Método de pago
                </h2>
                
                <div class="space-y-6">
                    <!-- Selección de método de pago -->
                    <div>
                        <div class="flex space-x-4 mb-4">
                            <button class="bg-purple-600 rounded-lg px-4 py-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Tarjeta
                            </button>
                            <button class="bg-gray-700 hover:bg-gray-600 rounded-lg px-4 py-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                </svg>
                                PayPal
                            </button>
                            <button class="bg-gray-700 hover:bg-gray-600 rounded-lg px-4 py-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                                </svg>
                                Transferencia
                            </button>
                        </div>
                        
                        <!-- Formulario tarjeta -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Nombre en la tarjeta</label>
                                    <input type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Nombre completo">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Número de tarjeta</label>
                                    <input type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="0000 0000 0000 0000">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Mes</label>
                                    <select class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Año</label>
                                    <select class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                        <option>2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                        <option>2028</option>
                                        <option>2029</option>
                                        <option>2030</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">CVV</label>
                                    <input type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="123">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dirección de facturación -->
                    <div>
                        <h3 class="font-bold mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Dirección de facturación
                        </h3>
                        
                        <div class="flex items-center mb-3">
                            <input type="checkbox" id="same-address" class="mr-2 w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500" checked>
                            <label for="same-address">Usar la misma dirección de envío</label>
                        </div>
                        
                        <div class="bg-gray-700/50 p-3 rounded-lg">
                            <p class="font-medium">Juan Pérez González</p>
                            <p class="text-sm text-gray-400">Calle Ejemplo 123, 5º B</p>
                            <p class="text-sm text-gray-400">28001, Madrid</p>
                            <p class="text-sm text-gray-400">España</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Resumen del pedido -->
        <div>
            <div class="bg-gray-800 rounded-lg p-6 sticky top-6">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Resumen del pedido
                </h2>
                
                <div class="divide-y divide-gray-700">
                    
                    @foreach($clienteProductos as $clienteProducto)
                        <div class="py-3 flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-700 rounded overflow-hidden flex-shrink-0">
                                <img src="{{ asset('storage/' . $clienteProducto->producto->imagen_principal) }}" alt="{{$clienteProducto->producto->nombre}}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow">
                                <p class="font-medium">{{$clienteProducto->producto->nombre}}</p>
                                <p class="text-xs text-gray-400">{{$clienteProducto->cantidad}} x {{$clienteProducto->producto->precio}}€</p>
                            </div>
                            <div class="text-right font-bold">{{$clienteProducto->producto->precio}}€</div>
                        </div>
                    @endforeach
                
                <div class="space-y-3 my-6">

                    <div class="flex justify-between text-gray-400">
                        <span>Envío:</span>
                        <span>Gratis</span>
                    </div>
                    <div class="border-t border-gray-700 pt-3 flex justify-between font-bold">
                        @php
                            $total = 0;
                            foreach($clienteProductos as $index => $clienteProducto){
                                $total += $clienteProducto->producto->precio;
                            }
                        @endphp
                        <span>Total:</span>
                        <span class="text-xl text-purple-500">{{$total}}€</span>
                    </div>
                </div>
                
                <div class="space-y-3 mt-8">
                    <button id="confirmar-pago" class="w-full bg-purple-600 hover:bg-purple-700 py-3 rounded-lg flex items-center justify-center gap-2">
                        Confirmar pago
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </button>
                    
                    <a href="/carrito" class="w-full bg-gray-700 hover:bg-gray-600 py-3 rounded-lg flex items-center justify-center gap-2 text-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver al carrito
                    </a>
                </div>
                
                <div class="mt-6 text-xs text-gray-400">
                    <p class="mb-2">Pago 100% seguro</p>
                    <div class="flex gap-2">
                        <svg class="w-8 h-6 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2 6a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                        </svg>
                        <svg class="w-8 h-6 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2 6a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                        </svg>
                        <svg class="w-8 h-6 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2 6a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                        </svg>
                        <svg class="w-8 h-6 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2 6a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/user/pagos/controlPagos.js"></script>
</div>
@endsection
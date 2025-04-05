@extends('welcome')

@section('title', 'Pago')

@section('content')
    <div class="max-w-lg mx-auto px-4 py-8">
        <div class="bg-gray-800/30 rounded-lg p-8 shadow-lg">
            <h1 class="text-2xl text-gray-300 mb-6 text-center">Finalizar Pago</h1>

            @if(session('success'))
                <div class="bg-green-600/20 border border-green-600 text-green-400 px-4 py-3 rounded mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Formulario de cupón -->
            <div class="mb-6">
                <label class="block text-gray-400 mb-2">¿Tienes un cupón de descuento?</label>
                <div class="flex">
                    <input type="text" id="cupon-code" class="flex-grow bg-gray-700 text-white p-3 rounded-l-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Introduce el código">
                    <button 
                        type="button" 
                        id="apply-cupon" 
                        class="bg-purple-600 text-white rounded-r-lg px-4 py-3 transition-all duration-300 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >
                        Aplicar
                    </button>
                </div>
                <div id="cupon-message" class="text-sm mt-2"></div>
            </div>

            <form action="/pago" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="total" value="{{ $total }}" id="total-input">
                <input type="hidden" name="cupon_id" id="cupon-id-input">

                <div class="mb-6">
                    <label class="block text-gray-400 mb-2">Detalles de la Tarjeta</label>
                    <div id="card-element" class="bg-gray-700 p-3 rounded-lg border border-gray-600"></div>
                    <div id="card-errors" class="text-red-400 mt-2" role="alert"></div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-400 mb-2">Total a Pagar</label>
                    <div class="flex flex-col">
                        <div id="original-price" class="text-gray-400 line-through hidden"></div>
                        <div id="total-price" class="text-2xl font-bold text-purple-500">{{ number_format($total, 2) }}€</div>
                        <div id="discount-info" class="text-green-400 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <button 
                    type="submit" 
                    id="submit-button" 
                    class="w-full bg-purple-600 text-white rounded-lg px-4 py-3 transition-all duration-300 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                    Pagar Ahora
                </button>
            </form>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            style: {
                base: {
                    color: '#ffffff',
                    fontFamily: '"Arial", sans-serif',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#6b7280'
                    }
                },
                invalid: {
                    color: '#ef4444'
                }
            }
        });
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const cardErrors = document.getElementById('card-errors');

        cardElement.addEventListener('change', (event) => {
            if (event.error) {
                cardErrors.textContent = event.error.message;
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                cardErrors.textContent = '';
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            submitButton.disabled = true;
            submitButton.textContent = 'Procesando...';

            try {
                const {token, error} = await stripe.createToken(cardElement);

                if (error) {
                    cardErrors.textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Pagar Ahora';
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            } catch (error) {
                cardErrors.textContent = 'Hubo un problema al procesar su pago. Inténtelo de nuevo.';
                submitButton.disabled = false;
                submitButton.textContent = 'Pagar Ahora';
            }
        });

        // Código para manejar el cupón
        const applyButton = document.getElementById('apply-cupon');
        const cuponInput = document.getElementById('cupon-code');
        const cuponMessage = document.getElementById('cupon-message');
        const originalPrice = document.getElementById('original-price');
        const totalPrice = document.getElementById('total-price');
        const discountInfo = document.getElementById('discount-info');
        const totalInput = document.getElementById('total-input');
        const cuponIdInput = document.getElementById('cupon-id-input');
        let originalTotal = {{ $total }};

        // Comprobar si ya hay un cupón en la sesión al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            checkCuponSession();
        });

        function checkCuponSession() {
            fetch('/check-cupon', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.cupon) {
                    applyCupon(data.cupon);
                    cuponInput.value = data.cupon.codigo;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        applyButton.addEventListener('click', function() {
            const code = cuponInput.value.trim();
            
            if (!code) {
                showMessage('Por favor, introduce un código de cupón', 'text-red-400');
                return;
            }

            // Petición para validar el cupón
            fetch('/validar-cupon', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    codigo: code
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    applyCupon(data.cupon);
                    showMessage('Cupón aplicado correctamente', 'text-green-400');
                } else {
                    showMessage(data.message || 'Cupón inválido o expirado', 'text-red-400');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Error al procesar el cupón', 'text-red-400');
            });
        });

        function applyCupon(cupon) {
            // Guardar el precio original si no se ha guardado ya
            if (originalPrice.textContent === '') {
                originalPrice.textContent = `${originalTotal.toFixed(2)}€`;
            }
            
            // Calcular el nuevo total con descuento
            const discountAmount = (originalTotal * cupon.descuento) / 100;
            const newTotal = originalTotal - discountAmount;
            
            // Actualizar la interfaz
            totalPrice.textContent = `${newTotal.toFixed(2)}€`;
            totalInput.value = newTotal.toFixed(2);
            cuponIdInput.value = cupon.id;
            
            // Mostrar información del descuento
            originalPrice.classList.remove('hidden');
            discountInfo.textContent = `Descuento aplicado: ${cupon.descuento}% (${discountAmount.toFixed(2)}€)`;
            discountInfo.classList.remove('hidden');
        }

        function showMessage(message, className) {
            cuponMessage.textContent = message;
            cuponMessage.className = `text-sm mt-2 ${className}`;
        }
    </script>
@endsection
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

            <form action="/pago" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="total" value="{{ $total }}">

                <div class="mb-6">
                    <label class="block text-gray-400 mb-2">Detalles de la Tarjeta</label>
                    <div id="card-element" class="bg-gray-700 p-3 rounded-lg border border-gray-600"></div>
                    <div id="card-errors" class="text-red-400 mt-2" role="alert"></div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-400 mb-2">Total a Pagar</label>
                    <div class="text-2xl font-bold text-purple-500">{{ number_format($total, 2) }}€</div>
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
    </script>
@endsection
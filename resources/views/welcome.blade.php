<x-app-layout>
    <x-self.base>
        <div class="container mx-auto px-4 py-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Pedidos Pendientes</h1>
                <p class="text-gray-600">Total de pedidos: {{$orders->total()}}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($orders as $item)
                <div class="relative card-container h-72" style="perspective: 1000px;">
                    <div class="relative w-full h-full transition-all duration-500 transform-style-preserve-3d">
                        <!-- Frente de la tarjeta -->
                        <div class="absolute inset-0 bg-white rounded-xl shadow-lg p-6 flex flex-col items-center justify-center border border-gray-100 front-face">
                            <div class="mb-4">
                                <span class="inline-block p-2 bg-blue-100 rounded-full">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item->nombre }}</h3>
                            <span class="px-3 py-1 bg-red-400 text-white rounded-full text-sm">{{$item->estado}}</span>
                            
                            <button onclick="flipCard(this)" class="mt-4 text-blue-600 hover:text-blue-700 font-medium flex items-center">
                                Ver detalles
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Reverso de la tarjeta -->
                        <div class="absolute inset-0 bg-gray-50 rounded-xl shadow-lg p-6 flex flex-col justify-center border border-gray-100 back-face">
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="w-24 font-medium text-gray-600">Cantidad:</span>
                                    <span class="text-gray-800">{{$item->cantidad}}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 font-medium text-gray-600">Fecha:</span>
                                    <span class="text-gray-800">{{$item->created_at->format('d/m/Y H:i')}}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 font-medium text-gray-600">Usuario:</span>
                                    <span class="text-gray-800">{{$item->user->name}}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 font-medium text-gray-600">Email:</span>
                                    <span class="text-gray-800">{{$item->user->email}}</span>
                                </div>
                            </div>
                            
                            <button onclick="flipCard(this)" class="mt-6 w-full py-2 px-4 bg-gray-800 hover:bg-gray-900 text-white rounded-lg transition-colors">
                                Cerrar detalles
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($orders->hasPages())
            <div class="mt-8">
                {{$orders->links()}}
            </div>
            @endif
        </div>

        <script>
            function flipCard(button) {
                const cardContainer = button.closest('.card-container');
                const innerCard = cardContainer.querySelector('.transform-style-preserve-3d');
                innerCard.classList.toggle('is-flipped');
            }
        </script>

        <style>
            .transform-style-preserve-3d {
                transform-style: preserve-3d;
                transition: transform 0.6s;
            }

            .front-face {
                backface-visibility: hidden;
                transform: rotateY(0deg);
            }

            .back-face {
                backface-visibility: hidden;
                transform: rotateY(180deg);
            }

            .is-flipped {
                transform: rotateY(180deg);
            }
        </style>
    </x-self.base>
</x-app-layout>
<nav class="bg-black sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-xl font-bold">T</span>
                    </div>
                    <span class="text-xl font-bold">TechPerif</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="py-2 border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-all duration-200">Teclados</a>
                    <a href="#" class="py-2 border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-all duration-200">Ratones</a>
                    <a href="#" class="py-2 border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-all duration-200">Auriculares</a>
                    <a href="#" class="py-2 border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-all duration-200">Monitores</a>
                </div>

                <!-- Search and Cart -->
                <div class="hidden md:flex items-center space-x-6">
                    <div class="relative">
                        <input type="search" placeholder="Buscar productos..." class="w-64 px-4 py-2 bg-gray-800 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        <button class="absolute right-2 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                    <div class="relative">
                        <button class="p-2 hover:text-purple-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </button>
                        <span class="absolute -top-2 -right-2 bg-purple-600 text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden" @click="mobileMenu = !mobileMenu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16"/></svg>
                </button>
            </div>

            <!-- Mobile Menu Panel -->
            <div class="md:hidden" x-show="mobileMenu" x-transition>
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-700">Teclados</a>
                    <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-700">Ratones</a>
                    <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-700">Auriculares</a>
                    <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-700">Monitores</a>
                </div>
            </div>
        </div>
    </nav>
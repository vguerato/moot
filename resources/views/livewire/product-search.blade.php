<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Busca de Produtos</h1>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Campo de busca -->
            <div class="md:col-span-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome do produto</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar produtos..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Filtro de Categorias -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Categorias</label>
                <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                    @foreach($categories as $category)
                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                            <input type="checkbox" wire:model.live="selectedCategories" value="{{ $category->id }}"
                                class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Filtro de Marcas -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Marcas</label>
                <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                    @foreach($brands as $brand)
                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                            <input type="checkbox" wire:model.live="selectedBrands" value="{{ $brand->id }}"
                                class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">{{ $brand->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Botão limpar filtros -->
        <div class="mt-4 flex justify-end">
            <button wire:click="clearFilters"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                Limpar Filtros
            </button>
        </div>
    </div>

    <!-- Lista de produtos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                    <p class="text-2xl font-bold text-blue-600 mb-2">R$ {{ number_format($product->price, 2, ',', '.') }}
                    </p>
                    <div class="text-sm text-gray-600">
                        <p>Categoria: <span class="font-medium">{{ $product->category->name }}</span></p>
                        <p>Marca: <span class="font-medium">{{ $product->brand->name }}</span></p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Nenhum produto encontrado.</p>
            </div>
        @endforelse
    </div>

    <!-- Paginação Simples -->
    @if($products->hasPages())
        <div class="mt-8 flex justify-center space-x-4">
            @if (!$products->onFirstPage())
                <button wire:click="previousPage" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Anterior
                </button>
            @endif

            <span class="px-4 py-2 text-gray-700">
                Página {{ $products->currentPage() }} de {{ $products->lastPage() }}
            </span>

            @if ($products->hasMorePages())
                <button wire:click="nextPage" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Próxima
                </button>
            @endif
        </div>
    @endif
</div>
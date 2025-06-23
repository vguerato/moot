<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategories = [];
    public $selectedBrands = [];
    public $categories;
    public $brands;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategories' => ['except' => []],
        'selectedBrands' => ['except' => []],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->categories = Category::all();
        $this->brands = Brand::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategories()
    {
        $this->resetPage();
    }

    public function updatedSelectedBrands()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedCategories = [];
        $this->selectedBrands = [];
        $this->resetPage();
    }

    public function render()
    {
        $products = $this->getProducts();

        return view('livewire.product-search', [
            'products' => $products
        ]);
    }

    private function getProducts()
    {
        $query = Product::with(['category', 'brand']);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->selectedCategories)) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        if (!empty($this->selectedBrands)) {
            $query->whereIn('brand_id', $this->selectedBrands);
        }

        return $query->paginate(12);
    }
}

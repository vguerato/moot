<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\ProductSearch;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar dados de teste
        $this->categories = Category::factory()->count(3)->create();
        $this->brands = Brand::factory()->count(3)->create();

        // Criar produtos específicos para testes
        $this->products = [
            Product::factory()->create([
                'name' => 'Leite Integral',
                'category_id' => $this->categories[0]->id,
                'brand_id' => $this->brands[0]->id,
            ]),
            Product::factory()->create([
                'name' => 'Pão Francês',
                'category_id' => $this->categories[1]->id,
                'brand_id' => $this->brands[1]->id,
            ]),
            Product::factory()->create([
                'name' => 'Arroz Branco',
                'category_id' => $this->categories[2]->id,
                'brand_id' => $this->brands[2]->id,
            ]),
        ];
    }

    /** @test */
    public function pode_buscar_produtos_por_nome()
    {
        Livewire::test(ProductSearch::class)
            ->set('search', 'Leite')
            ->assertSee('Leite Integral')
            ->assertDontSee('Pão Francês')
            ->assertDontSee('Arroz Branco');
    }

    /** @test */
    public function pode_buscar_produtos_por_categoria()
    {
        Livewire::test(ProductSearch::class)
            ->set('selectedCategories', [$this->categories[0]->id])
            ->assertSee('Leite Integral')
            ->assertDontSee('Pão Francês')
            ->assertDontSee('Arroz Branco');
    }

    /** @test */
    public function pode_buscar_produtos_por_marca()
    {
        Livewire::test(ProductSearch::class)
            ->set('selectedBrands', [$this->brands[1]->id])
            ->assertDontSee('Leite Integral')
            ->assertSee('Pão Francês')
            ->assertDontSee('Arroz Branco');
    }

    /** @test */
    public function pode_buscar_produtos_com_filtros_combinados()
    {
        // Criar produto adicional para teste combinado
        Product::factory()->create([
            'name' => 'Leite Desnatado',
            'category_id' => $this->categories[0]->id,
            'brand_id' => $this->brands[2]->id,
        ]);

        Livewire::test(ProductSearch::class)
            ->set('search', 'Leite')
            ->set('selectedCategories', [$this->categories[0]->id])
            ->set('selectedBrands', [$this->brands[0]->id])
            ->assertSee('Leite Integral')
            ->assertDontSee('Leite Desnatado')
            ->assertDontSee('Pão Francês')
            ->assertDontSee('Arroz Branco');
    }

    /** @test */
    public function pode_limpar_filtros()
    {
        $component = Livewire::test(ProductSearch::class)
            ->set('search', 'Teste')
            ->set('selectedCategories', [1, 2])
            ->set('selectedBrands', [1, 2])
            ->call('clearFilters');

        $this->assertEquals('', $component->get('search'));
        $this->assertEquals([], $component->get('selectedCategories'));
        $this->assertEquals([], $component->get('selectedBrands'));
    }

    /** @test */
    public function filtros_sao_persistentes_na_url()
    {
        Livewire::withQueryParams([
            'search' => 'Leite',
            'selectedCategories' => [1],
            'selectedBrands' => [2],
        ])
            ->test(ProductSearch::class)
            ->assertSet('search', 'Leite')
            ->assertSet('selectedCategories', [1])
            ->assertSet('selectedBrands', [2]);
    }
}

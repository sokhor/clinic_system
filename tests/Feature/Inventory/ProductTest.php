<?php

namespace Tests\Feature\Inventory;

use App\Domain\Inventory\Entities\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_create_a_product()
    {
        $user = factory(User::class)->create();
        $user->allow('create', Product::class);
        $this->signIn($user);

        $product = factory(Product::class)->make();

        $this->postJson('api/products', $product->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'product_name' => $product->product_name,
            'product_code' => $product->product_code,
            'brand_name' => $product->brand_name,
            'category_id' => $product->category_id,
            'made_in' => $product->made_in,
            'compositions' => json_encode($product->compositions),
            'laboratory' => $product->laboratory,
            'deleted_at' => null,
        ]);

        $this->assertCount(1, Product::all());
    }

    /** @test */
    function it_not_allow_to_create_a_product()
    {
        $this->signIn();

        $product = factory(Product::class)->make();

        $this->postJson('api/products', $product->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('products', [
            'product_name' => $product->product_name,
            'product_code' => $product->product_code,
            'brand_name' => $product->brand_name,
            'category_id' => $product->category_id,
            'made_in' => $product->made_in,
            'compositions' => json_encode($product->compositions),
            'laboratory' => $product->laboratory,
            'deleted_at' => null,
        ]);

        $this->assertCount(0, Product::all());
    }

    /** @test */
    function it_edit_a_product()
    {
        $user = factory(User::class)->create();
        $user->allow('edit', Product::class);
        $this->signIn($user);

        $product = factory(Product::class)->create();

        $this->putJson('api/products/' . $product->id, array_merge($product->toArray(),[
            'product_name' => 'Product edit 1'
        ]))->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'product_name' => 'Product edit 1',
        ]);
    }

    /** @test */
    function it_not_allow_to_edit_a_product()
    {
        $this->signIn();

        $product = factory(Product::class)->create();

        $this->putJson('api/products/' . $product->id, array_merge($product->toArray(),[
            'product_name' => 'Product edit 1'
        ]))->assertStatus(403);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'product_code' => $product->product_code,
            'brand_name' => $product->brand_name,
            'category_id' => $product->category_id,
            'made_in' => $product->made_in,
            'compositions' => json_encode($product->compositions),
            'laboratory' => $product->laboratory,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    function it_delete_a_product()
    {
        $user = factory(User::class)->create();
        $user->allow('delete', Product::class);
        $this->signIn($user);

        $product = factory(Product::class)->create();

        $this->deleteJson('api/products/' . $product->id)
            ->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);
        $this->assertNull(Product::find($product->id));
    }

    /** @test */
    function it_not_allow_to_delete_a_product()
    {
        $this->signIn();

        $product = factory(Product::class)->create();

        $this->deleteJson('api/products/' . $product->id)
            ->assertStatus(403);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'deleted_at' => null,
        ]);
        $this->assertNotNull(Product::find($product->id));
    }

    /** @test */
    function it_fetch_products()
    {
        $user = factory(User::class)->create();
        $user->allow('view', Product::class);
        $this->signIn($user);

        factory(Product::class, 5)->create();

        $this->getJson('api/products')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'product_name',
                    'product_code',
                    'brand_name',
                    'category_id',
                    'made_in',
                    'compositions',
                    'laboratory',
                ]
            ]
        ]);
    }

    /** @test */
    function it_not_allow_to_fetch_products()
    {
        $this->signIn();

        factory(Product::class, 5)->create();

        $this->getJson('api/products')
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }
}

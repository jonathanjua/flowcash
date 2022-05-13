<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTransactionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_category_transactions()
    {
        $category = Category::factory()->create();
        $transactions = Transaction::factory()
            ->count(2)
            ->create([
                'category_id' => $category->id,
            ]);

        $response = $this->getJson(
            route('api.categories.transactions.index', $category)
        );

        $response->assertOk()->assertSee($transactions[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_category_transactions()
    {
        $category = Category::factory()->create();
        $data = Transaction::factory()
            ->make([
                'category_id' => $category->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.categories.transactions.store', $category),
            $data
        );

        $this->assertDatabaseHas('transactions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $transaction = Transaction::latest('id')->first();

        $this->assertEquals($category->id, $transaction->category_id);
    }
}

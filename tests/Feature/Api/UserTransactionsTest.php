<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Transaction;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTransactionsTest extends TestCase
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
    public function it_gets_user_transactions()
    {
        $user = User::factory()->create();
        $transactions = Transaction::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.transactions.index', $user)
        );

        $response->assertOk()->assertSee($transactions[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_user_transactions()
    {
        $user = User::factory()->create();
        $data = Transaction::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.transactions.store', $user),
            $data
        );

        $this->assertDatabaseHas('transactions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $transaction = Transaction::latest('id')->first();

        $this->assertEquals($user->id, $transaction->user_id);
    }
}

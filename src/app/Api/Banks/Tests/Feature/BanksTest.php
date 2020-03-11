<?php

namespace App\Api\Banks\Tests\Feature;

use Tests\TestCase;
use App\Api\Auth\Models\User;
use App\Api\Banks\Models\Bank;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class BanksTest
 * @package App\Api\Banks\Tests\Feature
 */
class BanksTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $banks;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->banks = factory(Bank::class, 20)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getting_a_collection_of_banks()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'api');
        $response = $this->get('api/banks');

        $response->assertStatus(200)
            ->assertJsonCount($this->banks->count());
    }
}

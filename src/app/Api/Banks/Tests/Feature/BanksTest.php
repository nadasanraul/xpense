<?php

namespace App\Api\Banks\Tests\Feature;

use Tests\TestCase;
use App\Api\Banks\Models\Bank;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class BanksTest
 * @package App\Api\Banks\Tests\Feature
 */
class BanksTest extends TestCase
{
    use RefreshDatabase;

    protected $banks;

    public function setUp(): void
    {
        parent::setUp();
        factory(Bank::class, 20)->create();
    }

    public function test_it_should_get_a_collection_of_banks()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'api');
        $response = $this->get('api/banks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['uuid', 'name', 'description', 'country'],
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'from', 'last_page', 'to', 'path', 'per_page', 'total'],
            ]);
    }
}

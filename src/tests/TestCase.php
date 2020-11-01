<?php

namespace Tests;

use App\Api\Accounts\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }
}

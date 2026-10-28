<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Mockery;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Queue::fake();

        Notification::fake();

        $this->generateEncryptKey();
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    /**
     * Set the config key for tests
     **** DONT USE THIS KEY IN PRODUCTION*****
     */
    private function generateEncryptKey(): void
    {
        Config::set('encrypt.key', 'U8j9BRpqtOXdh5dHlaiBvbR95frfbEgsqOxcgBsS86c=');
    }
}

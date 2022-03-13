<?php

namespace Unit\Console\Commands\Regres;

use App\Contracts\Regres\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tests\Util\FakeRegresClient;

class GetUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function updates_or_creates_users_from_regres_api_data(): void
    {
        $this->instance(Client::class, new FakeRegresClient);

        $this->assertEmpty(User::all());

        $this->artisan('regres:get-users');

        $this->assertCount(2, User::all());
    }

    /** @test */
    public function will_log_the_error_if_regres_request_was_unsuccessful(): void
    {
        Http::fake(['*' => Http::response(status: Response::HTTP_INTERNAL_SERVER_ERROR)]);

        Log::shouldReceive('error')->once();

        $this->artisan('regres:get-users');
    }
}

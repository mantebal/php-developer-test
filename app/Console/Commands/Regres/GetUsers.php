<?php

namespace App\Console\Commands\Regres;

use App\Contracts\Regres\Client;
use App\Models\User;
use App\Resources\User as UserResource;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use Psr\Log\LoggerInterface;

class GetUsers extends Command
{
    /** @var string */
    protected $signature = 'regres:get-users';

    /** @var string */
    protected $description = 'Get users from Regres API';

    public function __construct(
        private Client $client,
        private LoggerInterface $log
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $this->client->getUsers()->each(static function (UserResource $userResource): void {
                User::updateOrCreate(['email' => $userResource->email], $userResource->toArray());
            });
        } catch (RequestException $exception) {
            $this->log->error('Request to Regres API failed:' . $exception->getMessage());
        }
    }
}

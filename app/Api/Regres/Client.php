<?php

namespace App\Api\Regres;

use App\Contracts\Regres\Client as ClientContract;
use App\Resources\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Client implements ClientContract
{
    private Collection $results;

    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->results = collect();
        $this->baseUrl = $baseUrl;
    }

    public function getUsers(?int $page = 1): Collection
    {
        $response = Http::get("{$this->baseUrl}/api/users", ['page' => $page]);

        throw_if($response->failed(), $response->throw());

        $this->results->push($response->json('data'));

        if ($page === $response->object()->total_pages) {
            return $this->results->flatten(1)->mapInto(User::class);
        }

        return $this->getUsers($page + 1);
    }
}

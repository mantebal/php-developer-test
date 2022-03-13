<?php

namespace Tests\Util;

use App\Contracts\Regres\Client;
use App\Models\User;
use App\Resources\User as UserResource;
use Illuminate\Support\Collection;

class FakeRegresClient implements Client
{
    public function getUsers(): Collection
    {
        $users = User::factory()->count(2)->make();
        return collect([
            new UserResource($users->first()->getAttributes()),
            new UserResource($users->last()->getAttributes()),
        ]);
    }
}

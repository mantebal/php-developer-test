<?php

namespace App\Contracts\Regres;

use Illuminate\Support\Collection;

interface Client
{
    public function getUsers(): Collection;
}

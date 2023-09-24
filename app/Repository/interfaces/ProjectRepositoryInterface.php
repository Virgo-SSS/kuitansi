<?php

namespace App\Repository\interfaces;

use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{
    public function all(): Collection;
}

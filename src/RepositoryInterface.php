<?php

namespace Aigletter\TestTask;

interface RepositoryInterface
{
    public function getByParams(string $ipAddress, string $userAgent, string $page): Dto|null;

    public function insert(Dto $dto): bool;

    public function update(Dto $view): bool;
}
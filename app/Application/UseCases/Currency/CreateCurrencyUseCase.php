<?php

namespace App\Application\UseCases\Currency;

use App\Domain\Repositories\CurrencyRepositoryInterface;

class CreateCurrencyUseCase
{
    public function __construct(
        private CurrencyRepositoryInterface $repository
    ) {}

    public function execute(array $data)
    {
        return $this->repository->create($data);
    }
}
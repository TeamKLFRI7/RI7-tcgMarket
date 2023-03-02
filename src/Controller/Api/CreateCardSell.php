<?php

namespace App\Controller\Api;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CreateCardSell extends AbstractController
{

    public function __construct(
        private readonly GameRepository $gameRepository
    )
    {
    }

    public function __invoke(): array
    {
        return $this->gameRepository->findAll();
    }
}

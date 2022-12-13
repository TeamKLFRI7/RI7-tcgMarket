<?php

namespace App\Controller\Api;

use App\Entity\CardSet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CustomSearchController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->get('query');
        $card_set = $this->em->getRepository(CardSet::class)->search($query);

        return $this->json([
            "success" => true,
            "card_set" => $card_set
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\CardUser;
use App\Repository\CardRepository;
use App\Repository\CardSetRepository;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateSellController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private CardRepository $cardRepository,
        private UserRepository $userRepository,
        private GameRepository $gameRepository,
        private CardSetRepository $cardSetRepository
    )
    {
    }
    #[Route('/api/sellCard', name: 'sellCard', methods: ['POST'])]
    public function sell(Request $request) :JsonResponse
    {
        $data = $request->request->all();
        $file = $request->files->get('file');

        if (!$file) {
            throw new BadRequestHttpException('Une image est obligatoire');
        }

        $name = htmlspecialchars(trim($data['name']), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $quality = htmlspecialchars(trim($data['quality']), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $price = trim($data['price']);
        $cardId = trim($data['card']);
        $fkIdUserId = trim($data['fkIdUser']);
        $fkIdGameId = trim($data['fkIdGame']);
        $cardSetId = trim($data['cardSet']);

        $card = $this->cardRepository->find($cardId);
        $fkIdUser = $this->userRepository->find($fkIdUserId);
        $fkIdGame = $this->gameRepository->find($fkIdGameId);
        $cardSet = $this->cardSetRepository->find($cardSetId);

        $cardUser = (new cardUser())
            ->setName($name)
            ->setQuality($quality)
            ->setCard($card)
            ->setFkIdUser($fkIdUser)
            ->setFkIdGame($fkIdGame)
            ->setCardSet($cardSet)
            ->setPrice($price)
            ->setFile($file)
        ;

        $this->em->persist($cardUser); //Dire à doctrine de prendre en compte les modifs
        $this->em->flush(); //Ecrit les modifs en base de données

        return  $this->json($cardUser);
    }
}
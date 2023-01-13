<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class GameController extends AbstractController
{
    public function __construct(){
    }

    public function __invoke(Game $game): Game
    {
        $cards = $game->getCardUsers();
        $i = 0;
        $newCardUsers = [];
        foreach ($cards as $card) {
            $newCardUsers[] = $card;
            $i++;
            if ($i >= 10) {
                break;
            }
            //sortir au bout de 10
        }
        $cards->clear();
        foreach ($newCardUsers as $newCard) {
            $cards->add($newCard);
        }

        return $game;
    }
}

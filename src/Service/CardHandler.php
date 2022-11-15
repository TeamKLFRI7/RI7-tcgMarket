<?php

namespace App\Service;

use App\Entity\CataCard;
use App\Entity\CardSet;
use App\Entity\CardSerie;
use App\Entity\Games;
use App\Repository\GamesRepository;
use Doctrine\ORM\EntityManagerInterface;

class CardHandler
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function createCardSetFromData($data)
    {
        $games = new Games();
        $games->setNames('Pokémon');
        $games->setCreatedAt(new \DateTimeImmutable());
        $this->em->persist($games);
        $this->em->flush();

        $card_serie = new CardSerie();
        $card_serie->setGames($games);
        $card_serie->setSerieName($data['set']['series']);
        $card_serie->setSerieLink('serie LINK');
        $this->em->persist($card_serie);
        $this->em->flush();

        $card_set = new CardSet();
        $card_set->setCardSerie($card_serie);
        $card_set->setApiSetId($data['set']['id']);
        $card_set->setSetImg($data['set']['images']['logo']);
        $card_set->setSetLink('set LINK');
        $card_set->setSetName($data['set']['name']);
        $this->em->persist($card_set);
        $this->em->flush();

        $card = new CataCard();
        $card->setCardSet($card_set);
        $card->setApiCardId($data['id']);
        $card->setName($data['name']);
        $card->setImg($data['images']['large']);
        $card->setCataCardLink($data['cardmarket']['url']);
        $this->em->persist($card);
        $this->em->flush();
    }

}

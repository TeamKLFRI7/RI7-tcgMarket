<?php

namespace App\Service;

use App\Entity\CataCard;
use App\Entity\CardSet;
use App\Entity\CardSerie;
use App\Repository\GamesRepository;
use Doctrine\ORM\EntityManagerInterface;

class CardHandler
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function isCardSerieExist(string $cardSerieId) : CardSerie
    {
        return $this->em->getRepository(CardSerie::class)->findOneBy([
            'api_set_id' => $cardSerieId
        ]);
    }

    public function isCardSetExist(string $cardSetId) : CardSet
    {
        //$cardSet = $this->em->getRepository(CardSet::class)->findOneByApiSetId($cardSetId);
        return $this->em->getRepository(CardSet::class)->findOneBy([
            'api_set_id' => $cardSetId
        ]);
    }

    public function createCardSetFromData($data)
    {
//        $games = new Games();
//        $games->setNames('Pokémon');
//        $games->setCreatedAt(new \DateTimeImmutable());
//        $this->em->persist($games);
//        $this->em->flush();
// Faire un fixture pour game = Pokémon

        $game =  $this->em->getRepository(GamesRepository::class)->findOneBy([
            'name' => 'Pokémon'
        ]);

        // CARD SERIE HANDLING
        $cardSerieName = $data['set']['series'];
        $card_serie = $this->isCardSerieExist($cardSerieName);
        if (!$card_serie) {
            $card_serie = new CardSerie();
            if ($game) {
                $card_serie->setGames($game);
            }

            $card_serie->setSerieName($data['set']['series']);
            $card_serie->setSerieLink('serie LINK');
            $this->em->persist($card_serie);
        }

        // CARD SET HANDLING
        $cardSetId = $data['set']['id'];
        $card_set = $this->isCardSetExist($cardSetId);
        if (!$card_set) {
            $card_set = new CardSet();
            $card_set->setCardSerie($card_serie);
            $card_set->setApiSetId($data['set']['id']);
            $card_set->setSetImg($data['set']['images']['logo']);
            $card_set->setSetLink('set LINK');
            $card_set->setSetName($data['set']['name']);
            $this->em->persist($card_set);
        }

        // CARD HANDLING
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

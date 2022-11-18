<?php

namespace App\Service;

use App\Entity\Card;
use App\Entity\CardSet;
use App\Entity\CardSerie;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;

class CardHandler
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function isCardSerieExist(string $cardSerieName) : ?CardSerie
    {
         $serieName = $this->em->getRepository(CardSerie::class)->findOneBy([
            'serie_name' => $cardSerieName
        ]);
        return $serieName;
    }

    public function isCardSetExist(string $cardSetId) : ?CardSet
    {
        //$cardSet = $this->em->getRepository(CardSet::class)->findOneByApiSetId($cardSetId);
        $setId = $this->em->getRepository(CardSet::class)->findOneBy([
            'api_set_id' => $cardSetId
        ]);
        return $setId;
    }

    public function createCardSetFromData($data)
    {
        $game = $this->em->getRepository(Game::class)->findOneBy([
            'names' => 'Pokemon'
        ]);

        // CARD SERIE HANDLING
        $cardSerieName = $data['set']['series'];
        $card_serie = $this->isCardSerieExist($cardSerieName);
        if (!$card_serie) {
            $card_serie = new CardSerie();
            if ($game) {
                $card_serie->setFkIdGame($game);
            }

            $card_serie->setSerieName($data['set']['series']);
            $this->em->persist($card_serie);
        }

        // CARD SET HANDLING
        $cardSetId = $data['set']['id'];
        $card_set = $this->isCardSetExist($cardSetId);
        if (!$card_set) {
            $card_set = new CardSet();
            $card_set->setCardSerie($card_serie);
            $card_set->setApiSetId($data['set']['id']);
            $card_set->setImg($data['set']['images']['logo']);
            $card_set->setSetName($data['set']['name']);
            $this->em->persist($card_set);
        }

        // CARD HANDLING
        $card = new Card();
        $card->setCardSet($card_set);
        $card->setApiCardId($data['id']);
        $card->setName($data['name']);
        $card->setImg($data['images']['large']);
        $card->setLink('no link');
        if (array_key_exists('cardmarket', $data) == true) {
            $card->setLink($data['cardmarket']['url']);
        }
        $this->em->persist($card);

        $this->em->flush();
    }

}
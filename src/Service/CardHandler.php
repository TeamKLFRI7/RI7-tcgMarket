<?php

namespace App\Service;

use App\Entity\CataCard;
use App\Entity\CardSet;
use App\Entity\CardSerie;
use App\Entity\Games;
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
        dump(gettype($serieName));
        return $serieName;
    }

    public function isCardSetExist(string $cardSetId) : ?CardSet
    {
        //$cardSet = $this->em->getRepository(CardSet::class)->findOneByApiSetId($cardSetId);
        $setId = $this->em->getRepository(CardSet::class)->findOneBy([
            'api_set_id' => $cardSetId
        ]);
        dump($setId);
        return $setId;
    }

    public function createCardSetFromData($data)
    {
        $game = $this->em->getRepository(Games::class)->findOneBy([
            'names' => 'Pokemon'
        ]);

        // CARD SERIE HANDLING
        $cardSerieName = $data['set']['series'];
        dump($cardSerieName);
        dump($this->isCardSerieExist($cardSerieName));
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

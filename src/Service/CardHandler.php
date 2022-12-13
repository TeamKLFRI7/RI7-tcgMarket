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

    // Vérifie si la card série existe dans la DB en se basant sur le serieName
    public function isCardSerieExist(string $cardSerieName) : ?CardSerie
    {
         $serieName = $this->em->getRepository(CardSerie::class)->findOneBy([
            'serieName' => $cardSerieName
        ]);
        return $serieName;
    }

    // Véfifie si le card set existe dans la DB en se basant sur l'id du sert donnée par l'API
    public function isCardSetExist(string $cardSetId) : ?CardSet
    {
       $setId = $this->em->getRepository(CardSet::class)->findOneBy([
            'apiSetId' => $cardSetId
        ]);
        return $setId;
    }

    public function createCardSetFromData($data)
    {
        // On récupère le game créer avec dataFixture et on l'attribut directement à chaque série
        $game = $this->em->getRepository(Game::class)->findOneBy([
            'name' => 'Pokemon'
        ]);

        // CARD SERIE HANDLING
        $cardSerieName = $data['set']['series'];
        // Vérifie si la série existe
        $card_serie = $this->isCardSerieExist($cardSerieName);
        if (!$card_serie) {
            // Si elle n'existe pas alors on instancie une nouvelle série
            $card_serie = new CardSerie();
            if ($game) {
                $card_serie->setFkIdGame($game);
            }

            $card_serie->setSerieName($data['set']['series']);
            $card_serie->setImg("myIMG");
            $this->em->persist($card_serie);
        }

        // CARD SET HANDLING
        $cardSetId = $data['set']['id'];
        // Vérifie si le set existe
        $card_set = $this->isCardSetExist($cardSetId);
        if (!$card_set) {
            // Si il n'existe pas on instancie un nouveau Set
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
        $this->em->clear();
    }

}
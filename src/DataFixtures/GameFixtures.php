<?php

namespace App\DataFixtures;

use App\Entity\Games;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $game = new Games();
        $game->setNames('Pokémon');
        $game->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($game);

        $manager->flush();
    }
}

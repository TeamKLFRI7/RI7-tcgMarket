<?php

namespace App\Command;


use App\Entity\CardSet;
use App\Service\CardHandler;
use Symfony\Component\Console\Attribute\AsCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'card:main',
    description: 'Test ETL',
    hidden: false,
)]
class SetCardNameCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private HttpClientInterface $client,
        private CardHandler $ph
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Start ETL',
            '============',
        ]);

        $nb = 1;
        $pages = $this->client->request('GET', 'https://api.pokemontcg.io/v2/cards', [
            'headers' => [
                'Accept' => 'application/json',
                'x-api-key' => 'c3bdef54-d130-4602-9fc2-060e5b513ffc',
            ],
        ]);

        $maxPages = $pages->toArray();

        while ($nb <= $maxPages['pageSize']) {
            $output->writeln([
                'maxPages : '. $maxPages['pageSize'],
                'actual Page : '. $nb,
            ]);

            $response = $this->client->request('GET', 'https://api.pokemontcg.io/v2/cards?page='.$nb, [
                'headers' => [
                    'Accept' => 'application/json',
                    'x-api-key' => 'c3bdef54-d130-4602-9fc2-060e5b513ffc',
                ],
            ]);
    
            $pokemons = $response->toArray();
            $progressBar = new ProgressBar($output, sizeof($pokemons['data']));
            $progressBar->setFormat('debug');
            $progressBar->start();
    
            foreach ($pokemons['data'] as $pokemon) {
                $this->ph->createCardSetFromData($pokemon);
            }

            sleep(0.5);

            $nb += 1;
            $progressBar->finish();
        };

        $output->writeln([
            '',
            'End ETL',
            '============',
        ]);

        return Command::SUCCESS;
    }
}
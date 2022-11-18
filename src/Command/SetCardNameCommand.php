<?php

namespace App\Command;


use App\Service\CardHandler;
use Symfony\Component\Console\Attribute\AsCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Doctrine\ORM\EntityManagerInterface;
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
                'x-api-key' => '1db10c62-e29f-4189-93aa-ef100c275005',
            ],
        ]);

        $maxPages = $pages->toArray();
        $output->writeln([
            ' ',
            'maxPages : '. $maxPages['pageSize'],
        ]);

        while ($nb <= $maxPages['pageSize']) {
            
            $output->writeln([
                ' ',
                'actual Page : '. $nb . '/' . $maxPages['pageSize'],
            ]);

            $response = $this->client->request('GET', 'https://api.pokemontcg.io/v2/cards?page='.$nb, [
                'headers' => [
                    'Accept' => 'application/json',
                    'x-api-key' => '1db10c62-e29f-4189-93aa-ef100c275005'
                    ,
                ],
            ]);
    
            $pokemons = $response->toArray();
            $progressBar = new ProgressBar($output, sizeof($pokemons['data']));
            $progressBar->setFormat('debug');
            $progressBar->start();
    
            foreach ($pokemons['data'] as $pokemon) {
                $this->ph->createCardSetFromData($pokemon);
            }

            sleep(1);

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
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
        //  Pour lancer l'ETL sans pblm de mémoire :  php -d memory_limit=512M bin/console card:main
        $output->writeln([
            'Start ETL',
            '============',
        ]);

        $nb = 1;
        $pages = $this->client->request('GET', 'https://api.pokemontcg.io/v2/cards', [
            'headers' => [
                'Accept' => 'application/json',
                'x-api-key' => '4ec1c77f-f189-4bbe-9544-cae6f803fcc7',
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
                    'x-api-key' => '4ec1c77f-f189-4bbe-9544-cae6f803fcc7'
                    ,
                ],
            ]);
    
            $pokemons = $response->toArray();

            if (sizeof($pokemons['data']) > 1) {

                $progressBar = new ProgressBar($output, sizeof($pokemons['data']));
                $progressBar->setFormat('debug');
                $progressBar->start();

                foreach ($pokemons['data'] as $pokemon) {
                    $this->ph->createCardSetFromData($pokemon);
                }

                sleep(1);
                $nb += 1;

                $this->em->flush();
                $this->em->clear();
                unset($pokemons);

                $progressBar->finish();
                
            } else {
                break;
            }
        };

        $output->writeln([
            '',
            'End ETL',
            '============',
        ]);

        return Command::SUCCESS;
    }
}
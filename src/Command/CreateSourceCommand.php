<?php

namespace App\Command;

use App\Entity\Source;
use App\Entity\SourceCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateSourceCommand extends Command
{
    protected static $defaultName = 'app:create-source';

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $doctrine;

    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setHelp('Cette commande permet d\'ajouter les sources (la source de category RSS s\'ajoute automatiquement)');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $sourceCategoryBDD = $this->doctrine->getRepository(SourceCategory::class)->findOneBy(['name' => 'BDD']);
        $sourceCategoryRSS = $this->doctrine->getRepository(SourceCategory::class)->findOneBy(['name' => 'RSS']);

        if (
            empty($sourceCategoryBDD) || 
            empty($sourceCategoryRSS)
        ) {
            $output->writeln('<fg=black;bg=red>Avant d\'ajouter les sources, veuillez ajouter les sources category via la commande suivante : php bin/console app:create-source-category</>');
            return Command::FAILURE;
        }

        $output->writeln('Pour ajouter une source de category BDD, merci de repondre au questions suivante');

        $bddType = $io->ask('Type de BDD ?', 'mysqli', function ($bddType) {
            if (!is_string($bddType)) {
                throw new \RuntimeException('Merci de saisir une string.');
            }
        
            return (string) strtolower($bddType);
        });

        $bddDomain = $io->ask('Domaine de la BDD ?', 'localhost', function ($bddDomain) {
            if (!is_string($bddDomain)) {
                throw new \RuntimeException('Merci de saisir une string.');
            }
        
            return (string) strtolower($bddDomain);
        });

        $bddPort = $io->ask('Port de la BDD ?', '3306', function ($bddPort) {
            if (!is_string($bddPort)) {
                throw new \RuntimeException('Merci de saisir une string.');
            }
        
            return (string) strtolower($bddPort);
        });

        $bddUser = $io->ask('Utilisateur de la BDD ?', 'root', function ($bddUser) {
            if (!is_string($bddUser)) {
                throw new \RuntimeException('Merci de saisir une string.');
            }
        
            return (string) strtolower($bddUser);
        });

        $bddPassword = $io->askHidden('Mot de passe de la BDD ?', function ($bddPassword) {
            if (!is_string($bddPassword) && !empty($bddPassword)) {
                throw new \RuntimeException('Merci de saisir une string.');
            }
        
            return (string) strtolower($bddPassword);
        });

        $bddName = $io->ask('Nom de la BDD ?', 'alltricks', function ($bddName) {
            if (!is_string($bddName)) {
                throw new \RuntimeException('Merci de saisir une string.');
            }
        
            return (string) strtolower($bddName);
        });

        try {
            $sourceRSSName = "http://www.lemonde.fr/rss/une.xml";
            $sourceRSS = (new Source())
                            ->setName($sourceRSSName)
                            ->setSourceCategory($sourceCategoryRSS);

            $sourceBDD = (new Source())
                            ->setSourceCategory($sourceCategoryBDD)
                            ->setDatabaseType($bddType)
                            ->setDatabaseDomain($bddDomain)
                            ->setDatabasePort($bddPort)
                            ->setDatabaseUser($bddUser)
                            ->setDatabasePassword($bddPassword)
                            ->setDatabaseName($bddName);

            $this->doctrine->getManager()->persist($sourceBDD);                
            $this->doctrine->getManager()->persist($sourceRSS);
            
            $this->doctrine->getManager()->flush();

        } catch (\Exception $e) {
            $output->writeln('<fg=black;bg=red>L\'ajout des sources a échoué : ' . $e->getMessage() . '</>');
            return Command::FAILURE;
        }

        $output->writeln('<fg=black;bg=green>L\'ajout de la source de category RSS avec l\'url suivant : ' . $sourceRSSName . ', a été ajouté');
        $output->writeln('<fg=black;bg=green>L\'ajout de la source de category BDD (' . $bddType . '://' . $bddUser . ':' . $bddPassword . '@' . $bddDomain . ':' . $bddPort . '/' . $bddName . '), a été ajouté');
        return Command::SUCCESS;
    }
}
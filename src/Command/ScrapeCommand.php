<?php

namespace App\Command;

use App\Service\Search\FindForSearchQueryService;
use Goutte\Client;
use sngrl\PhpFirebaseCloudMessaging\Client as MessageClient;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Notification;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Topic;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\HttpClient\HttpClient;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ScrapeCommand extends Command
{
    protected static $defaultName = 'app:scrape';

    private $client;

    private $url = "https://www.healthfoam.com/koopjeshoek";

    private $count = 0;
    /**
     * @var FindForSearchQueryService
     */
    private $findForSearchQueryService;

    /**
     * ScrapeCommand constructor.
     * @param FindForSearchQueryService $findForSearchQueryService
     * @param string|null $name
     */
    public function __construct(
        FindForSearchQueryService $findForSearchQueryService,
        string $name = null
    ) {
        parent::__construct($name);
        $this->findForSearchQueryService = $findForSearchQueryService;
    }


    protected function configure()
    {
        $this
            ->setDescription('Need a new matrass')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
        $this->client = new Client(HttpClient::create(['timeout' => 60]));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Starting');
        try {
            $this->findForSearchQueryService->findForAll();
        } catch (LoaderError $e) {
//            $output->writeln()
        } catch (RuntimeError $e) {
        } catch (SyntaxError $e) {
        }

        $output->writeln('All done');
        return 1;
    }
}

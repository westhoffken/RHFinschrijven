<?php


namespace App\Service\Search;


use App\Entity\SearchQuery;
use App\Mail\ConfirmationMail;
use App\Mail\UpdateMail;
use App\Manager\SearchQueryManager;
use Doctrine\ORM\EntityManagerInterface;
use Goutte\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\HttpClient\HttpClient;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class FindForSearchQueryService
 * @package App\Service\Search
 */
class FindForSearchQueryService
{

    /**
     * @var CssSelectorConverter
     */
    private $ccsConverter;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var SearchQueryManager
     */
    private $searchQueryManager;

    /**
     * @var string
     */
    private $url = "https://www.healthfoam.com/koopjeshoek";

    /**
     * @var Client
     */
    private $client;
    /**
     * @var ConfirmationMail
     */
    private $updateMail;

    /**
     * @var
     */
    private $crawler;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * FindForSearchQueryService constructor.
     * @param SearchQueryManager $searchQueryManager
     * @param UpdateMail $updateMail
     */
    public function __construct(
        SearchQueryManager $searchQueryManager,
        UpdateMail $updateMail,
        LoggerInterface $logger
    ) {
        $this->ccsConverter = new CssSelectorConverter();
        $this->searchQueryManager = $searchQueryManager;
        $this->client = new Client(HttpClient::create(['timeout' => 60]));
        $this->updateMail = $updateMail;
        $this->logger = $logger;
    }

    /**
     * @param SearchQuery $searchQuery
     */
    public function findForSingleSearchQuery(SearchQuery $searchQuery): void
    {
        $this->crawler = $this->client->request('GET', $this->url);
        $this->find($searchQuery);
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function findForAll(): void
    {
        $this->logger->debug('Finding for all search queries');
        $searchQeuries = $this->searchQueryManager->findAll();
        $this->crawler = $this->client->request('GET', $this->url);
        foreach ($searchQeuries as $searchQuery) {
            $this->find($searchQuery);
        }
    }

    /**
     * @param SearchQuery $searchQuery
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function find(SearchQuery $searchQuery)
    {
        $this->crawler->filterXpath($this->ccsConverter->toXPath('.koopjeshoek .product-layout .product-info .caption h4'))->each(function ($node) use ($searchQuery) {
            dump($this->makeMatrassText($searchQuery));
            if (
                stripos($node->text(), $searchQuery->getSize()->getSizeText()) !== false
                && stripos($node->text(), SearchQuery::MATRASS_TYPE[$searchQuery->getType()]) !== false
                && stripos($node->text(), SearchQuery::MATRASS_FIRMNESS[$searchQuery->getFirmness()]) !== false
                && stripos($node->text(), SearchQuery::MATRASS_CLASSIFICATION[$searchQuery->getClassification()]) !== false
            ) {
                $this->sendEmail($searchQuery, $this->makeMatrassText($searchQuery));
            }
        });
    }

    /**
     * @param SearchQuery $searchQuery
     * @param string $matrass
     * @return int
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function sendEmail(SearchQuery $searchQuery, string $matrass): int
    {
        $this->logger->info('Sending mails', ['email' => $searchQuery->getEmail()]);
        if ($this->canReceiveMail($searchQuery)) {

            $searchQuery->setLastReceivedMailAt(new \DateTime());
            $this->searchQueryManager->saveSearchQuery($searchQuery);

            return $this->updateMail->sendEmail($searchQuery->getEmail(), $searchQuery->getName(), $matrass);
        }
        dump('test');
        return false;

    }

    /**
     * @param SearchQuery $searchQuery
     * @return bool
     */
    private function canReceiveMail(SearchQuery $searchQuery): bool
    {
        if ($searchQuery->getLastReceivedMailAt() === null) {
            return true;
        }

        $now = new \DateTime();
        $diff = $searchQuery->getLastReceivedMailAt()->diff($now);

        return $diff->days >= 1;
    }

    /**
     * @param SearchQuery $searchQuery
     * @return string
     */
    private function makeMatrassText(SearchQuery $searchQuery): string
    {
        return
            $searchQuery->getSize()->getSizeText()
            . ' ' .
            SearchQuery::MATRASS_CLASSIFICATION[$searchQuery->getClassification()]
            . ' ' .
            SearchQuery::MATRASS_TYPE[$searchQuery->getType()]
            . ' ' .
            SearchQuery::MATRASS_FIRMNESS[$searchQuery->getFirmness()];
    }


}

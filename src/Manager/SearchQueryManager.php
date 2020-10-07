<?php


namespace App\Manager;


use App\Entity\SearchQuery;
use Doctrine\ORM\EntityManagerInterface;

class SearchQueryManager
{

    /**
     * @var SizeManager
     */
    private $sizeManager;
    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * ProductManager constructor.
     * @param SizeManager $sizeManager
     */
    public function __construct(
        SizeManager $sizeManager,
        EntityManagerInterface $em
    ) {
        $this->sizeManager = $sizeManager;

        $this->em = $em;
    }


    /**
     * @param array $productData
     * @param SearchQuery $searchQuery
     * @return SearchQuery
     */
    public function makeEntity(array $productData, SearchQuery $searchQuery): SearchQuery
    {
        $searchQuery->setSize($this->sizeManager->findOneSizeById($productData['size']));

        if ($productData['type'] == 2) {
            $searchQuery->setClassification($productData['classification2']);
        }else{
            $searchQuery->setClassification($productData['classification']);
        }
        $searchQuery->setFirmness($productData['firmness']);
        $searchQuery->setType($productData['type']);
        $searchQuery->setName($productData['name']);
        $searchQuery->setPhoneNumber($productData['phonenumber']);
        $searchQuery->setEmail($productData['email']);
        $searchQuery->setCreated(new \DateTime());
//        dump($productData);
//        die();

        return $searchQuery;
    }


    public function findByEmail(string $email)
    {
        return $this->em->getRepository(SearchQuery::class)->findOneBy(['email' => $email]);
    }

    public function removeEntity(SearchQuery $searchQuery)
    {
        $this->em->remove($searchQuery);
        $this->em->flush();
    }

    /**
     * @param SearchQuery $searchQuery
     * @param bool $persist
     * @return bool|null
     */
    public function saveSearchQuery(SearchQuery $searchQuery, bool $persist = false): ?bool
    {
        if ($persist) {
            $this->em->persist($searchQuery);
        }

        try {
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function findAll()
    {
        return $this->em->getRepository(SearchQuery::class)->findAll();
    }
}

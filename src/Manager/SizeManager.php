<?php


namespace App\Manager;


use App\Entity\Size;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SizeManager
 * @package App\Manager
 */
class SizeManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * SizeManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }

    /**
     * @param int $id
     * @return Size|object|null
     */
    public function findOneSizeById(int $id)
    {
        return $this->em->getRepository(Size::class)->find($id);
    }

    /**
     * @return Size[]|object[]
     */
    public function findAllSizes()
    {
        return $this->em->getRepository(Size::class)->findAllSorted();
    }

}

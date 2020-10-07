<?php


namespace App\Manager;


use App\Entity\Size;
use App\Entity\Subscriptions;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SizeManager
 * @package App\Manager
 */
class SubscriptionManager
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

    public function makeEntity(array $data)
    {
        $subscription = new Subscriptions();
        $subscription->setName($data['name']);
        $subscription->setEmail($data['email']);
        $subscription->setPhoneNumber($data['phoneNumber']);

        return $subscription;
    }

}

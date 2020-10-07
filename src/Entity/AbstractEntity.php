<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractEntity
 *
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
abstract class AbstractEntity
{

    /**
     * @var int
     *
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AbstractEntity
     */
    public function setId(int $id): AbstractEntity
    {
        $this->id = $id;
        return $this;
    }

}

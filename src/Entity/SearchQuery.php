<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchQueryRepository")
 */
class SearchQuery extends AbstractEntity
{

    public const MATRASS_FIRMNESS = [
        1 => 'Soft',
        2 => 'Medium',
        3 => 'Firm',
        4 => 'Extra Firm'
    ];

    public const MATRASS_TYPE = [
        1 => 'Koudschuim',
        2 => 'Traagschuim'
    ];

    public const MATRASS_CLASSIFICATION = [
        1 => 'Comfort De Luxe',
        2 => 'Comfort Premium Air',
        3 => 'Perfection',
        4 => 'Original Support',
        5 => 'Premium Support',
        6 => 'Perfection',
    ];
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $firmness;

    /**
     * @ORM\Column(type="integer")
     */
    private $classification;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Size", inversedBy="Product")
     */
    private $size;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastReceivedMailAt;

    /**
     * SearchQuery constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $Name
     * @return $this
     */
    public function setName(string $Name): self
    {
        $this->name = $Name;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getFirmness(): ?string
    {
        return $this->firmness;
    }

    /**
     * @param string $firmness
     * @return $this
     */
    public function setFirmness(string $firmness): self
    {
        $this->firmness = $firmness;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClassification(): ?string
    {
        return $this->classification;
    }

    /**
     * @param string $classification
     * @return $this
     */
    public function setClassification(string $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * @return Size|null
     */
    public function getSize(): ?Size
    {
        return $this->size;
    }

    /**
     * @param Size|null $size
     * @return $this
     */
    public function setSize(?Size $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return SearchQuery
     */
    public function setEmail($email): SearchQuery
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     * @return SearchQuery
     */
    public function setPhoneNumber($phoneNumber): SearchQuery
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getLastReceivedMailAt(): ?\DateTimeInterface
    {
        return $this->lastReceivedMailAt;
    }

    public function setLastReceivedMailAt(?\DateTimeInterface $lastReceivedMailAt): self
    {
        $this->lastReceivedMailAt = $lastReceivedMailAt;

        return $this;
    }


}

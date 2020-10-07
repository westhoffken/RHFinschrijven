<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SizeRepository")
 */
class Size
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\OneToMany(targetEntity="SearchQuery", mappedBy="size")
     */
    private $Product;

    public function __construct()
    {
        $this->Product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return Collection|SearchQuery[]
     */
    public function getProduct(): Collection
    {
        return $this->Product;
    }

    public function addProduct(SearchQuery $product): self
    {
        if (!$this->Product->contains($product)) {
            $this->Product[] = $product;
            $product->setSize($this);
        }

        return $this;
    }

    public function removeProduct(SearchQuery $product): self
    {
        if ($this->Product->contains($product)) {
            $this->Product->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getSize() === $this) {
                $product->setSize(null);
            }
        }

        return $this;
    }

    public function getSizeText()
    {
        return $this->width . ' x ' . $this->height;
    }
}

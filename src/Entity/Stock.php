<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="stocks")
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="stocks")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=false)
     */
    private ?Article $article = null;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=false)
     */
    private ?int $quantity = null;

    /**
     * @var float|null
     * @ORM\Column(type="float", nullable=false)
     */
    private ?float $price = null;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=false)
     */
    private ?string $size = null;

    /**
     * @return integer|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param integer|null $quantity
     * @return Stock
     */
    public function setQuantity(?int $quantity): Stock
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return Stock
     */
    public function setPrice(?float $price): Stock
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSize(): ?string 
    {
        return $this->size;
    }

    /**
     * @param string|null $size
     * @return Stock
     */
    public function setSize(?string $size): Stock 
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return Article|null
     */
    public function getArticle(): ?Article
    {
        return $this->article;
    }

    /**
     * @param Article|null $article
     * @return Stock
     */
    public function setArticle(?Article $article): Stock
    {
        $this->article = $article;
        return $this;
    }
}
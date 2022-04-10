<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private ?string $name = null;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=false)
     */
    private ?string $content = null;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=false)
     */
    private ?string $imgSrc = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Source", inversedBy="articles")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id", nullable=false)
     */
    private ?Source $source = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ArticleCategory", inversedBy="articles")
     * @ORM\JoinColumn(name="article_category_id", referencedColumnName="id", nullable=false)
     */
    private ?ArticleCategory $articleCategory = null;

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Article
     */
    public function setName(?string $name): Article
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return Article
     */
    public function setContent(?string $content): Article
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImgSrc(): ?string
    {
        return $this->imgSrc;
    }

    /**
     * @param string|null $imgSrc
     * @return Article
     */
    public function setImgSrc(?string $imgSrc): Article
    {
        $this->imgSrc = $imgSrc;
        return $this;
    }

    /**
     * @return Source|null
     */
    public function getSource(): ?Source
    {
        return $this->source;
    }

    /**
     * @param Source|null $source
     * @return Article
     */
    public function setSource(?Source $source): Article
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return ArticleCategory|null
     */
    public function getArticleCategory(): ?ArticleCategory
    {
        return $this->articleCategory;
    }

    /**
     * @param ArticleCategory|null $articleCategory
     * @return Article
     */
    public function setArticleCategory(?ArticleCategory $articleCategory): Article
    {
        $this->articleCategory = $articleCategory;
        return $this;
    }
}
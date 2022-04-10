<?php

namespace App\Entity;

use App\Repository\ArticleCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="articles_category")
 * @ORM\Entity(repositoryClass=ArticleCategoryRepository::class)
 */
class ArticleCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private ?string $name = null;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private ?string $selectLabel = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="articleCategory")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

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
     * @return ArticleCategory
     */
    public function setName(?string $name): ArticleCategory
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSelectLabel(): ?string
    {
        return $this->selectLabel;
    }

    /**
     * @param string|null $selectLabel
     * @return ArticleCategory
     */
    public function setSelectLabel(?string $selectLabel): ArticleCategory
    {
        $this->selectLabel = $selectLabel;
        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     * @return ArticleCategory
     */
    public function addArticle(Article $article): ArticleCategory
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setArticleCategory($this);
        }
        return $this;
    }

    /**
     * @param Article $article
     * @return ArticleCategory
     */
    public function removeSource(Article $article): ArticleCategory
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            if ($article->getArticleCategory() === $this) {
                $article->setArticleCategory(null);
            }
        }
        return $this;
    }
}
<?php
namespace App\Entities;

/**
 * Class NewsArticleEntity
 * @package App\Entities
 */
class NewsArticleEntity
{
    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var string|null
     */
    private ?string $source = null;

    /**
     * @var string|null
     */
    private ?string $author = null;

    /**
     * @var string|null
     */
    private ?string $title = null;

    /**
     * @var string|null
     */
    private ?string $description = null;

    /**
     * @var string|null
     */
    private ?string $url = null;

    /**
     * @var string|null
     */
    private ?string $urlToImage = null;

    /**
     * @var string|null
     */
    private ?string $publishedAt = null;

    /**
     * @var string|null
     */
    private ?string $content = null;

    /**
     * @var string|null
     */
    private ?string $category = null;

    /**
     * @var int|null
     */
    private ?int $userId = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return NewsArticleEntity
     */
    public function setId(?int $id): NewsArticleEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string|null $source
     * @return NewsArticleEntity
     */
    public function setSource(?string $source): NewsArticleEntity
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     * @return NewsArticleEntity
     */
    public function setAuthor(?string $author): NewsArticleEntity
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return NewsArticleEntity
     */
    public function setTitle(?string $title): NewsArticleEntity
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return NewsArticleEntity
     */
    public function setDescription(?string $description): NewsArticleEntity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return NewsArticleEntity
     */
    public function setUrl(?string $url): NewsArticleEntity
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlToImage(): ?string
    {
        return $this->urlToImage;
    }

    /**
     * @param string|null $urlToImage
     * @return NewsArticleEntity
     */
    public function setUrlToImage(?string $urlToImage): NewsArticleEntity
    {
        $this->urlToImage = $urlToImage;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPublishedAt(): ?string
    {
        return $this->publishedAt;
    }

    /**
     * @param string|null $publishedAt
     * @return NewsArticleEntity
     */
    public function setPublishedAt(?string $publishedAt): NewsArticleEntity
    {
        $this->publishedAt = $publishedAt;
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
     * @return NewsArticleEntity
     */
    public function setContent(?string $content): NewsArticleEntity
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return NewsArticleEntity
     */
    public function setCategory(?string $category): NewsArticleEntity
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     * @return NewsArticleEntity
     */
    public function setUserId(?int $userId): NewsArticleEntity
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Convert the entity to an array
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'source' => $this->getSource(),
            'author' => $this->getAuthor(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'url' => $this->getUrl(),
            'urlToImage' => $this->getUrlToImage(),
            'publishedAt' => $this->getPublishedAt(),
            'content' => $this->getContent(),
            'category' => $this->getCategory(),
            'userId' => $this->getUserId(),
        ];
    }

    public static function createFromJsonArray(array $data): NewsArticleEntity
    {
        $newsArticleEntity = new NewsArticleEntity();
        // Assuming the $data array has the same keys as the properties in NewsArticleEntity
        $newsArticleEntity->source = $data['source'] ?? null;
        $newsArticleEntity->author = $data['author'] ?? null;
        $newsArticleEntity->title = $data['title'] ?? null;
        $newsArticleEntity->description = $data['description'] ?? null;
        $newsArticleEntity->url = $data['url'] ?? null;
        $newsArticleEntity->urlToImage = $data['urlToImage'] ?? null;
        $newsArticleEntity->published_at = $data['published_at'] ?? null;
        $newsArticleEntity->content = $data['content'] ?? null;
        $newsArticleEntity->category = $data['category'] ?? null;
        $newsArticleEntity->userId = $data['userId'] ?? null;
        return $newsArticleEntity;
    }

}

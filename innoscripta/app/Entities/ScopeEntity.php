<?php
namespace App\Entities;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

/**
 * Class ScopeEntity
 * @package App\Entities
 */
class ScopeEntity implements ScopeEntityInterface
{
    use EntityTrait;

    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $slug;

    /**
     * @var string|null
     */
    private ?string $description = null;

    /**
     * @var int
     */
    private int $project_id;

    /**
     * @var ProjectEntity|null
     */
    protected ?ProjectEntity $projectEntity = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ScopeEntity
     */
    public function setId(?int $id): ScopeEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ScopeEntity
     */
    public function setName(string $name): ScopeEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return ScopeEntity
     */
    public function setSlug(string $slug): ScopeEntity
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->project_id;
    }

    /**
     * @param int $project_id
     * @return ScopeEntity
     */
    public function setProjectId(int $project_id): ScopeEntity
    {
        $this->project_id = $project_id;
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
     * @return ScopeEntity
     */
    public function setDescription(?string $description): ScopeEntity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return ProjectEntity|null
     */
    public function getProjectEntity(): ?ProjectEntity
    {
        return $this->projectEntity;
    }

    /**
     * @param ProjectEntity|null $projectEntity
     * @return ScopeEntity
     */
    public function setProjectEntity(?ProjectEntity $projectEntity): ScopeEntity
    {
        $this->projectEntity = $projectEntity;
        return $this;
    }


    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return ($this->id !== null);
    }

    /**
     * @return bool
     */
    public function isPersisted(): bool
    {
        return $this->hasId();
    }

    /**
     * @return bool
     */
    public function isProjectEntityLoaded(): bool
    {
        return !empty($this->projectEntity);
    }

    /**
     * @return bool
     */
    public function isNotPersisted(): bool
    {
        return !($this->isPersisted());
    }


    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->getIdentifier();
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->slug;
    }

    /**
     * @return bool
     */
    public function hasProject(): bool
    {
        return !(is_null($this->projectEntity));
    }

    /**
     * @return bool
     */
    public function hasDescription(): bool
    {
        return !is_null($this->description);
    }

}

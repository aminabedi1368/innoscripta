<?php
namespace App\Entities;

/**
 * Class RoleEntity
 * @package App\Entities
 */
class RoleEntity
{

    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var int
     */
    private int $project_id;

    /**
     * @var ProjectEntity|null
     */
    private ?ProjectEntity $projectEntity;

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
     * @var ScopeEntity[]
     */
    private array $scopes = [];

    /**
     * @var UserEntity[]
     */
    private array $users = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return ($this->id !==  null);
    }

    /**
     * @return bool
     */
    public function isPersisted(): bool
    {
        return $this->hasId();
    }

    /**
     * @param int $id
     * @return RoleEntity
     */
    public function setId(int $id): RoleEntity
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
     * @return RoleEntity
     */
    public function setName(string $name): RoleEntity
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
     * @return RoleEntity
     */
    public function setSlug(string $slug): RoleEntity
    {
        $this->slug = $slug;
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
     * @return RoleEntity
     */
    public function setDescription(?string $description): RoleEntity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return ScopeEntity[]
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    /**
     * @param ScopeEntity[] $scopes
     * @return RoleEntity
     */
    public function setScopes(array $scopes): RoleEntity
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * @return UserEntity[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param UserEntity[] $users
     * @return RoleEntity
     */
    public function setUsers(array $users): RoleEntity
    {
        $this->users = $users;
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
     * @return RoleEntity
     */
    public function setProjectId(int $project_id): RoleEntity
    {
        $this->project_id = $project_id;
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
     * @return RoleEntity
     */
    public function setProjectEntity(?ProjectEntity $projectEntity): RoleEntity
    {
        $this->projectEntity = $projectEntity;
        return $this;
    }


    /**
     * @return bool
     */
    public function hasUser(): bool
    {
        return (!empty($this->users));
    }

    /**
     * @return bool
     */
    public function hasScope(): bool
    {
        return (!empty($this->scopes));
    }


    /**
     * @return bool
     */
    public function isProjectEntityLoaded(): bool
    {
        return !empty($this->projectEntity);
    }


}

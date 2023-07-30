<?php
namespace App\Entities;

use Carbon\Carbon;

/**
 * Class ProjectEntity
 * @package App\Entities
 */
class ProjectEntity
{

    /**
     * @var int|null
     */
    private ?int $id;

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
    private ?string $description;

    /**
     * @var string|null
     */
    private ?string $project_id = null;

    /**
     * @var int
     */
    private int $creator_user_id;

    /**
     * @var UserEntity|null
     */
    private ?UserEntity $creator_user;

    /**
     * @var bool
     */
    private bool $is_first_party;

    /**
     * @var array|null
     */
    private ?array $clients;

    /**
     * @var array|null
     */
    private ?array $roles;

    /**
     * @var array|null
     */
    private ?array $scopes;

    /**
     * @var Carbon
     */
    private Carbon $created_at;

    /**
     * @var Carbon
     */
    private Carbon $updated_at;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ProjectEntity
     */
    public function setId(?int $id): ProjectEntity
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
     * @return ProjectEntity
     */
    public function setName(string $name): ProjectEntity
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
     * @return ProjectEntity
     */
    public function setSlug(string $slug): ProjectEntity
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
     * @return ProjectEntity
     */
    public function setDescription(?string $description): ProjectEntity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProjectId(): ?string
    {
        return $this->project_id;
    }

    /**
     * @param string $project_id
     * @return ProjectEntity
     */
    public function setProjectId(string $project_id): ProjectEntity
    {
        $this->project_id = $project_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatorUserId(): int
    {
        return $this->creator_user_id;
    }

    /**
     * @param int $creator_user_id
     * @return ProjectEntity
     */
    public function setCreatorUserId(int $creator_user_id): ProjectEntity
    {
        $this->creator_user_id = $creator_user_id;
        return $this;
    }

    /**
     * @return UserEntity|null
     */
    public function getCreatorUser(): ?UserEntity
    {
        return $this->creator_user;
    }

    /**
     * @param UserEntity|null $creator_user
     * @return ProjectEntity
     */
    public function setCreatorUser(?UserEntity $creator_user): ProjectEntity
    {
        $this->creator_user = $creator_user;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFirstParty(): bool
    {
        return $this->is_first_party;
    }

    /**
     * @param bool $is_first_party
     * @return ProjectEntity
     */
    public function setIsFirstParty(bool $is_first_party): ProjectEntity
    {
        $this->is_first_party = $is_first_party;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getClients(): ?array
    {
        return $this->clients;
    }

    /**
     * @param array|null $clients
     * @return ProjectEntity
     */
    public function setClients(?array $clients): ProjectEntity
    {
        $this->clients = $clients;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array|null $roles
     * @return ProjectEntity
     */
    public function setRoles(?array $roles): ProjectEntity
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getScopes(): ?array
    {
        return $this->scopes;
    }

    /**
     * @param array|null $scopes
     * @return ProjectEntity
     */
    public function setScopes(?array $scopes): ProjectEntity
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * @param Carbon $created_at
     * @return ProjectEntity
     */
    public function setCreatedAt(Carbon $created_at): ProjectEntity
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * @param Carbon $updated_at
     * @return ProjectEntity
     */
    public function setUpdatedAt(Carbon $updated_at): ProjectEntity
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return bool
     */
    public function areRolesLoaded()
    {
        return !empty($this->roles);
    }

    /**
     * @return bool
     */
    public function areScopesLoaded()
    {
        return !empty($this->scopes);
    }

    /**
     * @return bool
     */
    public function areClientsLoaded()
    {
        return !empty($this->clients);
    }

    /**
     * @return bool
     */
    public function isUserEntityLoaded()
    {
        return !empty($this->creator_user);
    }

    /**
     * @return bool
     */
    public function hasId()
    {
        return !empty($this->id);
    }

    /**
     * @return bool
     */
    public function isPersisted()
    {
        return $this->hasId();
    }

    /**
     * @return bool
     */
    public function isNotPersisted()
    {
        return !$this->isPersisted();
    }


}

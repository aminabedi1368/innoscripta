<?php
namespace App\Entities;

use App\Constants\ClientConstants;
use Carbon\Carbon;
use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * Class ClientEntity
 * @package App\Entities
 */
class ClientEntity implements ClientEntityInterface
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
     * @see ClientConstants::CLIENT_TYPE_MOBILE
     * @see ClientConstants::CLIENT_TYPE_WEB
     * @see ClientConstants::CLIENT_TYPE_BACKEND
     *
     * @var string
     */
    private string $type;

    /**
     * @see ClientConstants::OAUTH_TYPE_PUBLIC
     * @see ClientConstants::OAUTH_TYPE_CONFIDENTIAL
     *
     * @var string
     */
    private string $oauth_client_type;

    /**
     * @var string|null
     */
    private ?string $client_id = null;

    /**
     * @var string|null
     */
    private ?string $client_secret = null;

    /**
     * @var bool
     */
    private bool $is_active;

    /**
     * @var int
     */
    private int $project_id;

    /**
     * @var ProjectEntity|null
     */
    private ?ProjectEntity $projectEntity;

    /**
     * @var array
     */
    private array $redirect_urls = [];

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
     * @return ClientEntity
     */
    public function setId(?int $id): ClientEntity
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
     * @return ClientEntity
     */
    public function setName(string $name): ClientEntity
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
     * @return ClientEntity
     */
    public function setSlug(string $slug): ClientEntity
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return ClientEntity
     */
    public function setType(string $type): ClientEntity
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    /**
     * @return boolean
     */
    public function hasClientId()
    {
        return !empty($this->client_id);
    }

    /**
     * @return boolean
     */
    public function hasClientSecret()
    {
        return !empty($this->client_secret);
    }

    /**
     * @param string $client_id
     * @return ClientEntity
     */
    public function setClientId(string $client_id): ClientEntity
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientSecret(): ?string
    {
        return $this->client_secret;
    }

    /**
     * @param string $client_secret
     * @return ClientEntity
     */
    public function setClientSecret(string $client_secret): ClientEntity
    {
        $this->client_secret = $client_secret;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     * @return ClientEntity
     */
    public function setIsActive(bool $is_active): ClientEntity
    {
        $this->is_active = $is_active;
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
     * @return ClientEntity
     */
    public function setProjectId(int $project_id): ClientEntity
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
     * @return ClientEntity
     */
    public function setProjectEntity(?ProjectEntity $projectEntity): ClientEntity
    {
        $this->projectEntity = $projectEntity;
        return $this;
    }

    /**
     * @return array
     */
    public function getRedirectUrls(): array
    {
        return $this->redirect_urls;
    }

    /**
     * @param array $redirect_urls
     * @return ClientEntity
     */
    public function setRedirectUrls(array $redirect_urls): ClientEntity
    {
        $this->redirect_urls = $redirect_urls;
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
     * @return ClientEntity
     */
    public function setCreatedAt(Carbon $created_at): ClientEntity
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
     * @return ClientEntity
     */
    public function setUpdatedAt(Carbon $updated_at): ClientEntity
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return bool
     */
    public function isProjectEntityLoaded()
    {
        return !empty($this->projectEntity);
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
        return !($this->isPersisted());
    }

    /**
     * @return bool
     */
    public function hasRedirectUrl()
    {
        return !empty($this->redirect_urls);
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->client_id;
    }

    /**
     * @return string[]
     */
    public function getRedirectUri()
    {
        return $this->redirect_urls;
    }

    /**
     * @return string
     */
    public function getOauthClientType(): string
    {
        return $this->oauth_client_type;
    }

    /**
     * @param string $oauth_client_type
     * @return ClientEntity
     */
    public function setOauthClientType(string $oauth_client_type): ClientEntity
    {
        $this->oauth_client_type = $oauth_client_type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isConfidential()
    {
        return $this->oauth_client_type == ClientConstants::OAUTH_TYPE_CONFIDENTIAL;
    }

}

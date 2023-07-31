<?php
namespace App\Lib;

use App\Entities\UserEntity;
use App\Hydrators\UserHydrator;

/**
 * Class TokenInfoVO
 * @package App\Lib
 */
class TokenInfoVO
{

    /**
     * @var UserEntity | null
     */
    private ?UserEntity $userEntity;

    /**
     * @var string
     */
    private string $oauth_access_token_id;

    /**
     * @var string
     */
    private string $oauth_client_id;

    /**
     * @var string | null
     */
    private ?string $oauth_user_id;

    /**
     * @var array
     */
    private array $oauth_scopes;

    /**
     * @return UserEntity|null
     */
    public function getUserEntity(): ?UserEntity
    {
        return $this->userEntity;
    }

    /**
     * @param UserEntity|null $userEntity
     * @return TokenInfoVO
     */
    public function setUserEntity(?UserEntity $userEntity): TokenInfoVO
    {
        $this->userEntity = $userEntity;
        return $this;
    }

    /**
     * @return string
     */
    public function getOauthAccessTokenId(): string
    {
        return $this->oauth_access_token_id;
    }

    /**
     * @param string $oauth_access_token_id
     * @return TokenInfoVO
     */
    public function setOauthAccessTokenId(string $oauth_access_token_id): TokenInfoVO
    {
        $this->oauth_access_token_id = $oauth_access_token_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getOauthClientId(): string
    {
        return $this->oauth_client_id;
    }

    /**
     * @param string $oauth_client_id
     * @return TokenInfoVO
     */
    public function setOauthClientId(string $oauth_client_id): TokenInfoVO
    {
        $this->oauth_client_id = $oauth_client_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOauthUserId(): ?string
    {
        return $this->oauth_user_id;
    }

    /**
     * @param string|null $oauth_user_id
     * @return TokenInfoVO
     */
    public function setOauthUserId(?string $oauth_user_id): TokenInfoVO
    {
        $this->oauth_user_id = $oauth_user_id;
        return $this;
    }

    /**
     * @return array
     */
    public function getOauthScopes(): array
    {
        return $this->oauth_scopes;
    }

    /**
     * @param array $oauth_scopes
     * @return TokenInfoVO
     */
    public function setOauthScopes(array $oauth_scopes): TokenInfoVO
    {
        $this->oauth_scopes = $oauth_scopes;
        return $this;
    }

    /**
     * @param array $data
     * @return TokenInfoVO
     */
    public static function fromArray(array $data): TokenInfoVO
    {
        $tokenInfo = new self();
        $tokenInfo->setOauthAccessTokenId($data['oauth_access_token_id'])
            ->setOauthClientId($data['oauth_client_id'])
            ->setUserEntity(!empty($data['user_entity']) ? $data['user_entity'] : null)
            ->setOauthUserId(!empty($data['oauth_user_id']) ? $data['oauth_user_id'] : null)
            ->setOauthScopes(!empty($data['oauth_scopes']) ? [] : $data['oauth_scopes']);

        return $tokenInfo;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        /** @var UserHydrator $userHydrator */
        $userHydrator = resolve(UserHydrator::class);

        $userArray = $userHydrator->fromEntity($this->userEntity)->toArray();

        $newUserArray = [];

        $newUserArray['roles'] = $userArray['roles'];

        $newUserArray['scopes'] = [];


        foreach ($newUserArray['roles'] as $role) {

            foreach ($role['scopes'] as $scope) {
                $newUserArray['scopes'][] = $scope['slug'];
            }
        }

        $newUserArray['scopes'] = array_unique($newUserArray['scopes']);
        $newUserArray['app_fields'] = array_key_exists('app_fields', $userArray) ? $userArray['app_fields'] : null;
        $newUserArray['user_identifiers'] = $userArray['user_identifiers'];
        $newUserArray['profile'] = [
            'id' => $userArray['id'],
            'first_name' => array_key_exists('first_name', $userArray) ? $userArray['first_name'] : null,
            'last_name' => array_key_exists('last_name', $userArray) ? $userArray['last_name']: null,
            'avatar' => $userArray['avatar'],
            'status' => $userArray['status'],
        ];

        return [
            'user_entity' => $newUserArray,
            'oauth_access_token_id' => $this->oauth_access_token_id,
            'oauth_client_id' => $this->oauth_client_id,
        ];
    }
}

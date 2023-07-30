<?php
namespace App\Repos;

use App\Entities\AccessTokenEntity;
use App\Entities\UserEntity;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Exceptions\CorruptedDataException;
use App\Exceptions\Token\TokenNotFoundException;
use App\Hydrators\AccessTokenHydrator;
use App\Hydrators\ScopeHydrator;
use App\Hydrators\UserHydrator;
use App\Hydrators\UserIdentifierHydrator;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Lib\ListView\RepoTrait;
use App\Models\AccessTokenModel;
use App\Models\UserIdentifierModel;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class AccessTokenRepository
 * @package App\Repos
 */
class AccessTokenRepository implements AccessTokenRepositoryInterface
{

    use RepoTrait;

    /**
     * @var AccessTokenModel
     */
    private AccessTokenModel $accessTokenModel;

    /**
     * @var AccessTokenHydrator
     */
    private AccessTokenHydrator $accessTokenHydrator;

    /**
     * @var UserIdentifierModel
     */
    private UserIdentifierModel $userIdentifierModel;

    /**
     * @var UserIdentifierHydrator
     */
    private UserIdentifierHydrator $userIdentifierHydrator;

    /**
     * @var ScopeHydrator
     */
    private ScopeHydrator $scopeHydrator;

    /**
     * AccessTokenRepository constructor.
     * @param AccessTokenModel $accessTokenModel
     * @param AccessTokenHydrator $accessTokenHydrator
     * @param UserIdentifierModel $userIdentifierModel
     * @param UserIdentifierHydrator $userIdentifierHydrator
     * @param ScopeHydrator $scopeHydrator
     */
    public function __construct(
        AccessTokenModel $accessTokenModel,
        AccessTokenHydrator $accessTokenHydrator,
        UserIdentifierModel $userIdentifierModel,
        UserIdentifierHydrator $userIdentifierHydrator,
        ScopeHydrator $scopeHydrator
    )
    {
        $this->accessTokenModel = $accessTokenModel;
        $this->accessTokenHydrator = $accessTokenHydrator;
        $this->userIdentifierModel = $userIdentifierModel;
        $this->userIdentifierHydrator = $userIdentifierHydrator;
        $this->scopeHydrator = $scopeHydrator;
    }

    /**
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     * @throws CorruptedDataException
     */
    public function listAccessTokens(ListCriteria $listCriteria): PaginatedEntityList
    {
        $paginatedAccessTokens = $this->makePaginatedList($listCriteria, $this->accessTokenModel);

        $entities = [];

        foreach ($paginatedAccessTokens->getItems() as $item) {
            $entities[] = $this->accessTokenHydrator->fromArray($item)->toEntity();
        }
        $paginatedAccessTokens->setItems($entities);

        $accessTokenHydrator = $this->accessTokenHydrator;

        $paginatedAccessTokens->setItemsToArrayFunction(function(array $items) use ($accessTokenHydrator) {
            $res = [];
            foreach ($items as $item) {
                $res[] = $accessTokenHydrator->fromEntity($item)->toArray();
            }
            return $res;
        });

        return $paginatedAccessTokens;
    }

    public function listUserAccessTokens()
    {

    }


    /**
     * @param ClientEntityInterface $clientEntity
     * @param array $scopes
     * @param null $userIdentifier
     * @param string|null $username
     * @return AccessTokenEntity|AccessTokenEntityInterface
     * @throws CorruptedDataException
     * @throws InvalidUserCredentialsException
     */
    public function getNewToken(
        ClientEntityInterface $clientEntity,
        array $scopes,
        $userIdentifier = null,
        string $username = null
    )
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);

        if($userIdentifier) {

            try {
                /** @var UserIdentifierModel $userIdentifierModel */
                $userIdentifierModel = $this->userIdentifierModel->newQuery()
                    ->with('user')
                    ->where('value', $username)
                    ->where('is_verified', true)
                    ->firstOrFail();
            }
            catch (ModelNotFoundException $e) {
                throw new InvalidUserCredentialsException;
            }


            $userIdentifierEntity = $this->userIdentifierHydrator->fromModel($userIdentifierModel)->toEntity();

            $accessToken->setUserIdentifierId($userIdentifierEntity->getId());
            $accessToken->setUserIdentifierEntity($userIdentifierEntity);

            $accessToken->setUserId($userIdentifier);
            $accessToken->setUserEntity($userIdentifierEntity->getUserEntity());
        }

        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        return $accessToken;
    }

    /**
     * @param AccessTokenEntityInterface $accessTokenEntity
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        /** @var AccessTokenEntity $accessTokenEntity */
        $exp_at = $accessTokenEntity->getExpiryDateTime();

        $this->accessTokenModel->fill([
            'id' => $accessTokenEntity->getIdentifier(),
            'expires_at' => $exp_at,
            'user_identifier_id' => $accessTokenEntity->getUserIdentifierId(),
            'user_id' => $accessTokenEntity->getUserId(),
            'client_id' => $accessTokenEntity->getClient()->getId(),
            'type' => 'Bearer',
            'device_type' => $accessTokenEntity->getDeviceType(),
            'device_os' => $accessTokenEntity->getDeviceOs(),
            'scopes' => json_encode($this->scopeHydrator->fromArrayOfEntities($accessTokenEntity->getScopes())->toArrayOfArrays()),
            'ip' => $accessTokenEntity->getIp(),
            'is_revoked' => false
        ])->save();
    }

    /**
     * @param string $access_token_id
     * @return AccessTokenEntity|null
     * @throws CorruptedDataException
     */
    public function findByAccessTokenId(string $access_token_id): ?AccessTokenEntity
    {
        /** @var AccessTokenModel $accessTokenModel */
        $accessTokenModel = $this->accessTokenModel->newQuery()->with('userIdentifier.user')->findOrFail($access_token_id);

        return $this->accessTokenHydrator->fromModel($accessTokenModel)->toEntity();
    }

    /**
     * @param string $tokenId
     * @return bool
     */
    public function isAccessTokenRevoked($tokenId): bool
    {
        return $this->accessTokenModel->newQuery()
            ->where('id', '=', $tokenId)
            ->where('is_revoked', '=', true)->exists();
    }

    /**
     * @param string $tokenId
     * @throws TokenNotFoundException
     */
    public function revokeAccessToken($tokenId)
    {
        $token = $this->accessTokenModel->newQuery()->where('id', '=', $tokenId)->first();
        if (is_null($token)) {
            throw new TokenNotFoundException;
        }
        $token->forceFill(['is_revoked' => true])->save();
    }

    /**
     * @param string $accessTokenId
     * @return UserEntity
     * @throws CorruptedDataException
     */
    public function getUserEntityByActiveToken(string $accessTokenId)
    {
        /** @var AccessTokenModel $token */
        $token = $this->accessTokenModel->newQuery()
            ->where('id', '=', $accessTokenId)
            ->with('user.userIdentifiers', 'user.roles.scopes')
            ->firstOrFail();

        /** @var UserHydrator $userHydrator */
        $userHydrator = resolve(UserHydrator::class);

        if($token->user) {
            return $userHydrator->fromModel($token->user)->toEntity();
        }
        // if we return null it means that the token is related to a client
        return null;
    }

}

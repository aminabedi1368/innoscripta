<?php
namespace App\Repos;

use App\Entities\UserEntity;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\UserIdentifierHydrator;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Lib\ListView\RepoTrait;
use App\Models\UserIdentifierModel;

/**
 * Class UserIdentifierRepository
 * @package App\Repos
 */
class UserIdentifierRepository
{
    use RepoTrait;

    /**
     * @var UserIdentifierModel
     */
    private UserIdentifierModel $userIdentifierModel;

    /**
     * @var UserIdentifierHydrator
     */
    private UserIdentifierHydrator $userIdentifierHydrator;

    /**
     * UserIdentifierRepository constructor.
     * @param UserIdentifierModel $userIdentifierModel
     * @param UserIdentifierHydrator $userIdentifierHydrator
     */
    public function __construct(
        UserIdentifierModel $userIdentifierModel,
        UserIdentifierHydrator $userIdentifierHydrator
    )
    {
        $this->userIdentifierModel = $userIdentifierModel;
        $this->userIdentifierHydrator = $userIdentifierHydrator;
    }

    /**
     * @param int|UserEntity $user
     * @return UserIdentifierEntity[]
     * @throws CorruptedDataException
     */
    public function listUserIdentifiers(int|UserEntity $user): array
    {
        $user_id = $user;
        if($user instanceof UserEntity) {
            $user_id = $user->getId();
        }
        /** @var UserIdentifierModel[] $identifiers */
        $identifiers = $this->userIdentifierModel->newQuery()->where('user_id', $user_id)->get()->toArray();

        return $this->userIdentifierHydrator->fromArrayOfArrays($identifiers)->toArrayOfEntities();
    }


        /**
     * @param  ListCriteria $listCriteria
     * @return UserIdentifierEntity[]
     * @throws CorruptedDataException
     */
    public function listAllUserIdentifiers(ListCriteria $listCriteria): PaginatedEntityList
    {
        $paginatedUserIdentifiers = $this->makePaginatedList($listCriteria, $this->userIdentifierModel);

        $entities = [];

        foreach ($paginatedUserIdentifiers->getItems() as $item) {
            $entities[] = $this->userIdentifierHydrator->fromArray($item)->toEntity();
        }
        $paginatedUserIdentifiers->setItems($entities);

        $userIdentifierHydrator = $this->userIdentifierHydrator;

        $paginatedUserIdentifiers->setItemsToArrayFunction(function(array $items) use ($userIdentifierHydrator) {
            $res = [];
            foreach ($items as $item) {
                $res[] = $userIdentifierHydrator->fromEntity($item)->toArray();
            }
            return $res;
        });

        return $paginatedUserIdentifiers;
    }


    /**
     * @param integer $userId
     * @return void
     */
    public function deleteAllIdentifiersOfUser(int $userId)
    {
        $this->userIdentifierModel->newQuery()->where('user_id', $userId)->delete();
    }


    /**
     * @param UserIdentifierEntity $userIdentifierEntity
     * @return UserIdentifierEntity
     */
    public function insertUserIdentifier(UserIdentifierEntity $userIdentifierEntity): UserIdentifierEntity
    {
        /** @var UserIdentifierModel $userIdentifierModel */
        $userIdentifierModel = $this->userIdentifierModel->newQuery()->create(
            $this->userIdentifierHydrator->fromEntity($userIdentifierEntity)->toArray()
        );

        return $userIdentifierEntity->setId($userIdentifierModel->id)
            ->setCreatedAt($userIdentifierModel->created_at)
            ->setUpdatedAt($userIdentifierModel->updated_at);
    }

    /**
     * @param string $username
     * @return UserIdentifierEntity
     * @throws CorruptedDataException
     */
    public function verifyIdentifier(string $username): UserIdentifierEntity
    {
        /** @var UserIdentifierModel $model */
        $model = $this->userIdentifierModel->newQuery()->where('value', $username)->firstOrFail();

        $model->update(['is_verified' => true]);

        return $this->userIdentifierHydrator->fromModel($model)->toEntity();
    }

    /**
     * @param string $usernameType
     * @param string $username
     * @param bool $throw_exception
     * @return UserIdentifierEntity|null
     * @throws CorruptedDataException
     */
    public function findByTypeAndValue(string $usernameType, string $username, bool $throw_exception = true): ?UserIdentifierEntity
    {
        /** @var UserIdentifierModel $userIdentifierModel */
        $query = $this->userIdentifierModel->newQuery()
            ->where('type', $usernameType)
            ->where('value', $username);

        if($throw_exception) {
            $userIdentifierModel = $query->firstOrFail();
        }
        else {
            $userIdentifierModel = $query->first();
        }

        if(!is_null($userIdentifierModel)) {
            return $this->userIdentifierHydrator->fromModel($userIdentifierModel)->toEntity();
        }
        else {
            return null;
        }
    }



        /**
     * @param string $usernameType
     * @param string $username
     * @param bool $throw_exception
     * @return UserIdentifierEntity|null
     * @throws CorruptedDataException
     */
    public function findByTypeAndValueAndCode(
        string $usernameType,
        string $username,
        string $code,
        bool $throw_exception = true
    ): ?UserIdentifierEntity
    {
        /** @var UserIdentifierModel $userIdentifierModel */
        $query = $this->userIdentifierModel->newQuery()
            ->where('type', $usernameType)
            ->where('value', $username)
            ->whereHas('otp', function($query) use($code) {
                $query->where('code', $code);
            });

        if($throw_exception) {
            $userIdentifierModel = $query->firstOrFail();
        }
        else {
            $userIdentifierModel = $query->first();
        }

        if(!is_null($userIdentifierModel)) {
            return $this->userIdentifierHydrator->fromModel($userIdentifierModel)->toEntity();
        }
        else {
            return null;
        }
    }

    /**
     * @param string $username
     * @return UserIdentifierEntity|null
     * @throws CorruptedDataException
     */
    public function findByValue(string $username): ?UserIdentifierEntity
    {
        /** @var UserIdentifierModel $userIdentifier */
        $userIdentifier = $this->userIdentifierModel->newQuery()->where('value', $username)->firstOrFail();

        return $this->userIdentifierHydrator->fromModel($userIdentifier)->toEntity();
    }

    /**
     * @param integer $id
     * @return UserIdentifierEntity
     */
    public function findById(int $id)
    {
        /** @var UserIdentifierModel $userIdentifier */
        $userIdentifier = $this->userIdentifierModel->newQuery()->where('id', $id)->firstOrFail();

        return $this->userIdentifierHydrator->fromModel($userIdentifier)->toEntity();
    }

    /**
     * @param integer $identifierId
     * @return void
     */
    public function deleteIdentifierById(int $identifierId)
    {
        $this->userIdentifierModel->newQuery()->where('id', $identifierId)->delete();
    }

}

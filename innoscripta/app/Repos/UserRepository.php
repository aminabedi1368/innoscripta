<?php
namespace App\Repos;

use App\Entities\UserEntity;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\UserHydrator;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Lib\ListView\RepoTrait;
use App\Models\OtpModel;
use App\Models\UserIdentifierModel;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package App\Repos
 */
class UserRepository implements UserRepositoryInterface
{

    use RepoTrait;

    /**
     * @var UserModel
     */
    private UserModel $userModel;

    /**
     * @var UserHydrator
     */
    private UserHydrator $userHydrator;

    /**
     * @var UserIdentifierModel
     */
    private UserIdentifierModel $userIdentifierModel;

    /**
     * @var OtpModel
     */
    private OtpModel $otpModel;

    /**
     * UserRepository constructor.
     * @param UserModel $userModel
     * @param UserIdentifierModel $userIdentifierModel
     * @param UserHydrator $userHydrator
     * @param OtpModel $otpModel
     */
    public function __construct(
        UserModel $userModel,
        UserIdentifierModel $userIdentifierModel,
        UserHydrator $userHydrator,
        OtpModel $otpModel
    )
    {
        $this->userModel = $userModel;
        $this->userHydrator = $userHydrator;
        $this->userIdentifierModel = $userIdentifierModel;
        $this->otpModel = $otpModel;
    }

    /**
     * @param int $user
     * @param array $with
     * @param bool $throw_exception
     * @return UserEntity|null
     * @throws CorruptedDataException
     */
    public function findOneById(int $user, array $with = [], bool $throw_exception = true): ?UserEntity
    {
        $query = $this->userModel->newQuery()->where('id', $user);

        if(!empty($with)) {
            $query->with($with);
        }

        /** @var UserModel $userModel */
        $userModel = $throw_exception ? $query->firstOrFail() : $query->first();

        return $this->userHydrator->fromModel($userModel)->toEntity();
    }


    /**
     * @param integer $user_id
     * @return void
     */
    public function deleteUserAvatr(int $user_id)
    {
        $user = $this->userModel->newQuery()->where('id', $user_id)->firstOrFail();
        $user->avatar = null;
        $user->save();
    }

    /**
     * @param ListCriteria $listCriteria
     * @param string|null $search
     * @return PaginatedEntityList
     * @throws CorruptedDataException
     */
    public function listUsers(ListCriteria $listCriteria, ?string $search): PaginatedEntityList
    {
        $paginatedUsers = ($search === null) ?
            $this->makePaginatedList($listCriteria, $this->userModel) :
            $this->makePaginatedListWithSearch($listCriteria, $this->userModel, $search);

        $entities = [];

        foreach ($paginatedUsers->getItems() as $item) {
            $entities[] = $this->userHydrator->fromArray($item)->toEntity();
        }
        $paginatedUsers->setItems($entities);

        $userHydrator = $this->userHydrator;

        $paginatedUsers->setItemsToArrayFunction(function(array $items) use ($userHydrator) {
            $res = [];
            foreach ($items as $item) {
                $res[] = $userHydrator->fromEntity($item)->toArray();
            }
            return $res;
        });

        return $paginatedUsers;
    }
    /**
     * @param UserEntity|int $user
     * @return int
     */
    public function deleteUser($user): int
    {
        $user_id = $user;

        if($user instanceof UserEntity) {
            $user_id = $user->getId();
        }

        return $this->userModel->newQuery()->where('id', $user_id)->delete();
    }


    /**
     * @param ListCriteria $list_criteria
     * @param Model $model
     * @param string $search
     * @return PaginatedEntityList
     */
    public function makePaginatedListWithSearch(
        ListCriteria $list_criteria,
        Model $model,
        string $search
    ): PaginatedEntityList
    {
        $query = $model->newQuery();

        $query = $this->buildFiltersQuery($query, $list_criteria, $model);
        $query = $this->buildSortQuery($query, $list_criteria, $model);
        $query = $this->buildFieldsQuery($query, $list_criteria->getFields(), $model);

        $query->with(['userIdentifiers', 'roles']);

        $query->where(function($query) use ($search) {
            $query->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhereHas('userIdentifiers', function($subQuery) use ($search) {
                    $subQuery->where('value', 'like', "%$search%");
                });
        });


        return (new PaginatedEntityList())
            ->setTotal($query->count())
            ->setLimit($list_criteria->getLimit())
            ->setOffset($list_criteria->getOffset())
            ->setItems(
                $query->offset($list_criteria->getOffset())
                    ->take($list_criteria->getLimit())
                    ->get()
                    ->toArray()
            );
    }

    /**
     * @param int $user_id
     * @param string $first_name
     * @param string $last_name
     * @return UserEntity
     * @throws CorruptedDataException
     */
    public function updateUser(int $user_id, string $first_name, string $last_name): UserEntity
    {
        /** @var UserModel $userModel */
        $userModel = $this->userModel->newQuery()->where('id', $user_id)->firstOrFail();

        $userModel->update([
            'first_name' => $first_name,
            'last_name' => $last_name
        ]);

        return $this->userHydrator->fromModel($userModel)->toEntity();
    }

    /**
     * @param int $user_id
     * @param string $avatar_path
     * @return UserEntity
     * @throws CorruptedDataException
     */
    public function updateUserAvatar(int $user_id, string $avatar_path): UserEntity
    {
        /** @var UserModel $userModel */
        $userModel = $this->userModel->newQuery()->where('id', $user_id)->firstOrFail();

        $userModel->update([
            'avatar' => $avatar_path,
        ]);

        return $this->userHydrator->fromModel($userModel)->toEntity();
    }

    /**
     * @param string $username
     * @param string $otp
     * @param ClientEntityInterface $client
     * @return UserEntity|null
     * @throws CorruptedDataException
     * @throws InvalidUserCredentialsException
     */
    public function getUserEntityByUserCredentialsOTP(
        string $username,
        string $otp,
        ClientEntityInterface $client
    ): ?UserEntity
    {
        /** @var UserIdentifierModel $userIdentifierModel */
        $userIdentifierModel = $this->userIdentifierModel
            ->newQuery()
            ->where('value', $username)
            ->with('user.userIdentifiers')
            ->first();

        if(is_null($userIdentifierModel)) {
            throw new InvalidUserCredentialsException;
        }

        $otpModel = $this->otpModel->newQuery()
            ->where('code', $otp)
            ->whereDate('expires_at', '>=', Carbon::now())
            ->first();

        if(is_null($otpModel)) {
            throw new InvalidUserCredentialsException;
        }

        return $this->userHydrator->fromModel($userIdentifierModel->user)->toEntity();
    }


    /**
     * @param string $username
     * @param string $password
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @return UserEntityInterface
     * @throws InvalidUserCredentialsException
     * @throws CorruptedDataException
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ): UserEntityInterface
    {
        /** @var UserIdentifierModel $userIdentifierModel */
        $userIdentifierModel = $this->userIdentifierModel
            ->newQuery()
            ->where('value', $username)
            ->with('user.userIdentifiers')
            ->where('is_verified', true)
            ->first();

        if(is_null($userIdentifierModel)) {
            throw new InvalidUserCredentialsException;
        }

        if (!password_verify($password, $userIdentifierModel->user->password)) {
            throw new InvalidUserCredentialsException;
        }

        return $this->userHydrator->fromModel($userIdentifierModel->user)->toEntity();
    }

    /**
     * @param string $username
     * @return UserEntity|null
     * @throws CorruptedDataException
     * @throws InvalidUserCredentialsException
     */
    public function getUserEntityByUsername(string $username): ?UserEntity
    {
        /** @var UserIdentifierModel $userIdentifierModel */
        $userIdentifierModel = $this->userIdentifierModel
            ->newQuery()
            ->where('value', $username)
            ->with('user.userIdentifiers')
            ->first();


        if(is_null($userIdentifierModel->user)) {
            throw new CorruptedDataException;
        }

        if(is_null($userIdentifierModel)) {
            throw new InvalidUserCredentialsException;
        }

        return $this->userHydrator->fromModel($userIdentifierModel->user)->toEntity();
    }

    /**
     * @param UserEntity $userEntity
     * @return UserEntity
     */
    public function insert(UserEntity $userEntity): UserEntity
    {
        $userArray = $this->userHydrator->fromEntity($userEntity)->toArray();

        /** @var UserModel $userModel */
        $userModel = $this->userModel->newQuery()->create($userArray);

        return $userEntity->setId($userModel->id);
    }

    /**
     * @param int $userIdentifier
     * @param string $newHashedPassword
     */
    public function updatePassword(int $userIdentifier, string $newHashedPassword)
    {
        $this->userModel->newQuery()->where('id', $userIdentifier)->update([
            'password' => $newHashedPassword
        ]);
    }

}

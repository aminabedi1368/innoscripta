<?php

namespace App\Http\Controllers\Api\User;

use App\Actions\Messaging\SendVerificationEmailAction;
use App\Actions\Messaging\SendVerificationSmsAction;
use App\Actions\User\RegisterUserAction;
use App\Actions\UserIdentifier\AddUserIdentifierAction;
use App\Constants\UserIdentifierType;
use App\Constants\UserStatus;
use App\Entities\UserEntity;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\CorruptedDataException;
use App\Exceptions\InvalidMobileFormatException;
use App\Exceptions\SettingKeyNotFoundAnyWhereException;
use App\Hydrators\UserHydrator;
use App\Hydrators\UserIdentifierHydrator;
use App\Lib\TokenInfoVO;
use App\Models\UserIdentifierModel;
use App\Models\UserModel;
use App\Validators\UserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;


/**
 * Class CreateUserApi
 * @package App\Http\Controllers\Api\User
 */
class CreateUserApi
{
    /**
     * @var RegisterUserAction
     */
    private RegisterUserAction $registerUserAction;

    /**
     * @var UserValidator
     */
    private UserValidator $userValidator;

    /**
     * @var UserHydrator
     */
    private UserHydrator $userHydrator;


    private UserIdentifierHydrator $userIdentifierHydrator;


    /**
     * @var UserIdentifierModel
     */
    private UserIdentifierModel $userIdentifierModel;

    /**
     * @var UserEntity
     */
    private UserModel $userModel;

    /**
     * @var AddUserIdentifierAction
     */
    private AddUserIdentifierAction $addUserIdentifierAction;

    /**
     * @var SendVerificationSmsAction
     */
    private SendVerificationSmsAction $sendVerificationSms;

    /**
     * @var SendVerificationEmailAction
     */
    private SendVerificationEmailAction $sendVerificationEmailAction;

    /**
     * CreateUserApi constructor.
     * @param RegisterUserAction $registerUserAction
     * @param AddUserIdentifierAction $addUserIdentifierAction
     * @param UserValidator $userValidator
     * @param UserHydrator $userHydrator
     * @param SendVerificationSmsAction $sendVerificationSms
     * @param SendVerificationEmailAction $sendVerificationEmailAction
     */
    public function __construct(
        RegisterUserAction          $registerUserAction,
        AddUserIdentifierAction     $addUserIdentifierAction,
        UserValidator               $userValidator,
        UserHydrator                $userHydrator,
        UserIdentifierHydrator      $userIdentifierHydrator,
        UserIdentifierModel         $userIdentifierModel,
        UserModel                   $userModel,
        SendVerificationSmsAction   $sendVerificationSms,
        SendVerificationEmailAction $sendVerificationEmailAction
    )
    {
        $this->registerUserAction = $registerUserAction;
        $this->userValidator = $userValidator;
        $this->userHydrator = $userHydrator;
        $this->userIdentifierHydrator = $userIdentifierHydrator;
        $this->userIdentifierModel = $userIdentifierModel;
        $this->UserModel = $userModel;
        $this->addUserIdentifierAction = $addUserIdentifierAction;
        $this->sendVerificationSms = $sendVerificationSms;
        $this->sendVerificationEmailAction = $sendVerificationEmailAction;
    }

    /**
     * @return JsonResponse
     * @throws CorruptedDataException
     * @throws ValidationException
     * @throws InvalidMobileFormatException
     * @throws SettingKeyNotFoundAnyWhereException
     */
    public function __invoke(): JsonResponse
    {
        $data = request()->all();
        $this->userValidator->validateRegister($data);

        $identifierTypes = [
            UserIdentifierType::EMAIL,
            UserIdentifierType::MOBILE,
            UserIdentifierType::NATIONAL_CODE
        ];

        $persistedUserEntity = $this->registerUser($data);

        if (array_key_exists('tokenInfo', $data) && is_null($data['tokenInfo']->getOauthUserId())) {
            $persistedUserEntity = $this->addUserIdentifiers(
                $persistedUserEntity,
                get_array_fields($data['usernames'], $identifierTypes),
                true
            );
        } // user token or no token at all
        else {
            if (array_key_exists('mobile', $data['usernames'])) {
                $exists = UserIdentifierModel::query()
                    ->where('value', $data['usernames']['mobile'])
                    ->exists();
            }
            if (array_key_exists('email', $data['usernames'])) {
                $exists = UserIdentifierModel::query()
                    ->where('value', $data['usernames']['email'])
                    ->exists();
            }

            if ($exists) {
                $persistedUserEntity = $this->UpdateUserIdentifiers(
                    $persistedUserEntity,
                    get_array_fields($data['usernames'], $identifierTypes),
                );
                $this->sendExistVerificationCodes($persistedUserEntity);
                return response()->json($persistedUserEntity->toArray());

            } else {
                $persistedUserEntity = $this->addUserIdentifiers(
                    $persistedUserEntity,
                    get_array_fields($data['usernames'], $identifierTypes),
                );
                $this->sendVerificationCodes($persistedUserEntity);
                return response()->json($this->userHydrator->fromEntity($persistedUserEntity)->toArray());

            }

        }

    }

    /**
     * @param UserEntity $userEntity
     * @throws InvalidMobileFormatException
     * @throws SettingKeyNotFoundAnyWhereException
     */
    private function sendVerificationCodes(UserEntity $userEntity)
    {
        ## 1) Email
        if ($userEntity->hasEmailIdentifier()) {
            $emailIdentifier = $userEntity->getEmailUserIdentifier();
            $emailIdentifier->setUserEntity($userEntity);
            $this->sendVerificationEmailAction->__invoke($emailIdentifier);
            $emailIdentifier->setUserEntity(null);
        }
        ## 2) SMS
        if ($userEntity->hasMobileIdentifier()) {
            $mobileIdentifier = $userEntity->getMobileUserIdentifier();
            $mobileIdentifier->setUserEntity($userEntity);
            $this->sendVerificationSms->__invoke($mobileIdentifier);
            $mobileIdentifier->setUserEntity(null);
        }

    }

    private function sendExistVerificationCodes(UserEntity $userEntity)
    {

        $type=$userEntity->getUserIdentifiers();
        if($type['type'] === 'email'){

            $userIdentifierEntity = new UserIdentifierEntity();
            $userIdentifierEntity
                ->setId($type['id'])
                ->setUserId($type['user_id'])
                ->setType($type['type'])
                ->setValue($type['value'])
                ->setIsVerified((bool) $type['is_verified'])
                ->setCreatedAt(Carbon::parse($type['created_at']))
                ->setUpdatedAt(Carbon::parse($type['updated_at']));

            $this->sendVerificationEmailAction->__invoke($userIdentifierEntity);
        }

        if($type['type'] === 'mobile'){
            $userIdentifierEntity = new UserIdentifierEntity();
            $userIdentifierEntity
                ->setId($type['id'])
                ->setUserId($type['user_id'])
                ->setType($type['type'])
                ->setValue($type['value'])
                ->setIsVerified((bool) $type['is_verified'])
                ->setCreatedAt(Carbon::parse($type['created_at']))
                ->setUpdatedAt(Carbon::parse($type['updated_at']));
            $this->sendVerificationSms->__invoke($userIdentifierEntity);
        }

    }

    /**
     * @param array $data
     * @return UserEntity
     * @throws CorruptedDataException
     */
    private function registerUser(array $data): UserEntity
    {
        $data['status'] = UserStatus::ACTIVE;

        if (!empty($data['usernames']['username'])) {
            $data['username'] = $data['usernames']['username'];
        }

        $data['year_month'] = get_year_jalali() . '-' . get_month_jalali();
        $data['year_month_day'] = get_year_jalali() . '-' . get_month_jalali() . '-' . get_month_day_jalali();
        $data['year_week'] = get_year_jalali() . '-' . get_week_jalali();

        $userEntity = $this->userHydrator->fromArray($data)->toEntity();
        return $this->registerUserAction->__invoke($userEntity);
    }

    /**
     * @param UserEntity $userEntity
     * @param array $usernames
     * @param bool $isVerified
     * @return UserEntity
     */
    private function addUserIdentifiers(UserEntity $userEntity, array $usernames, bool $isVerified = false): UserEntity
    {
//        "usernames" => array:3 [
//              "email" => "majid8911303@gmail.com"
//              "mobile" => "09124971706"
//         ]

        foreach ($usernames as $identifierType => $username) {

            if (!empty($username)) {
                $userIdentifierEntity = (new UserIdentifierEntity())
                    ->setUserId($userEntity->getId())
                    ->setType($identifierType)
                    ->setValue($username)
                    ->setIsVerified($isVerified);

                $userIdentifierEntity = $this->addUserIdentifierAction->__invoke($userIdentifierEntity);
                $userEntity->addUserIdentifier($userIdentifierEntity);
            }

        }

        return $userEntity;
    }

    private function UpdateUserIdentifiers(UserEntity $userEntity, array $usernames, bool $isVerified = false): UserEntity
    {

        foreach ($usernames as $identifierType => $username) {

            if (!empty($username)) {

                $model = $this->userIdentifierModel->newQuery()->where('value', $username)->firstOrFail();
                $model->update(['user_id' => $userEntity->getId()]);
            }

        }
        $originalArray = $model ? $model->toArray() : [];
        // Use the setter method to set the 'userIdentifiers' property
        $userEntity->setUserIdentifiers($originalArray);
        return $userEntity;
    }

}

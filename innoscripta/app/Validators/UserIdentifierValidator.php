<?php
namespace App\Validators;

use App\Constants\UserIdentifierType;
use App\Models\UserIdentifierModel;
use Exception;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

/**
 * Class UserIdentifierValidator
 * @package App\Validators
 */
class UserIdentifierValidator
{
    /**
     * @var Factory
     */
    private Factory $validator;

    /**
     * ClientValidator constructor.
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateCreateUserIdentifier(array $data)
    {
        $userIdentifierTypesCommaSeparated = implode(",", UserIdentifierType::ALL_TYPES);
        $this->validator->validate($data, [
            'type' => 'string|required|in:'.$userIdentifierTypesCommaSeparated,
            'value' => [
                'string',
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $exists = UserIdentifierModel::query()
                        ->where('value', $value)
                        ->where('type', $data['type'])
                        ->where('is_verified', 1)
                        ->exists();

                    if($exists) {
                        $fail($attribute.' already exists.');
                    }
                },
            ]
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateCreateUserIdentifierByAdmin(array $data)
    {
        $userIdentifierTypesCommaSeparated = implode(",", UserIdentifierType::ALL_TYPES);
        $this->validator->validate($data, [
            'user_id' => 'integer|required|exists:user_identifiers,id',
            'type' => 'string|required|in:'.$userIdentifierTypesCommaSeparated,
            'value' => [
                'string',
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $exists = UserIdentifierModel::query()
                        ->where('value', $value)
                        ->where('type', $data['type'])
                        ->where('is_verified', 1)
                        ->exists();

                    if($exists) {
                        $fail($attribute.' already exists.');
                    }
                },
            ]
        ]);
    }


    /**
     * @param array $data
     * @throws ValidationException
     * @throws Exception
     */
    public function validateUpdateUserIdentifier(array $data)
    {
        /** @var UserIdentifierModel $userIdentifier */
        $userIdentifier = UserIdentifierModel::query()->findOrFail($data['id']);

        if($userIdentifier->type === UserIdentifierType::EMAIL) {
            $rule = ["email"];
        }
        elseif($userIdentifier->type === UserIdentifierType::MOBILE) {
//            $rule = ["starts_with:+","size:11"];
            $rule = ["starts_with:+"];
        }
        elseif ($userIdentifier->type === UserIdentifierType::NATIONAL_CODE) {
            $rule = ["min:10", "min:15"];
        }
        else {
            throw new Exception("Invalid user identifier");
        }

        $this->validator->validate($data, [
            'id' => 'required|integer|exists:user_identifiers',
            'value' => array_merge([
                function ($attribute, $value, $fail) use ($data) {
                    $exists = UserIdentifierModel::query()
                        ->where('value', $value)
                        ->where('id', '<>' , $data['id'])
                        ->where('is_verified', 1)
                        ->exists();

                    if($exists) {
                        $fail($attribute.' already exists.');
                    }
                },
            ], $rule),
            'is_verified' => 'required|boolean'
        ]);
    }


    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateVerifyUserIdentifier(array $data)
    {
        $userIdentifierTypesCommaSeparated = implode(",", UserIdentifierType::ALL_TYPES);

        $this->validator->validate($data, [
            'type' => 'required|string|in:'.$userIdentifierTypesCommaSeparated,
            'value' => 'required|string',
            'code' => 'required|string|min:5'
        ]);
    }

}

<?php
namespace App\Validators;

use App\Models\UserIdentifierModel;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

/**
 * Class UserValidator
 * @package App\Validators
 */
class UserValidator
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
    public function validateRegister(array $data)
    {
        $rules = [
            'usernames.email' => [
                'sometimes',
                'required_without_all:usernames.mobile',
                'nullable',
                'email',
                function ($attribute, $value, $fail) {
                    $exists = UserIdentifierModel::query()
                        ->where('value', $value)
                        ->where('type', 'email')
                        ->where('is_verified', 1)
                        ->exists();

                    if($exists) {
                        $fail($attribute.' already exists. please go to forget password page.');
                    }

//                    $exists = UserIdentifierModel::query()
//                        ->where('value', $value)
//                        ->where('type', 'email')
//                        ->where('is_verified', 0)
//                        ->exists();
//                    if($exists) {
//                        $fail($attribute.'.verifyIdentifier');
//                    }
                },
            ],
            'usernames.mobile' => [
                'sometimes',
                'nullable',
                'required_without_all:usernames.email',
                'string',
                'starts_with:+',
                function ($attribute, $value, $fail) {
                    $exists = UserIdentifierModel::query()
                        ->where('value', $value)
                        ->where('type', 'mobile')
                        ->where('is_verified', 1)
                        ->exists();

                    if($exists) {
                        $fail($attribute.' already exists. please go to forget password page');
                    }
//                    $exists = UserIdentifierModel::query()
//                        ->where('value', $value)
//                        ->where('type', 'mobile')
//                        ->where('is_verified', 0)
//                        ->exists();
//
//                    if($exists) {
//                        $fail($attribute.'.verifyIdentifier');
//                    }
                },
            ],
            'first_name' => 'sometimes|string|min:3|max:100',
            'last_name' => 'sometimes|string|min:3|max:200',
            'password' => [
                'required',
                'string',
                'min:6',
//                'min:8',             // must be at least 10 characters in length
//                'regex:/[a-z]/',      // must contain at least one lowercase letter
//                'regex:/[A-Z]/',      // must contain at least one uppercase letter
//                'regex:/[0-9]/',      // must contain at least one digit
//                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'app_fields' => 'sometimes|array'
        ];

        $this->validator->validate($data, $rules);
    }


    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateUpdateUserProfileByHimSelf(array $data)
    {
        $this->validator->validate($data, [
            'first_name' => 'sometimes|string|min:3|max:100',
            'last_name' => 'sometimes|string|min:3|max:100'
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function changePasswordValidator(array $data)
    {
        $this->validator->validate($data, [
            'old_password' => 'string|required',
            'new_password' => [
                'required',
                'string',
                'min:6',
//                'min:8',             // must be at least 10 characters in length
//                'regex:/[a-z]/',      // must contain at least one lowercase letter
//                'regex:/[A-Z]/',      // must contain at least one uppercase letter
//                'regex:/[0-9]/',      // must contain at least one digit
//                'regex:/[@$!%*#?&]/', // must contain a special character
            ]
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function forgetPasswordValidator(array $data)
    {
        $this->validator->validate($data, [
            'code' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:6',
//                'min:8',             // must be at least 10 characters in length
//                'regex:/[a-z]/',      // must contain at least one lowercase letter
//                'regex:/[A-Z]/',      // must contain at least one uppercase letter
//                'regex:/[0-9]/',      // must contain at least one digit
//                'regex:/[@$!%*#?&]/', // must contain a special character
            ]
        ]);
    }


}

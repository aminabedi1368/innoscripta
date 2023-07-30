<?php
namespace App\Validators;

use App\Models\ScopeModel;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

/**
 * Class ScopeValidator
 * @package App\Validators
 */
class ScopeValidator
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
    public function validateAddScopeToRole(array $data)
    {
        $this->validator->validate($data, [
            'scope_id' => 'required|integer|exists:scopes,id',
            'role_id' => 'required|integer|exists:roles,id'
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validatePutScope(array $data)
    {
        $this->validator->validate($data, [
            'id' => 'required|integer|exists:scopes,id',
            'name' => 'required|string|unique:scopes,name,'.$data['name'].'|min:3|max:100',
            'description' => 'sometimes|string|min:3|max:1000',
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validatePatchScope(array $data)
    {
        $this->validator->validate($data, [
            'id' => 'required|integer|exists:scopes,id',
            'name' => 'sometimes|string|unique:scopes,name,'.$data['name'].'|min:3|max:100',
            'description' => 'sometimes|string|min:3|max:1000',
        ]);
    }

        /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateCreateScope(array $data)
    {
        $this->validator->validate($data, [
            'name' => [
                'string',
                'required',
                'min:3',
                'max:100',
                function ($attribute, $value, $fail) use ($data) {
                    $exists = ScopeModel::query()
                        ->where('name', $value)
                        ->where('project_id', $data['project_id'])
                        ->exists();

                    if($exists) {
                        $fail($attribute.' already exists.');
                    }
                },
            ],
            'slug' => [
                'string',
                'required',
                'min:3',
                'max:100',
                function ($attribute, $value, $fail) use ($data) {
                    $exists = ScopeModel::query()
                        ->where('slug', $value)
                        ->exists();

                    if($exists) {
                        $fail($attribute.' already exists.');
                    }
                },
            ],
            'project_id' => 'required|integer|exists:projects,id',
            'description' => 'sometimes|string|min:3|max:1000',
        ]);
    }

}

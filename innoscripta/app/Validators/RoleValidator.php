<?php
namespace App\Validators;

use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

/**
 * Class RoleValidator
 * @package App\Validators
 */
class RoleValidator
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
    public function validateCreateRole(array $data)
    {
        $this->validator->validate($data, [
            'name' => 'required|string|unique:roles,name|min:3|max:100',
            'project_id' => 'required|integer|exists:projects,id',
            'slug' => 'required|string|unique:roles,slug|min:3|max:100',
            'description' => 'sometimes|string|min:5|max:1000',
            'roleScopes' => 'sometimes|array',
            'roleScopes.*' => 'integer'
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validatePutRole(array $data)
    {
        $this->validator->validate($data, [
            'id' => 'required|integer|exists:roles,id',
            'name' => 'required|string|unique:roles,name,'.$data['id'].'|min:3|max:100',
            'slug' => 'required|string|unique:roles,slug,'.$data['id'].'|min:3|max:100',
            'project_id' => 'required|integer|exists:projects,id',
            'description' => 'sometimes|string|min:3|max:1000',
            'roleScopes' => 'sometimes|array',
            'roleScopes.*' => 'integer'
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validatePatchRole(array $data)
    {
        $this->validator->validate($data, [
            'id' => 'required|integer|exists:roles,id',
            'name' => 'sometimes|string|unique:roles,name,'.$data['name'].'|min:3|max:100',
            'description' => 'sometimes|string|min:3|max:1000',
        ]);
    }

}

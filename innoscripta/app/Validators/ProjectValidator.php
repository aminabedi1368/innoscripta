<?php
namespace App\Validators;

use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

/**
 * Class ProjectValidator
 * @package App\Validators
 */
class ProjectValidator
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
    public function validateCreateProject(array $data)
    {
        $this->validator->validate($data, [
            'name' => 'string|required',
            'slug' => 'string|required',
            'description' => 'sometimes|string'
        ]);
    }

}

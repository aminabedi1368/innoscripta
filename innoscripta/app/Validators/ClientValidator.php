<?php
namespace App\Validators;

use App\Models\ClientModel;
use Illuminate\Validation\Factory;

/**
 * Class ClientValidator
 * @package App\Validators
 */
class ClientValidator
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
     * @return void
     */
    public function validateUpdateClient(array $data)
    {
        $this->validator->validate($data, [
            'name' => [
                'string',
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $exists = ClientModel::query()
                        ->where('name', $value)
                        ->where('id', '<>', $data['id'])
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
                function ($attribute, $value, $fail) use ($data) {
                    $exists = ClientModel::query()
                        ->where('slug', $value)
                        ->where('id', '<>', $data['id'])
                        ->where('project_id', $data['project_id'])
                        ->exists();

                    if($exists) {
                        $fail($attribute.' already exists.');
                    }
                },
            ],
            'type' => 'sometimes|string',
            'project_id' => 'required|integer|exists:projects,id',
            'oauth_client_type' => 'required|string',
            'redirect_urls' => 'sometimes|array',
            'redirect_urls.*' => 'string'
        ]);
    }

    /**
     * @param array $data
     * @return void
     */
    public function validateCreateClient(array $data)
    {
        $this->validator->validate($data, [
            'name' => [
                'string',
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $exists = ClientModel::query()
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
                function ($attribute, $value, $fail) use ($data) {
                    $exists = ClientModel::query()
                        ->where('slug', $value)
                        ->where('project_id', $data['project_id'])
                        ->exists();

                    if($exists) {
                        $fail($attribute.' already exists.');
                    }
                },
            ],
            'type' => 'sometimes|string',
            'project_id' => 'required|integer|exists:projects,id',
            'oauth_client_type' => 'required|string',
            'redirect_urls' => 'sometimes|array',
            'redirect_urls.*' => 'string'
        ]);
    }

}

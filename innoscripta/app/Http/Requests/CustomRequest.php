<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class CustomRequest extends Request
{
    protected $psrRequest;

    public function __construct(ServerRequestInterface $psrRequest)
    {
        $this->psrRequest = $psrRequest;
        parent::__construct();
    }

    public function getUser() : null|string
    {
        return $this->psrRequest->getParsedBody()['user'] ?? null;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}

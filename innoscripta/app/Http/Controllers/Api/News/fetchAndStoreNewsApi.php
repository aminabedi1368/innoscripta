<?php

namespace App\Http\Controllers\Api\News;

use Illuminate\Http\Request;
use App\Actions\News\FetchAndStoreNewsAction;
use App\Validators\UserValidator;

class fetchAndStoreNewsApi
{
    private FetchAndStoreNewsAction $fetchAndStoreNewsAction;
    private UserValidator $userValidator;

    public function __construct(
        FetchAndStoreNewsAction $fetchAndStoreNewsAction,
        UserValidator $userValidator,
    )
    {
        $this->FetchAndStoreNewsAction = $fetchAndStoreNewsAction;
        $this->userValidator = $userValidator;
    }
    public function __invoke(Request $request)
    {
        $category = $request->query('category', 'general'); // Default to 'general' if 'category' is not provided in the query params
        $pageSize = $request->query('pageSize', 100); // Default to 100 if 'pageSize' is not provided in the query params

        $userEntity = $request->attributes->get('userEntity');
        $result= $this->FetchAndStoreNewsAction->__invoke($userEntity, $category, $pageSize);

        return response()->json($result);

    }
}

<?php
namespace App\Http\Controllers\Web\Admin;

use App\Models\UserIdentifierModel;
use App\Validators\UserIdentifierValidator;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class UserIdentifierController
 * @package App\Http\Controllers\Web\Admin
 */
class UserIdentifierController
{

    /**
     * @var UserIdentifierValidator
     */
    private UserIdentifierValidator $userIdentifierValidator;

    /**
     * UserIdentifierController constructor.
     * @param UserIdentifierValidator $userIdentifierValidator
     */
    public function __construct(UserIdentifierValidator $userIdentifierValidator)
    {
        $this->userIdentifierValidator = $userIdentifierValidator;
    }

    /**
     * @return View
     */
    public function createForm(): View
    {
        return view('admin.user_identifier.create_form');
    }

    public function storeUserIdentifier(): RedirectResponse
    {
        /** @var UserIdentifierModel $userIdentifier */
        $userIdentifier = UserIdentifierModel::query()->create(request()->all());

        return redirect()->route('admin.user.show_user', ['id' => $userIdentifier->user_id]);
    }

    /**
     * @param int $user_id
     * @return View
     */
    public function listUserIdentifiers(int $user_id): View
    {
        $user_identifiers = UserIdentifierModel::query()->where('user_id', $user_id)->paginate(
            request('per_page', 10)
        );

        return view('admin.user_identifier.list_user_identifiers')->with('user_identifiers', $user_identifiers);
    }


    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteUserIdentifier(int $id): RedirectResponse
    {
        UserIdentifierModel::query()->findOrFail($id)->delete();

        return redirect()->back()->with('success_message', 'user identifier deleted successfully!');
    }


    /**
     * @param int $user_identifier_id
     * @return View
     */
    public function editForm(int $user_identifier_id): View
    {
        $userIdentifier = UserIdentifierModel::query()->findOrFail($user_identifier_id);

        return view('admin.user_identifier.edit_identifier')->with('userIdentifier', $userIdentifier);
    }

    /**
     * @param int $user_identifier_id
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateUserIdentifier(int $user_identifier_id): RedirectResponse
    {
        /** @var UserIdentifierModel $userIdentifier */
        $userIdentifier = UserIdentifierModel::query()->findOrFail($user_identifier_id);

        try{
            $this->userIdentifierValidator->validateUpdateUserIdentifier(
                array_merge(['id' => $user_identifier_id], request()->only('value', 'is_verified'))
            );
        }
        catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }

        $userIdentifier->update(request()->only('value', 'is_verified'));

        return redirect()->route('admin.user.show_user', ['id' => $userIdentifier->user_id]);
    }


}

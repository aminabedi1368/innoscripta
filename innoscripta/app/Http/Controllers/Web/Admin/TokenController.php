<?php
namespace App\Http\Controllers\Web\Admin;

use App\Models\AccessTokenModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class TokenController
 * @package App\Http\Controllers\Web\Admin
 */
class TokenController
{


    /**
     * @param int $user_id
     * @return View
     */
    public function listUserTokens(int $user_id)
    {
        $tokens = AccessTokenModel::query()->where('user_id', $user_id)->paginate(
            request('per_page', 10)
        );

        return view('admin.token.list_user_tokens')->with('tokens', $tokens);
    }


    /**
     * @param string $access_token
     * @return RedirectResponse
     */
    public function revokeAccessToken(string $access_token)
    {
        AccessTokenModel::query()->where('id', $access_token)->update(['is_revoked' => 1]);

        return redirect()->back();
    }

}

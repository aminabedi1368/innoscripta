<?php
namespace App\Http\Controllers\Web\Admin;

use App\Models\BadLoginModel;
use Illuminate\Contracts\View\View;

/**
 * Class BadLoginController
 * @package App\Http\Controllers\Web\Admin
 */
class BadLoginController
{


    /**
     * @return View
     */
    public function listBadLogins()
    {
        $badLogins = BadLoginModel::query()->with('userIdentifier')->latest()->paginate(
            request('per_page', 10)
        );

        return view('admin.bad_logins.list_bad_logins')->with('bad_logins', $badLogins);
    }

}

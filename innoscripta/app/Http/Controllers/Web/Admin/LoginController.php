<?php
namespace App\Http\Controllers\Web\Admin;

use App\Actions\Token\IssueTokenAdminAction;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Models\ClientModel;
use App\Models\UserIdentifierModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\RedirectResponse;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
/**
 * Class LoginController
 * @package App\Http\Controllers\Web\Admin
 */
class LoginController
{
    /**
     * @var HashManager
     */
    private HashManager $hashManager;

    /**
     * @var IssueTokenAdminAction
     */
    private IssueTokenAdminAction $issueTokenAdminAction;

    /**
     * LoginController constructor.
     * @param HashManager $hashManager
     * @param IssueTokenAdminAction $issueTokenAdminAction
     */
    public function __construct(
        HashManager $hashManager,
        IssueTokenAdminAction $issueTokenAdminAction
    )
    {
        $this->hashManager = $hashManager;
        $this->issueTokenAdminAction = $issueTokenAdminAction;
    }

    /**
     * @return RedirectResponse
     * @throws InvalidUserCredentialsException
     * @throws OAuthServerException
     */
    public function loginAdmin()
    {
        try {
            /** @var UserModel $user */
            $user = UserModel::query()
                ->where('app_fields->username', request('username'))
                ->first();
            if($user === null) {
//                dd( request('username'));
                /** @var UserIdentifierModel $userIdentifier */
                $userIdentifier = UserIdentifierModel::query()
                    ->where('value', request('username'))
                    ->firstOrFail();

                $user = $userIdentifier->user;

            }

        }
        catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['message' => 'Invalid Credentials']);
        }

        if ($this->hashManager->check(request('password'), $user->password)) {
            /** @var ClientModel $client */
            $client = ClientModel::query()->firstOrFail();

            $request = request();

            $request->merge([
                'username' => "aminabedi1368@gmail.com",
                'grant_type' => 'admin_generate_token',
                'client_id' => $client->client_id,
                'client_secret'=> $client->client_secret
            ]);

            $tokenResponse = $this->issueTokenAdminAction->__invoke($request);
            $expiresIn = $tokenResponse['expires_in']/60;

//            $access_token_cookie = cookie(
//                'access_token2',
//                432413412,
//                $expiresIn
//            );

            setcookie('access_token', $tokenResponse['access_token'], time() + (int)$expiresIn, '/');

            return redirect()->route('admin.dashboard');

            header("Location: ".route('admin.dashboard'));
            exit;
            ## success
            ## set cookie in response
        }
        else {
            return redirect()->back()->withErrors(['message' => 'Invalid Credentials']);
        }
    }

    /**
     * @return RedirectResponse
     */
    public function logoutAdmin()
    {
        if (isset($_COOKIE['access_token'])) {
            unset($_COOKIE['access_token']);
            setcookie('access_token', null, -1, '/');
        }

        return redirect()->route('admin.login_form');
    }

}

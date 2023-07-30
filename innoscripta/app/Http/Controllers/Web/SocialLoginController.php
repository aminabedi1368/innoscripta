<?php

namespace App\Http\Controllers\Web;

use App\Actions\Token\IssueTokenAdminAction;
use App\Constants\SettingConstants;
use App\Constants\UserStatus;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Exceptions\SettingKeyNotFoundAnyWhereException;
use App\Managers\SettingManager;
use App\Models\ClientModel;
use App\Models\UserIdentifierModel;
use App\Models\UserModel;
use Laravel\Socialite\Facades\Socialite;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Str;

/**
 * Class SocialLoginController
 * @package App\Http\Controllers\Web
 */
class SocialLoginController
{

    /**
     * @var IssueTokenAdminAction
     */
    private IssueTokenAdminAction $issueTokenAdminAction;

    /**
     * @var SettingManager
     */
    private SettingManager $settingManager;

    /**
     * SocialLoginController constructor.
     * @param IssueTokenAdminAction $issueTokenAdminAction
     * @param SettingManager $settingManager
     */
    public function __construct(IssueTokenAdminAction $issueTokenAdminAction, SettingManager $settingManager)
    {
        $this->issueTokenAdminAction = $issueTokenAdminAction;
        $this->settingManager = $settingManager;
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return RedirectResponse
     * @throws SettingKeyNotFoundAnyWhereException
     */
    public function redirectToProvider()
    {
        config(['services.google.client_id' => $this->settingManager->get(SettingConstants::OAUTH_GOOGLE_CLIENT_ID)]);
        config(['services.google.client_secret' => $this->settingManager->get(SettingConstants::OAUTH_GOOGLE_CLIENT_SECRET)]);
        config(['services.google.redirect' => $this->settingManager->get(SettingConstants::OAUTH_GOOGLE_REDIRECT_TO_OUR_OAUTH)]);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return RedirectResponse
     * @throws SettingKeyNotFoundAnyWhereException
     * @throws InvalidUserCredentialsException
     * @throws OAuthServerException
     */
    public function handleProviderCallback(): RedirectResponse
    {
        config(['services.google.client_id' => $this->settingManager->get(SettingConstants::OAUTH_GOOGLE_CLIENT_ID)]);
        config(['services.google.client_secret' => $this->settingManager->get(SettingConstants::OAUTH_GOOGLE_CLIENT_SECRET)]);
        config(['services.google.redirect' => $this->settingManager->get(SettingConstants::OAUTH_GOOGLE_REDIRECT_TO_OUR_OAUTH)]);

        $googleUser = Socialite::driver('google')->stateless()->user()->user;


        ## check if user doesn't exist, create it
        /** @var UserIdentifierModel $userIdentifier */
        $userIdentifierModel = UserIdentifierModel::query()
            ->where('type', 'email')
            ->where('value', $googleUser['email'])
            ->with('user')
            ->first();

        ## register user
        if (is_null($userIdentifierModel)) {

            /** @var UserModel $userModel */
            $userModel = UserModel::query()->create([
                'first_name' => $googleUser['given_name'],
                'last_name' => $googleUser['family_name'],
                'app_fields->user_referral_code'=> 'login_by_google',
                'app_fields->user_unique_id'=> Str::random(30),
                'is_super_admin' => false,
                'status' => UserStatus::ACTIVE,
                'password' => 'somerandomtextwichdoesntexist'
            ]);

            /** @var UserIdentifierModel $userIdentifierModel */
            $userIdentifierModel = UserIdentifierModel::query()->create([
                'type' => 'email',
                'value' => $googleUser['email'],
                'is_verified' => true,
                'user_id' => $userModel->id
            ]);
        }

        $request = request();

        /** @var ClientModel $client */
        $client = ClientModel::query()->firstOrFail();

        $request->merge([
            'username' => $googleUser['email'],
            'grant_type' => 'admin_generate_token',
            'client_id' => $client->client_id,
            'client_secret' => $client->client_secret,
            'scope' => []
        ]);
        $newToken = $this->issueTokenAdminAction->__invoke($request);
        return redirect()
            ->to($this->settingManager->get(SettingConstants::OAUTH_GOOGLE_REDIRECT_OUR_OAUTH_TO_APPLICATION) .
                "?access_token=" .
                $newToken['access_token']
                . "&refresh_token=" . $newToken['refresh_token']

            );

    }

}

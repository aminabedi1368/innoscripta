<?php
namespace App\Providers;

use App\Constants\SettingConstants;
use App\Lib\OAuth\AdminTokenGrant;
use App\Lib\OAuth\OauthPasswordGrant;
use App\Lib\OAuth\OtpGrantType;
use App\Lib\OAuth\RefreshTokenGrantType;
use App\Managers\SettingManager;
use App\Repos\AccessTokenRepository;
use App\Repos\ClientRepository;
use App\Repos\RefreshTokenRepository;
use App\Repos\ScopeRepository;
use App\Repos\UserRepository;
use DeviceDetector\DeviceDetector;
use Illuminate\Container\Container;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\ResourceServer;

/**
 * Class AuthServiceProvider
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    public function register()
    {
        $this->registerRepositories();
        $this->registerAuthorizationServer();
        $this->registerResourceServer();
    }

    private function registerRepositories()
    {
        $this->app->bind(AccessTokenRepositoryInterface::class, function (Container $app) {
            return resolve(AccessTokenRepository::class);
        });

        $this->app->bind(ClientRepositoryInterface::class, function (Container $app) {
            return resolve(ClientRepository::class);
        });

        $this->app->bind(ScopeRepositoryInterface::class, function (Container $app) {
            return resolve(ScopeRepository::class);
        });

        $this->app->bind(UserRepositoryInterface::class, function (Container $app) {
            return resolve(UserRepository::class);
        });

        $this->app->bind(RefreshTokenRepositoryInterface::class, function (Container $app) {
            return resolve(RefreshTokenRepository::class);
        });
    }


    private function registerAuthorizationServer()
    {
        $this->app->bind(AuthorizationServer::class, function (Container $app) {
            /** @var SettingManager $settingManager */
            $settingManager = resolve(SettingManager::class);

            $encryption_key = $settingManager->get(SettingConstants::OAUTH_ENCRYPTION_KEY);
            $private_key_string = $settingManager->get(SettingConstants::OAUTH_PRIVATE_KEY);
            $privateKey = new CryptKey($private_key_string, null, false);

            $server =  new AuthorizationServer(
                $app[ClientRepositoryInterface::class],
                $app[AccessTokenRepositoryInterface::class],
                $app[ScopeRepositoryInterface::class],
                $privateKey,
                $encryption_key
            );

            $grantPassword = new OauthPasswordGrant(
                $app[UserRepositoryInterface::class],
                $app[RefreshTokenRepositoryInterface::class],
                new DeviceDetector(
                    array_key_exists('HTTP_USER_AGENT', $_SERVER) ? $_SERVER['HTTP_USER_AGENT'] : "ClI"
                )
            );

            $grantOtp = new OtpGrantType(
                resolve(UserRepository::class),
                resolve(RefreshTokenRepositoryInterface::class)
            );

            $adminGenerateToken = new AdminTokenGrant(
                resolve(UserRepository::class),
                resolve(RefreshTokenRepositoryInterface::class),
                resolve(DeviceDetector::class)
            );
            $refresh_token_expires_days = $settingManager->get(SettingConstants::OAUTH_REFRESH_TOKEN_EXPIRES_DAYS);
            $client_token_expires_days = $settingManager->get(SettingConstants::CLIENT_TOKEN_EXPIRES_DAYS);
            $access_token_expires_days = $settingManager->get(SettingConstants::OAUTH_ACCESS_TOKEN_EXPIRES_DAYS);


            $refreshTokenGrant = new RefreshTokenGrantType($app->get(RefreshTokenRepositoryInterface::class));
            $refreshTokenGrant->setRefreshTokenTTL(new \DateInterval('P'.$refresh_token_expires_days.'M'));

            $grantPassword->setRefreshTokenTTL(new \DateInterval('P'.$access_token_expires_days.'D'));


            $server->enableGrantType(
                $grantPassword,
                new \DateInterval('P'.$access_token_expires_days.'D')
            );

            $server->enableGrantType(
                $adminGenerateToken,
                new \DateInterval('P'.$access_token_expires_days.'D')
            );

            $server->enableGrantType(
                new ClientCredentialsGrant(),
                new \DateInterval('P'.$client_token_expires_days.'D')
            );

            $server->enableGrantType(
                $grantOtp,
                new \DateInterval('P'.$access_token_expires_days.'D')
            );

            $server->enableGrantType(
                $refreshTokenGrant,
                new \DateInterval('P'.$refresh_token_expires_days.'D')
            );


            return $server;
        });
    }

    private function registerResourceServer()
    {
        $this->app->bind(ResourceServer::class, function ($app) {
            /** @var SettingManager $settingManager */
            $settingManager = resolve(SettingManager::class);
            $public_key_string = $settingManager->get(SettingConstants::OAUTH_PUBLIC_KEY);
            $publicKey = new CryptKey($public_key_string, null, false);

            return new ResourceServer(
                $app[AccessTokenRepositoryInterface::class],
                $publicKey
            );
        });
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

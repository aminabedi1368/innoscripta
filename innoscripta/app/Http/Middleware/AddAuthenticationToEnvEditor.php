<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Lib\TokenInfoVO;

/**
 * Class AddAuthenticationToEnvEditor
 * @package App\Http\Middleware
 */
class AddAuthenticationToEnvEditor
{

    public function __construct()
    {

    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->route()->uri() === config('env-editor.route.prefix')) {
            if($request->has('tokenInfo')) {
                /** @var TokenInfoVO $tokenInfo */
                $tokenInfo = $request->get('tokenInfo');
                $userEntity = $request->attributes->get('userEntity');

                if(!$userEntity->isSuperAdmin()) {
                    return redirect()->route('admin.login_form');
                }
            }
            else {
                return redirect()->route('admin.login_form');
            }
        }

        return $next($request);
    }

}

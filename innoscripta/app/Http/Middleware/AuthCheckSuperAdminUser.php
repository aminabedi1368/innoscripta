<?php
namespace App\Http\Middleware;

use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Lib\TokenInfoVO;
use Closure;
use Illuminate\Http\Request;

/**
 * Class AuthCheckSuperAdminUser
 * @package App\Http\Middleware
 */
class AuthCheckSuperAdminUser
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws InvalidUserCredentialsException
     */
    public function handle(Request $request, Closure $next)
    {
        $isAdmin = false;

        if($request->has('tokenInfo')) {

//            dd($request);
//            /** @var TokenInfoVO $tokenInfo */
//            $tokenInfo = $request->get('tokenInfo');
            $isSuperAdmin = $request->input('tokenInfo.userEntity.is_super_admin');
            if($isSuperAdmin) {
                $isAdmin = true;
            }
        }

        if(!$isAdmin) {
            if($this->isApi($request)) {
                throw new InvalidUserCredentialsException;
            }
            else {
                return redirect()->route('admin.login_form');
            }
        }

        return $next($request);
    }

    /**
     * check if request is an API call
     *
     * @param Request $request
     * @return boolean
     */
    private function isApi(Request $request)
    {
        $requestUri = $request->getRequestUri();

        if(str_starts_with($requestUri, '/api')) {
            return true;
        }
        return false;
    }

}

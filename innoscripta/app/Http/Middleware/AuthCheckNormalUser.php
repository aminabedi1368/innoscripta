<?php
namespace App\Http\Middleware;

use App\Exceptions\Auth\InvalidUserCredentialsException;
use Closure;
use Illuminate\Http\Request;

/**
 * Class AuthCheckNormalUser
 * @package App\Http\Middleware
 */
class AuthCheckNormalUser
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws InvalidUserCredentialsException
     */
    public function handle(Request $request, Closure $next)
    {
        $isLoggedIn = false;

        if($request->has('tokenInfo')) {
            $isLoggedIn = true;
        }

        if(!$isLoggedIn) {
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

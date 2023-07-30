<?php

namespace App\Http\Middleware;

use App\Entities\UserEntity;
use Closure;

class UserEntityMiddleware
{
    public function handle($request, Closure $next)
    {
        $tokenInfo = request('tokenInfo');
        $userEntity = $tokenInfo['userEntity'] ?? null;

        if ($userEntity !== null) {
            $userEntity = UserEntity::createFromTokenInfo($userEntity);
            // You can store the modified $userEntity in the request for later use if needed
            $request->attributes->set('userEntity', $userEntity);
        }
        return $next($request);
    }
}

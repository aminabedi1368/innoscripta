<?php
namespace App\Actions\User;

use App\Exceptions\OtpExpiredException;
use App\Repos\OtpRepository;
use App\Repos\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Hashing\HashManager;

/**
 * Class ForgetPasswordAction
 * @package App\Actions\User
 */
class ForgetPasswordAction
{

    /**
     * @var OtpRepository
     */
    private OtpRepository $otpRepository;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var HashManager
     */
    private HashManager $hashManager;

    /**
     * ForgetPasswordAction constructor.
     * @param OtpRepository $otpRepository
     * @param UserRepository $userRepository
     * @param HashManager $hashManager
     */
    public function __construct(
        OtpRepository $otpRepository,
        UserRepository $userRepository,
        HashManager $hashManager
    )
    {
        $this->otpRepository = $otpRepository;
        $this->userRepository = $userRepository;
        $this->hashManager = $hashManager;
    }

    /**
     * @param string $code
     * @param string $new_password
     * @throws OtpExpiredException
     */
    public function __invoke(string $code, string $new_password)
    {
        try {
            $otpEntity = $this->otpRepository->findOtpByCode($code);
        }
        catch (ModelNotFoundException $e) {
            throw new OtpExpiredException;
        }

        if($otpEntity->isUsable()) {
            $this->userRepository->updatePassword(
                $otpEntity->getUserId(),
                $this->hashManager->make($new_password)
            );
        }
        else {
            throw new OtpExpiredException;
        }
    }

}

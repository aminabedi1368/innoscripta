<?php
namespace App\Actions\UserIdentifier;

use App\Exceptions\CorruptedDataException;
use App\Exceptions\UserIdentifier\InvalidVerificationCodeException;
use App\Exceptions\UserIdentifier\UserIdentifierAlreadyVerifiedException;
use App\Repos\OtpRepository;
use App\Repos\UserIdentifierRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class VerifyUserIdentifierAction
 * @package App\Actions\UserIdentifier
 */
class VerifyUserIdentifierAction
{
    /**
     * @var UserIdentifierRepository
     */
    private UserIdentifierRepository $userIdentifierRepository;

    /**
     * @var OtpRepository
     */
    private OtpRepository $otpRepository;

    /**
     * VerifyUserIdentifierAction constructor.
     * @param UserIdentifierRepository $userIdentifierRepository
     * @param OtpRepository $otpRepository
     */
    public function __construct(UserIdentifierRepository $userIdentifierRepository, OtpRepository $otpRepository)
    {
        $this->userIdentifierRepository = $userIdentifierRepository;
        $this->otpRepository = $otpRepository;
    }

    /**
     * @param string $usernameType
     * @param string $username
     * @param string $code
     * @throws CorruptedDataException
     * @throws InvalidVerificationCodeException
     * @throws UserIdentifierAlreadyVerifiedException
     */
    public function __invoke(string $usernameType, string $username, string $code)
    {
        $userIdentifier = $this->userIdentifierRepository->findByTypeAndValueAndCode(
            $usernameType,
            $username,
            $code
        );

        if($userIdentifier->isNotVerified()) {
            try{
                $otpEntity = $this->otpRepository->findOtpByCode($code);
            }
            catch (ModelNotFoundException $e) {
                throw new InvalidVerificationCodeException;
            }

            if($otpEntity->isUsable() && $otpEntity->getCode() === $code) {
                $this->userIdentifierRepository->verifyIdentifier($username , $otpEntity->getUserIdentifierId());
                $this->otpRepository->markTokenAsUsedRightNow($code);
            }
            else {
                throw new InvalidVerificationCodeException;
            }
        }
        else {
            throw new UserIdentifierAlreadyVerifiedException;
        }

    }

}

<?php
namespace App\Http\Controllers\Api\UserIdentifier;

use App\Actions\Messaging\SendVerificationEmailAction;
use App\Actions\Messaging\SendVerificationSmsAction;
use App\Constants\UserIdentifierType;
use App\Exceptions\CorruptedDataException;
use App\Exceptions\InvalidMobileFormatException;
use App\Exceptions\SettingKeyNotFoundAnyWhereException;
use App\Repos\UserIdentifierRepository;
use App\Repos\UserRepository;
use Illuminate\Http\Response;

/**
 * Class SendVerificationCodeToUserIdentifierApi
 * @package App\Http\Controllers\Api\UserIdentifier
 */
class SendVerificationCodeToUserIdentifierApi
{

    /**
     * @var SendVerificationSmsAction
     */
    private SendVerificationSmsAction $sendVerificationSms;

    /**
     * @var SendVerificationEmailAction
     */
    private SendVerificationEmailAction $sendVerificationEmailAction;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var UserIdentifierRepository
     */
    private UserIdentifierRepository $userIdentifierRepository;

    /**
     * SendVerificationCodeToUserIdentifierApi constructor.
     * @param SendVerificationSmsAction $sendVerificationSms
     * @param SendVerificationEmailAction $sendVerificationEmailAction
     * @param UserIdentifierRepository $userIdentifierRepository
     */
    public function __construct(
        SendVerificationSmsAction $sendVerificationSms,
        SendVerificationEmailAction $sendVerificationEmailAction,
        UserIdentifierRepository $userIdentifierRepository
    )
    {
        $this->sendVerificationSms = $sendVerificationSms;
        $this->sendVerificationEmailAction = $sendVerificationEmailAction;
        $this->userIdentifierRepository = $userIdentifierRepository;
    }

    /**
     * username: majid8911303@gmail.com
     * @throws CorruptedDataException
     * @throws InvalidMobileFormatException
     * @throws SettingKeyNotFoundAnyWhereException
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        $userIdentifier = $this->userIdentifierRepository->findByValue(request('username'));
        if($userIdentifier->getType() == UserIdentifierType::EMAIL) {
            $this->sendVerificationEmailAction->__invoke($userIdentifier);
        }
        else {
            $this->sendVerificationSms->__invoke($userIdentifier);
        }

        return response()->noContent();
    }

}

<?php
namespace App\Actions\Messaging;

use App\Actions\UserIdentifier\CreateOtpForUserIdentifierAction;
use App\Constants\ActionConstants;
use App\Constants\ServiceNames;
use App\Constants\SettingConstants;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\InvalidMobileFormatException;
use App\Exceptions\SettingKeyNotFoundAnyWhereException;
use App\Lib\MobileVO;
use App\Managers\ExternalServiceErrorManager;
use App\Managers\SettingManager;
use Exception;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\KavenegarApi;
use Twilio\Rest\Client as TwilioService;

/**
 * Class SendVerificationSmsAction
 * @package App\Actions\Messaging
 */
class SendVerificationSmsAction
{
    /**
     * @var KavenegarApi
     */
    private KavenegarApi $kavenegarApi;

    /**
     * @var SettingManager
     */
    private SettingManager $settingManager;

    /**
     * @var CreateOtpForUserIdentifierAction
     */
    private CreateOtpForUserIdentifierAction $createOtpForUserIdentifierAction;

    /**
     * @var ExternalServiceErrorManager
     */
    private ExternalServiceErrorManager $externalServiceErrorManager;

    /**
     * @param KavenegarApi $kavenegarApi
     * @param SettingManager $settingManager
     * @param CreateOtpForUserIdentifierAction $createOtpForUserIdentifierAction
     * @param ExternalServiceErrorManager $externalServiceErrorManager
     */
    public function __construct(
        KavenegarApi $kavenegarApi,
        SettingManager $settingManager,
        CreateOtpForUserIdentifierAction $createOtpForUserIdentifierAction,
        ExternalServiceErrorManager $externalServiceErrorManager
    )
    {
        $this->kavenegarApi = $kavenegarApi;
        $this->settingManager = $settingManager;
        $this->createOtpForUserIdentifierAction = $createOtpForUserIdentifierAction;
        $this->externalServiceErrorManager = $externalServiceErrorManager;
    }

    /**
     * @param UserIdentifierEntity $userIdentifierEntity
     * @return mixed
     * @throws InvalidMobileFormatException
     * @throws SettingKeyNotFoundAnyWhereException
     * @throws Exception
     */
    public function __invoke(UserIdentifierEntity $userIdentifierEntity)
    {
        $mobile = new MobileVO($userIdentifierEntity->getValue());
        $template = $this->settingManager->get(SettingConstants::KAVEHNEGAR_VERIFICATION_TEMPLATE_NAME);
        $receptors = $mobile->format(MobileVO::WithZero);

        $otpEntity = $this->createOtpForUserIdentifierAction->__invoke($userIdentifierEntity);

        try{
//            $this->kavenegarApi->VerifyLookup(
//                $receptors,
//                $otpEntity->getCode(),
//                null,
//                null,
//                $template
//            );
            $receiverNumber = "+905312991291";
            $message = $template;

            $twilio = new TwilioService($this->settingManager->get(SettingConstants::TWILIO_SID),$this->settingManager->get(SettingConstants::TWILIO_TOKEN));
            $twilio_verify_sid ="VAcfad8ee53dd87f785fffe893d9772524";

            $twilio_number = $this->settingManager->get(SettingConstants::TWILIO_FROM);

            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create($receiverNumber, "sms");

            $twilio->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message]);

        }
        catch (Exception $e) {
            $this->externalServiceErrorManager->logError(
                ServiceNames::SERVICE_SMS_KAVEHNEGAR,
                ActionConstants::SEND_SMS_VERIFICATION,
                $e->getMessage(),
                get_class($e)
            );

            throw $e;
        }

    }

}

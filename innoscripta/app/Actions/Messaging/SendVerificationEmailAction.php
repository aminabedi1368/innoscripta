<?php
namespace App\Actions\Messaging;

use App\Actions\UserIdentifier\CreateOtpForUserIdentifierAction;
use App\Constants\ActionConstants;
use App\Constants\ServiceNames;
use App\Constants\SettingConstants;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\SettingKeyNotFoundAnyWhereException;
use App\Managers\ExternalServiceErrorManager;
use App\Managers\SettingManager;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

/**
 * Class SendVerificationEmailAction
 * @package App\Actions\Messaging
 */
class SendVerificationEmailAction
{

    /**
     * @var SettingManager
     */
    private SettingManager $settingManager;

    /**
     * @var ExternalServiceErrorManager
     */
    private ExternalServiceErrorManager $externalServiceErrorManager;

    /**
     * @var CreateOtpForUserIdentifierAction
     */
    private CreateOtpForUserIdentifierAction $createOtpForUserIdentifierAction;

    /**
     * SendVerificationEmailAction constructor.
     * @param SettingManager $settingManager
     * @param ExternalServiceErrorManager $externalServiceErrorManager
     * @param CreateOtpForUserIdentifierAction $createOtpForUserIdentifierAction
     */
    public function __construct(
        SettingManager $settingManager,
        ExternalServiceErrorManager $externalServiceErrorManager,
        CreateOtpForUserIdentifierAction $createOtpForUserIdentifierAction

    )
    {
        $this->settingManager = $settingManager;
        $this->externalServiceErrorManager = $externalServiceErrorManager;
        $this->createOtpForUserIdentifierAction = $createOtpForUserIdentifierAction;
    }

    /**
     * @param UserIdentifierEntity $userIdentifierEntity
     * @return int
     * @throws SettingKeyNotFoundAnyWhereException
     */
//    public function __invokegiu(UserIdentifierEntity $userIdentifierEntity)
//    {
//        $email_address = $userIdentifierEntity->getValue();
//
//        $host = $this->settingManager->get(SettingConstants::MAIL_SERVER_ADDRESS);
//        $port = $this->settingManager->get(SettingConstants::MAIL_SERVER_PORT);
//        $username = $this->settingManager->get(SettingConstants::MAIL_SERVER_USERNAME);
//        $password = $this->settingManager->get(SettingConstants::MAIL_SERVER_PASSWORD);
//        $websiteUrl = $this->settingManager->get(SettingConstants::WEBSITE_URL);
//        $timeout = (int)$this->settingManager->get(SettingConstants::MAIL_SERVER_TIMEOUT_SECONDS);
//
////        $transport = (new Swift_SmtpTransport($host, $port))
////            ->setUsername($username)
////            ->setPassword($password)
////            ->setEncryption("tls")
////            ->setTimeout($timeout);
//
//        $mailer = app(Mailer::class);
//
////        $mailer = new Swift_Mailer($transport);
//
//        $otpEntity = $this->createOtpForUserIdentifierAction->__invoke($userIdentifierEntity);
//        $email_text = parseText(
//            $this->settingManager->get(SettingConstants::MAIL_VERIFICATION_TEMPLATE),
//            [
//                'code' => $otpEntity->getCode(),
//                'username' => $userIdentifierEntity->getValue(),
//                'website' => $websiteUrl
//            ]
//        );
//
//        try{
//            $fromName = $this->settingManager->get(SettingConstants::MAIL_VERIFICATION_FROM_NAME);
//            $fromAddress = $this->settingManager->get(SettingConstants::MAIL_VERIFICATION_FROM_ADDRESS);
//            $subject = $this->settingManager->get(SettingConstants::MAIL_VERIFICATION_SUBJECT);
//
//            $message = (new Swift_Message())
//                ->setSubject($subject)
//                ->setFrom([$fromAddress => $fromName])
//                ->setTo([$email_address])
//                ->setBody($email_text, 'text/html');
//
//            $result = $mailer->send($message);
//            $mailer->getTransport()->stop();
//
//            return $result;
//        }
//
//        catch(\Exception $e) {
//
//            $this->externalServiceErrorManager->logError(
//                ServiceNames::SERVICE_EMAIL_ZOHO,
//                ActionConstants::SEND_EMAIL_VERIFICATION,
//                $e->getMessage(),
//                get_class($e)
//            );
//
//            throw $e;
//        }
//    }

    public function __invoke(UserIdentifierEntity $userIdentifierEntity)
    {
        $email_address = $userIdentifierEntity->getValue();

        $host = $this->settingManager->get(SettingConstants::MAIL_SERVER_ADDRESS);
        $port = $this->settingManager->get(SettingConstants::MAIL_SERVER_PORT);
        $username = $this->settingManager->get(SettingConstants::MAIL_SERVER_USERNAME);
        $password = $this->settingManager->get(SettingConstants::MAIL_SERVER_PASSWORD);
        $websiteUrl = $this->settingManager->get(SettingConstants::WEBSITE_URL);
        $timeout = (int)$this->settingManager->get(SettingConstants::MAIL_SERVER_TIMEOUT_SECONDS);

        // Set the mailer configurations dynamically
        $transport = Transport::fromDsn("smtp://$username:$password@$host:$port?encryption=tls&auth_mode=null&timeout=$timeout");

        $mailer = new Mailer($transport);

        $otpEntity = $this->createOtpForUserIdentifierAction->__invoke($userIdentifierEntity);
        $email_text = parseText(
            $this->settingManager->get(SettingConstants::MAIL_VERIFICATION_TEMPLATE),
            [
                'code' => $otpEntity->getCode(),
                'username' => $userIdentifierEntity->getValue(),
                'website' => $websiteUrl,
            ]
        );

        try {
            $fromName = $this->settingManager->get(SettingConstants::MAIL_VERIFICATION_FROM_NAME);
            $fromAddress = $this->settingManager->get(SettingConstants::MAIL_VERIFICATION_FROM_ADDRESS);
            $subject = $this->settingManager->get(SettingConstants::MAIL_VERIFICATION_SUBJECT);

            // Create the email message
            $email = (new Email())
                ->from($fromAddress)
                ->to($email_address)
                ->subject($subject)
                ->html($email_text);

            // Send the email
            $mailer->send($email);
            return true;
        } catch (TransportExceptionInterface $e) {
            $this->externalServiceErrorManager->logError(
                ServiceNames::SERVICE_EMAIL_ZOHO,
                ActionConstants::SEND_EMAIL_VERIFICATION,
                $e->getMessage(),
                get_class($e)
            );

            throw $e;
        }
    }

}

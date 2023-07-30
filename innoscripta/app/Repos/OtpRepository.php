<?php
namespace App\Repos;

use App\Entities\OtpEntity;
use App\Hydrators\OtpHydrator;
use App\Models\OtpModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class OtpRepository
 * @package App\Repos
 */
class OtpRepository
{
    /**
     * @var OtpModel
     */
    private OtpModel $otpModel;

    /**
     * @var OtpHydrator
     */
    private OtpHydrator $otpHydrator;

    /**
     * OtpRepository constructor.
     * @param OtpModel $otpModel
     * @param OtpHydrator $otpHydrator
     */
    public function __construct(OtpModel $otpModel, OtpHydrator $otpHydrator)
    {
        $this->otpModel = $otpModel;
        $this->otpHydrator = $otpHydrator;
    }

    /**
     * @param string $code
     * @return OtpEntity
     */
    public function findOtpByCode(string $code)
    {
        /** @var OtpModel $otpModel */
        $otpModel = $this->otpModel->newQuery()->where('code', $code)->firstOrFail();

        return $this->otpHydrator->fromModel($otpModel)->toEntity();
    }

    /**
     * @param OtpEntity $otpEntity
     * @return OtpEntity
     */
    public function insertOtp(OtpEntity $otpEntity)
    {
        /** @var OtpModel $otpModel */
        $otpModel = $this->otpModel->newQuery()->create([
            'code' => $otpEntity->getCode(),
            'user_id' => $otpEntity->getUserId(),
            'user_identifier_id' => $otpEntity->getUserIdentifierId(),
            'used_at' => $otpEntity->getUsedAt(),
            'expires_at' => $otpEntity->getExpiresAt()
        ]);

        return $otpEntity->setId($otpModel->id);
    }

    /**
     * @return int
     */
    public function getNewCode()
    {
        $rand = rand(10000, 99999);

        $otp = $this->otpModel->newQuery()
            ->where('code', $rand)
            ->where(function(Builder $query) {
                $query->whereNotNull('used_at')
                    ->orWhereDate("expires_at", ">", Carbon::now());
            })
            ->first();

        if(is_null($otp)) {
            return $rand;
        }
        else {
            return $this->getNewCode();
        }
    }

    /**
     * @param string $code
     */
    public function markTokenAsUsedRightNow(string $code)
    {
        $otpModel = $this->otpModel->newQuery()->where('code', $code)->firstOrFail();

        $otpModel->update([
            'used_at' => Carbon::now()
        ]);
    }

}

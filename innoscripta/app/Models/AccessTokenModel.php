<?php
namespace App\Models;

use App\Entities\ScopeEntity;
use App\Hydrators\ScopeHydrator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AccessTokenModel
 * @property string $id
 * @property int $user_id
 * @property int $identifier_id
 * @property int $client_id
 * @property string $device_os
 * @property string $device_type
 * @property string $details
 * @property array $scopes
 * @property bool $is_revoked
 * @property Carbon $expires_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property UserModel user
 * @property UserIdentifierModel userIdentifier
 *
 * @package App\Models
 */
class AccessTokenModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'access_tokens';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';


    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'user_identifier_id',
        'client_id',
        'device_os',
        'ip',
        'device_type',
        'details',
        'scopes',
        'is_revoked',
        'expires_at'
    ];

    /**
     * @param $value
     * @return ScopeEntity[]|null
     */
    public function getScopesAttribute($value)
    {
        /** @var ScopeHydrator $scopeHydrator */
        $scopeHydrator = resolve(ScopeHydrator::class);

        if(!empty($value)) {
            return $scopeHydrator->fromArrayOfArrays(json_decode($value, true))->toArrayOfEntities();
        }
        else {
            return $value;
        }
    }

    /**
     * @return string
     */
    public function scopesToString()
    {
        $scopes = $this->scopes;

        if(!empty($scopes)) {
            $scopes_array = [];
            /** @var ScopeEntity $scope */
            foreach ($scopes as $scope) {
                $scopes_array[] = $scope->getName();
            }
            return implode(', ', $scopes_array);
        }

        return "";
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function userIdentifier()
    {
        return $this->belongsTo(UserIdentifierModel::class, 'user_identifier_id', 'id');
    }

}

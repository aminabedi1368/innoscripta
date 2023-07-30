<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class OtpModel
 *
 * @property int id
 * @property int user_identifier_id
 * @property int user_id
 * @property string code
 * @property Carbon expires_at
 * @property Carbon used_at
 * @property Carbon created_at
 * @property UserModel user
 * @property UserIdentifierModel user_identifier
 *
 * @package App\Models
 */
class OtpModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'otp';

    /**
     * @var array
     */
    protected $fillable = [
        'user_identifier_id',
        'user_id',
        'code',
        'used_at',
        'expires_at'
    ];


    /**
     * @return BelongsTo
     */
    public function userIdentifier()
    {
        return $this->belongsTo(UserIdentifierModel::class, 'user_identifier_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

}

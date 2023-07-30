<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserIdentifierModel
 * @property int id
 * @property string type
 * @property string value
 * @property bool is_verified
 * @property int user_id
 * @property int user_identifier_id
 * @property UserModel user
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @package App\Models
 */
class UserIdentifierModel extends Model
{

    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'user_identifiers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'value',
        'is_verified',
        'user_id',
        'user_identifier_id'
    ];

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


    /**
     * @return BelongsTo
     */
    public function otp()
    {
        return $this->hasMany(OtpModel::class, 'user_identifier_id', 'id');
    }

}

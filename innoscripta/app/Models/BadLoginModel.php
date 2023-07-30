<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BadLoginModel
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $login_type
 * @property string $device_type
 * @property string $device_os
 * @property string $ip
 * @property int $user_identifier_id
 * @property UserIdentifierModel $user_identifier
 * @property Carbon created_at
 * @package App\Models
 */
class BadLoginModel extends Model
{

    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    /**
     * @var string
     */
    protected $table = 'bad_logins';

    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'login_type',
        'device_type',
        'device_os',
        'ip',
        'user_identifier_id'
    ];

    /**
     * @return BelongsTo
     */
    public function userIdentifier()
    {
        return $this->belongsTo(UserIdentifierModel::class, 'user_identifier_id', 'id');
    }

}

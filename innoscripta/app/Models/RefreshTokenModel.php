<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RefreshTokenModel
 *
 * @property string $id
 * @property string $access_token_id
 * @property bool $is_revoked
 * @property Carbon $expires_at
 *
 * @package App\Models
 */
class RefreshTokenModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'refresh_tokens';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'access_token_id',
        'is_revoked',
        'expires_at'
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

}

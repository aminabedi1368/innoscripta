<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExternalServiceErrorModel
 * @package App\Models
 */
class ExternalServiceErrorModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'external_service_errors';


    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'action',
        'service_name',
        'exception_class',
        'error_message',
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

}

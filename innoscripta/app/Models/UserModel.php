<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserModel
 *
 * @property int id
 * @property string first_name
 * @property string last_name
 * @property string year_month_day
 * @property string year_month
 * @property string password
 * @property string status
 * @property string year_week
 * @property string avatar
 * @property array app_fields
 *
 * @package App\Models
 */
class UserModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'status',
        'year_month_day',
        'year_month',
        'year_week',
        'avatar',
        'app_fields',
        'is_super_admin'
    ];

    protected $casts = [
        'app_fields' => 'array'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * @param $value
     */
    public function setAppFieldsAttribute($value)
    {
        $this->attributes['app_fields'] = json_encode($value);
    }

    /**
     * @param $value
     * @return array
     */
    public function getAppFieldsAttribute($value): array
    {
        if(is_string($value) && is_json($value)) {
            return json_decode($value, true);
        }
        else {
            return [];
        }
    }


    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            RoleModel::class,
            'user_roles',
            'user_id',
            'role_id'
        );
    }

    /**
     * @return HasMany
     */
    public function userIdentifiers(): HasMany
    {
        return $this->hasMany(UserIdentifierModel::class, 'user_id', 'id');
    }

}

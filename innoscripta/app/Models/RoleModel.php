<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class RoleModel
 * @property int project_id
 * @property string name
 * @property string slug
 * @property string description
 * @property int id
 *
 * @package App\Models
 */
class RoleModel extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'project_id',
        'description'
    ];


    /**
     * @return BelongsToMany
     */
    public function scopes(): BelongsToMany
    {
        return $this->belongsToMany(ScopeModel::class, 'role_scopes', 'role_id', 'scope_id');

//        return $this->belongsToMany(ScopeModel::class)->using(RoleScopeModel::class);
    }


    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(UserModel::class, 'user_roles', 'role_id', 'user_id');

//        return $this->belongsToMany(UserModel::class)->using(UserRoleModel::class);
    }

}

<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProjectModel
 *
 * @property int $id
 * @property string $name
 * @property string $project_id
 * @property int $creator_user_id
 * @property bool $is_first_party
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class ProjectModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'projects';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'project_id',
        'creator_user_id',
        'is_first_party'
    ];

    /**
     * @return BelongsTo
     */
    public function creatorUser()
    {
        return $this->belongsTo(UserModel::class, 'creator_user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function roles()
    {
        return $this->hasMany(RoleModel::class, 'project_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function clients()
    {
        return $this->hasMany(ClientModel::class, 'project_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function scopes()
    {
        return $this->hasMany(ScopeModel::class, 'project_id', 'id');
    }

}

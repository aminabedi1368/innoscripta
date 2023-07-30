<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ScopeModel
 * @property int project_id
 * @property string name
 * @property string slug
 * @property string description
 * @property int id
 *
 * @package App\Models
 */
class ScopeModel extends Model
{

    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'scopes';

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
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(RoleModel::class)->using(RoleScopeModel::class);
    }

}

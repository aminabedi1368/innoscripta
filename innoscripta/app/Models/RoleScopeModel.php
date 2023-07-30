<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class RoleScopeModel
 * @package App\Models
 */
class RoleScopeModel extends Pivot
{

    /**
     * @var string
     */
    protected $table = 'role_scopes';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return HasOne
     */
    public function scope()
    {
        return $this->hasOne(ScopeModel::class, 'id', 'scope_id');
    }

    /**
     * @return HasOne
     */
    public function role()
    {
        return $this->hasOne(ScopeModel::class, 'id', 'role_id');
    }

}

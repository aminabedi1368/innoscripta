<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class UserRoleModel
 * @package App\Models
 */
class UserRoleModel extends Pivot
{

    protected $table = 'user_roles';


    /**
     * @var bool
     */
    public $timestamps = false;

}

<?php
namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ClientModel
 *
 * @property string name
 * @property string slug
 * @property string type
 * @property string oauth_client_type
 * @property string client_id
 * @property string client_secret
 * @property bool is_active
 * @property int project_id
 * @property int id
 * @property string redirect_urls
 *
 * @package App\Models
 */
class ClientModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'clients';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'client_id',
        'client_secret',
        'oauth_client_type',
        'is_active',
        'project_id',
        'redirect_urls'
    ];

    /**
     * @param $value
     * @return array
     * @throws Exception
     */
    public function getRedirectUrlsAttribute($value)
    {
        if(!is_null($value)) {
            if(is_json($value)) {
                return json_decode($value, true);
            }
            elseif (is_array($value)) {
                return $value;
            }
            else {
                throw new Exception("Invalid redirect_urls value in database for client");
            }
        }

        return [];
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $title
 * @property int $status
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Task extends Model
{

    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case 1:
                return "未着手";
                break;
            case 2:
                return "着手中";
                break;
            case 3:
                return "完了";
                break;
            case 4:
                return "延期";
                break;
            default:
                return "未着手";
        }
    }
    
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['title', 'status', 'description', 'created_at', 'updated_at'];
}

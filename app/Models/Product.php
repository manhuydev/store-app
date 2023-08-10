<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'store_id'
    ];

    /**
     * @param string $keyword
     * @param string $limit
     * 
     * @return Collection | LengthAwarePaginator
     */
    public static function getList($keyword, $limit) {
        $query = Store::query();

        if ($keyword) {
            $query->where('name', 'like', $keyword);
        }

        return is_null($limit) ? $query->get() : $query->paginate($limit);
    }
}

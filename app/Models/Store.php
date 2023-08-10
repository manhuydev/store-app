<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'user_id'
    ];
    
    protected static function booted () {
        static::deleting(function(Store $store) {
            $store->products()->delete();
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }

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

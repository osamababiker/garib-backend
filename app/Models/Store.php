<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Store extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $table = 'stores';
    protected $fillable = [
        'name',
        'logo',
        'offer',
        'description',
        'lat',
        'lng',
        'rating',
        'categoryId',
        'categoryName',
        'isDeleted'
    ];

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'stores.name' => 10,
        ],
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category','categoryId');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order','storeId');
    }
 

}

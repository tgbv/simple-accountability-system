<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //use HasFactory;
    # table name
    protected $table = "categories";

    # fillable fields
    protected $fillable = ['name', 'parent_of'];

    # casts
    public $casts = [
        'parent_of' => 'integer',
    ];

    /*
    *   get category entities
    */
    public function getEntities()
    {
        return $this->belongsToMany(
            \App\Models\Entities::class,
            \App\Models\Pivots\EntityCategory::class,
            "category_id", // my key on pivot
            "entity_id", // their key on pivot
            "id",
            "id"
        );
    }

    /*
    *   get parent category
    */
    public function getParent()
    {
        return $this->belongsTo(
            self::class,
            'parent_of',
            'id',
        );
    }

    /*
    *   get child categories
    */
    public function getChilds()
    {
        return $this->hasMany(
            self::class,
            'parent_of',
            'id',
        );
    }

    public function getChildren(){
        return $this->getChilds();
    }

    /*
    *
    */
}

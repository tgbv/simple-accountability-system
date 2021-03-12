<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entities extends Model
{
    # table name
    protected $table = "entities";

    # fillable fields
    protected $fillable = ['name', 'qty', 'ppu','sum','notes'];

    # casts
    public $casts = [
        'qty' => 'float',
        'ppu' => 'float',
        'sum' => 'float',
    ];

    /*
    *   get categories
    */
    public function getCategories()
    {
        return $this->belongsToMany(
            \App\Models\Categories::class,
            \App\Models\Pivots\EntityCategory::class,
            'entity_id',   // my pivot key
            'category_id', // their pivot key
            'id',
            'id'
        );
    }
}

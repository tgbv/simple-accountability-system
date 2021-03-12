<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityCategory extends Model
{
    # table name
    protected $table = "p_entity_category";

    # fillable fields
    protected $fillable = ['entity_id', 'category_id'];

    # casts
    public $casts = [
        'entity_id'     => 'integer',
        'category_id' => 'integer',
    ];

    # no primary key
    protected $primaryKey = null;

    # no incrementing
    public $incrementing = false;

    # no updated at
    const UPDATED_AT = null;
}

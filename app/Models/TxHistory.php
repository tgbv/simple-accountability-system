<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TxHistory extends Model
{
    # table name
    protected $table = "tx_history";

    # fillable fields
    protected $fillable = ['notes'];

    # casts
    public $casts = [

    ];

    /*
    *   get all entities from this tx
    */
    public function getTxEntities()
    {
        return $this->belongsToMany(
            \App\Models\Entities::class,
            \App\Models\Pivots\TxEntity::class,
            'entity_id',
            'tx_id',
            'id',
            'id'
        )->withPivot('sum', 'type_id');
    }

    /*
    *   get all tx pivots for tx entities
    */
    public function getTxPivots()
    {
        return $this->hasMany(
            \App\Models\Pivots\TxEntity::class,
            'tx_id',
            'id'
        );
    }

    /*
    *
    */
}

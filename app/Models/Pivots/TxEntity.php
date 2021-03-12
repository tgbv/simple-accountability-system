<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TxEntity extends Model
{
    # table name
    protected $table = "p_tx_entity";

    # fillable fields
    protected $fillable = ['tx_id', 'entity_id', 'type_id','sum','notes', 'qty'];

    # casts
    public $casts = [
        'tx_id'     => 'integer',
        'entity_id' => 'integer',
        //'type_id'   => 'integer',
        'sum'       => 'float',
        'qty'       => 'float',
    ];

    # no primary key
    protected $primaryKey = null;

    # no incrementing
    public $incrementing = false;


}

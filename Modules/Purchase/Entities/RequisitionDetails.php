<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisition_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'item_id', 'qty'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Purchase\Database\factories\RequisitionDetailsFactory::new();
    }
}

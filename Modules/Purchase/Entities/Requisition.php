<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_no', 'date', 'type', 'received', 'is_approved', 'approved_by', 'created_by',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Purchase\Database\factories\RequisitionFactory::new();
    }
}

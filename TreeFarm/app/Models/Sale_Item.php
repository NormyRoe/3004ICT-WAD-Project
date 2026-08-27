<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale_Item extends Model
{
    
    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'sales_id',
        'inventory_id',
        'quantity',
        'unit_price',
        'discount',
        'total_price',
        'created_by',
        'modified_by'
    ];


    /***************************************************
    
        Relationships (One-to-Many)
        - Excluding created_by and modified_by

    ****************************************************/

    


    /***************************************************
    
        Relationships (Many-to-One)
        - Excluding created_by and modified_by

    ****************************************************/

    // A sale item belongs to a sale
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sales_id');
    }

    // A sale item belongs to an inventory record
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }


    /***************************************************
    
        Relationships (created_by and modified_by)
        
    ****************************************************/

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modified_by()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }


}

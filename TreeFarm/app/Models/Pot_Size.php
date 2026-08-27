<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pot_Size extends Model
{

    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'size',
        'created_by',
        'modified_by'
    ];


    /***************************************************
    
        Relationships (One-to-Many)
        - Excluding created_by and modified_by

    ****************************************************/
    // A pot size can have many inventories
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'pot_size_id');
    }

    // A pot size can have many prices
    public function prices()
    {
        return $this->hasMany(Price::class, 'pot_size_id');
    }

    // A pot size can have many exception prices
    public function exception_prices()
    {
        return $this->hasMany(Exception_Price::class, 'pot_size_id');
    }

    // A pot size can have many allocated tasks
    public function allocated_tasks()
    {
        return $this->hasMany(Allocated_Task::class, 'pot_size_id');
    }
    


    /***************************************************
    
        Relationships (Many-to-One)
        - Excluding created_by and modified_by

    ****************************************************/

    


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

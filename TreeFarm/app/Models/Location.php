<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    
    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'area_id',
        'block_id',
        'aisle_id',
        'created_by',
        'modified_by'
    ];


    /***************************************************
    
        Relationships (One-to-Many)
        - Excluding created_by and modified_by

    ****************************************************/

    // A location can have many inventories
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'location_id');
    }

    // A location can be used as location_1 in allocated tasks
    public function allocated_tasks_location_1()
    {
        return $this->hasMany(AllocatedTask::class, 'location_1_id');
    }

    // A location can be used as location_2 in allocated tasks
    public function allocated_tasks_location_2()
    {
        return $this->hasMany(AllocatedTask::class, 'location_2_id');
    }


    /***************************************************
    
        Relationships (Many-to-One)
        - Excluding created_by and modified_by

    ****************************************************/

    // A location belongs to an area
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    // A location belongs to a block (optional)
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    // A location belongs to an aisle (optional)
    public function aisle()
    {
        return $this->belongsTo(Aisle::class, 'aisle_id');
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

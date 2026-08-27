<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    
    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'tree_type_id',
        'plant_id',
        'botanical_name',
        'common_name',
        'mature_height_min',
        'mature_height_max',
        'mature_width_min',
        'mature_width_max',
        'created_by',
        'modified_by'
    ];


    /***************************************************
    
        Relationships (One-to-Many)
        - Excluding created_by and modified_by

    ****************************************************/

    // A tree can have many inventories
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'tree_id');
    }

    // A tree can have many exception prices
    public function exception_prices()
    {
        return $this->hasMany(Exception_Price::class, 'tree_id');
    }

    // A tree can have many allocated tasks
    public function allocated_tasks()
    {
        return $this->hasMany(Allocated_Task::class, 'tree_id');
    }


    /***************************************************
    
        Relationships (Many-to-One)
        - Excluding created_by and modified_by

    ****************************************************/

    // A tree belongs to a tree type
    public function tree_type()
    {
        return $this->belongsTo(Tree_Type::class, 'tree_type_id');
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    
    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'tree_id',
        'pot_size_id',
        'location_id',
        'quantity',
        'created_by',
        'modified_by'
    ];


    /***************************************************
    
        Relationships (One-to-Many)
        - Excluding created_by and modified_by

    ****************************************************/

    // An inventory record can have many sale items
    public function sale_items()
    {
        return $this->hasMany(Sale_Item::class, 'inventory_id');
    }


    /***************************************************
    
        Relationships (Many-to-One)
        - Excluding created_by and modified_by

    ****************************************************/

    // An inventory record belongs to a tree
    public function tree()
    {
        return $this->belongsTo(Tree::class, 'tree_id');
    }

    // An inventory record belongs to a pot size
    public function pot_size()
    {
        return $this->belongsTo(Pot_Size::class, 'pot_size_id');
    }

    // An inventory record belongs to a location
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
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

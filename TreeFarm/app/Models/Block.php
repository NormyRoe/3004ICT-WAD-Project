<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    
    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'name',
        'created_by',
        'modified_by'
    ];


    /***************************************************
    
        Relationships (One-to-Many)
        - Excluding created_by and modified_by

    ****************************************************/

    // A block can have many locations
    public function locations()
    {
        return $this->hasMany(Location::class, 'block_id');
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

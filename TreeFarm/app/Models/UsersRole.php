<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersRole extends Model
{

    /***************************************************
    
        Mass Assignment
    
    ****************************************************/
    protected $fillable = [
        'users_id',
        'roles_id',
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

    // Link belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Link belongs to a role
    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id');
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

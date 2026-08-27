<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allocated_Tasks_User extends Model
{
    
    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'allocated_task_id',
        'user_id',
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

    // An allocated task user belongs to an allocated task
    public function allocated_task()
    {
        return $this->belongsTo(Allocated_Task::class, 'allocated_task_id');
    }

    // An allocated task user belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

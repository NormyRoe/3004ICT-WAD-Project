<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllocatedTask extends Model
{
    
    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'task_id',
        'tree_id',
        'location_1_id',
        'location_2_id',
        'pot_size_id',
        'date',
        'notes',
        'quantity',
        'done',
        'allocated',
        'created_by',
        'modified_by'
    ];


    /***************************************************
    
        Relationships (One-to-Many)
        - Excluding created_by and modified_by

    ****************************************************/

    // An allocated task can have many allocated task users
    public function allocated_task_users()
    {
        return $this->hasMany(AllocatedTasksUser::class, 'allocated_task_id');
    }


    /***************************************************
    
        Relationships (Many-to-One)
        - Excluding created_by and modified_by

    ****************************************************/

    // An allocated task belongs to a task
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    // An allocated task belongs to a tree (optional)
    public function tree()
    {
        return $this->belongsTo(Tree::class, 'tree_id');
    }

    // An allocated task belongs to location_1 (optional)
    public function location_1()
    {
        return $this->belongsTo(Location::class, 'location_1_id');
    }

    // An allocated task belongs to location_2 (optional)
    public function location_2()
    {
        return $this->belongsTo(Location::class, 'location_2_id');
    }

    // An allocated task belongs to a pot size (optional)
    public function pot_size()
    {
        return $this->belongsTo(Pot_Size::class, 'pot_size_id');
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

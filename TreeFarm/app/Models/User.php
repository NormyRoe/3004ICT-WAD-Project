<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'job_title',
        'manager_id',
        'status',
        'password',
        'created_by',
        'modified_by'
    ];

    /***************************************************
    
        Fields which are not to appear in JSON responses.

    ****************************************************/
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /***************************************************
    
        Relationships (One-to-Many)
        - Excluding created_by and modified_by

    ****************************************************/

    // A manager has many users
    public function managed_users()
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    // A user can have many allocated_tasks_users records
    public function allocated_tasks_users()
    {
        return $this->hasMany(AllocatedTasksUser::class, 'user_id');
    }

    // A user can have many sales (as salesperson)
    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }


    /***************************************************
    
        Relationships (Many-to-One)
        - Excluding created_by and modified_by

    ****************************************************/

    // A user may have a manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
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


    /***************************************************
    
        Reverse Relationships (created_by)
        
    ****************************************************/

    public function created_users()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function created_roles()
    {
        return $this->hasMany(Role::class, 'created_by');
    }

    public function created_users_roles()
    {
        return $this->hasMany(UsersRole::class, 'created_by');
    }

    public function created_pot_sizes()
    {
        return $this->hasMany(PotSize::class, 'created_by');
    }

    public function created_tree_types()
    {
        return $this->hasMany(TreeType::class, 'created_by');
    }

    public function created_trees()
    {
        return $this->hasMany(Tree::class, 'created_by');
    }

    public function created_blocks()
    {
        return $this->hasMany(Block::class, 'created_by');
    }

    public function created_aisles()
    {
        return $this->hasMany(Aisle::class, 'created_by');
    }

    public function created_areas()
    {
        return $this->hasMany(Area::class, 'created_by');
    }

    public function created_locations()
    {
        return $this->hasMany(Location::class, 'created_by');
    }

    public function created_inventories()
    {
        return $this->hasMany(Inventory::class, 'created_by');
    }

    public function created_prices()
    {
        return $this->hasMany(Price::class, 'created_by');
    }

    public function created_exception_prices()
    {
        return $this->hasMany(ExceptionPrice::class, 'created_by');
    }

    public function created_tasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function created_allocated_tasks()
    {
        return $this->hasMany(AllocatedTask::class, 'created_by');
    }

    public function created_allocated_task_users()
    {
        return $this->hasMany(AllocatedTaskUser::class, 'created_by');
    }

    public function created_customers()
    {
        return $this->hasMany(Customer::class, 'created_by');
    }

    public function created_sales()
    {
        return $this->hasMany(Sale::class, 'created_by');
    }

    public function created_sale_items()
    {
        return $this->hasMany(SaleItem::class, 'created_by');
    }

    public function created_farm_details()
    {
        return $this->hasMany(FarmDetail::class, 'created_by');
    }


    /***************************************************
    
        Reverse Relationships (modified_by)
        
    ****************************************************/

    public function modified_users()
    {
        return $this->hasMany(User::class, 'modified_by');
    }

    public function modified_roles()
    {
        return $this->hasMany(Role::class, 'modified_by');
    }

    public function modified_users_roles()
    {
        return $this->hasMany(UsersRole::class, 'modified_by');
    }
    
    public function modified_pot_sizes()
    {
        return $this->hasMany(PotSize::class, 'modified_by');
    }

    public function modified_tree_types()
    {
        return $this->hasMany(TreeType::class, 'modified_by');
    }

    public function modified_trees()
    {
        return $this->hasMany(Tree::class, 'modified_by');
    }

    public function modified_blocks()
    {
        return $this->hasMany(Block::class, 'modified_by');
    }

    public function modified_aisles()
    {
        return $this->hasMany(Aisle::class, 'modified_by');
    }

    public function modified_areas()
    {
        return $this->hasMany(Area::class, 'modified_by');
    }

    public function modified_locations()
    {
        return $this->hasMany(Location::class, 'modified_by');
    }

    public function modified_inventories()
    {
        return $this->hasMany(Inventory::class, 'modified_by');
    }

    public function modified_prices()
    {
        return $this->hasMany(Price::class, 'modified_by');
    }

    public function modified_exception_prices()
    {
        return $this->hasMany(ExceptionPrice::class, 'modified_by');
    }

    public function modified_tasks()
    {
        return $this->hasMany(Task::class, 'modified_by');
    }

    public function modified_allocated_tasks()
    {
        return $this->hasMany(AllocatedTask::class, 'modified_by');
    }

    public function modified_allocated_task_users()
    {
        return $this->hasMany(AllocatedTaskUser::class, 'modified_by');
    }

    public function modified_customers()
    {
        return $this->hasMany(Customer::class, 'modified_by');
    }

    public function modified_sales()
    {
        return $this->hasMany(Sale::class, 'modified_by');
    }

    public function modified_sale_items()
    {
        return $this->hasMany(SaleItem::class, 'modified_by');
    }

    public function modified_farm_details()
    {
        return $this->hasMany(FarmDetail::class, 'modified_by');
    }

}

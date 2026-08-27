<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    
    /***************************************************
    
        Mass Assignment

    ****************************************************/
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'street_address_1',
        'street_address_2',
        'suburb',
        'postcode',
        'created_by',
        'modified_by'
    ];


    /***************************************************
    
        Relationships (One-to-Many)
        - Excluding created_by and modified_by

    ****************************************************/

    // A customer can have many sales
    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id');
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

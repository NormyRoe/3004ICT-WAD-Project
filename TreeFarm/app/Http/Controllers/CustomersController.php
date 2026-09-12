<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding Customers.

    ****************************************************/
    public function index()
    {
        // Get the customer from the database
        $customers = Customer::orderBy('last_name')->get();

        // Return the index view and pass it the two arrays
        return view('menu_top.customers.index', [
            'customers' => $customers,
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new Customers.

    ****************************************************/
    public function create()
    {
        //
    }


    /***************************************************

    store(Request $request)

    This function validates the new Customer and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        //
    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    Customer's details.

    ****************************************************/
    public function show($id)
    {
        //
    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Customer.

    ****************************************************/
    public function edit($id)
    {
        //
    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified Customer object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        //
    }


}

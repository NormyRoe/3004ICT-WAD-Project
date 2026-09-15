<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SalesController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding Sales.

    ****************************************************/
    public function index()
    {
        // Get the current sales from the database
        $current_sales = Sale::with(['customer', 'user'])
                                ->whereNotIn('status', ['Delivered', 'Cancelled'])
                                ->get()
                                ->sortBy([
                                    ['status', 'asc'],
                                    ['customer.last_name', 'asc'],
                                    ['customer.first_name', 'asc'],
                                ]);

        // Get the completed sales from the database
        $completed_sales = Sale::with(['customer', 'user'])
                                ->whereIn('status', ['Delivered', 'Cancelled'])
                                ->get()
                                ->sortBy([
                                    ['status', 'asc'],
                                    ['customer.last_name', 'asc'],
                                    ['customer.first_name', 'asc'],
                                ]);

        // Return the index view and pass it the array
        return view('menu_top.sales.index', [
            'current_sales' => $current_sales,
            'completed_sales' => $completed_sales,
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new Sales.

    ****************************************************/
    public function create()
    {
        //
    }


    /***************************************************

    store(Request $request)

    This function validates the new Sale and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        //
    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    Sale's details.

    ****************************************************/
    public function show($id)
    {
        //
    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Sale.

    ****************************************************/
    public function edit($id)
    {
        //
    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified Sale object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        //
    }

}

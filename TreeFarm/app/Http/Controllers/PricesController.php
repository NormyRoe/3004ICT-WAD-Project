<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\ExceptionPrice;
use App\Models\PotSize;
use App\Models\Tree;
use Illuminate\Http\Request;

class PricesController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding Prices.

    ****************************************************/
    public function index()
    {
        // Get the prices from the database
        $prices = Price::with('pot_size')->get();

        // Get the exception_prices from the database
        $exception_prices = ExceptionPrice::with('pot_size')->with('tree')->get();

        // Return the index view and pass it the arrays
        return view('admin.prices.index', [
            'prices' => $prices,
            'exception_prices' => $exception_prices,
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new Prices.

    ****************************************************/
    public function create()
    {
        //
    }


    /***************************************************

    store(Request $request)

    This function validates the new Price and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        //
    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Price.

    ****************************************************/
    public function edit($id)
    {
        //
    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified price object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        //
    }


    /***************************************************

    destroy($id)

    This function deletes the specified price object.

    ****************************************************/
    public function destroy($id)
    {
        //
    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the price object
                    

    }

}

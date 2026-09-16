<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\User;
use App\Models\Role;
use App\Models\UsersRole;
use App\Models\FarmDetail;
use App\Models\Price;
use App\Models\ExceptionPrice;
use App\Models\PotSize;
use App\Models\Tree;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        // Get all of the other current users
        $current_users = User::where('status', 'Approved')
                                ->orderBy('last_name')
                                ->orderBy('first_name')
                                ->get();

        // Take just the sales users out of current_users list
        $sales_users = $current_users->filter(function ($u) {
                                            return $u->hasAnyRole(['Owner', 'Sales Manager', 'Sales']);
                                        });

        // Get the customers from the database
        $customers = Customer::orderBy('last_name')->orderBy('first_name')->get();
        
        // Return the create view and pass it the arrays
        return view('menu_top.sales.create_form', [
            'sales_users' => $sales_users,
            'customers' => $customers,
        ]);

    }


    /***************************************************

    store(Request $request)

    This function validates the new Sale and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',

            'customer_id' => [
                'required',
                'exists:customers,id',

                // The combination of Date and Customer must be unique
                Rule::unique('sales')->where(function ($query) use ($request) {
                    return $query->whereDate('date', $request->date)
                                ->where('customer_id', $request->customer_id);
                }),
            ],

        ], [

            // Custom message for the uniqueness rule
            'customer_id.unique' => 'This Customer already has a sales record for this date.',

        ]);
        

        // Create the new validated Sales record and add it to the database
        $sale = Sale::create([
            'date' => $validated['date'],
            'user_id' => $validated['user_id'],
            'customer_id' => $validated['customer_id'],
            'status' => 'In Progress',
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the edit view and pass it a success message
        return redirect()->route('sales.edit', $sale->id)->with('success', 'The new Sales record has been successfully created.');

    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    Sale's details.

    ****************************************************/
    public function show($id)
    {
        // Get the sale object
        $sale = Sale::with('customer')->with('user')->findOrFail($id);

        // Get the sale items
        $sale_items = $sale->sale_items()->get();

        // Return the show view and pass it the sale object and sale items array
        return view('menu_top.sales.show', [
            'sale' => $sale,
            'sale_items' => $sale_items,
        ]);

    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Sale.

    ****************************************************/
    public function edit($id)
    {
        // Get the sale object
        $sale = Sale::with('customer')->with('user')->findOrFail($id);

        // Get the sale items
        $sale_items = $sale->sale_items()->get();

        // Get the prices
        $prices = Price::with('pot_size')->get();

        // Get the exception prices
        $exception_prices = ExceptionPrice::with('tree')->with('pot_size')->get();

        // Get the current inventory
        $inventories = Inventory::select('inventories.*')
                                    ->join('trees', 'inventories.tree_id', '=', 'trees.id')
                                    ->with([
                                        'tree',
                                        'pot_size',
                                    ])->orderBy('trees.common_name')->get();

        // Get the farm's details from the database
        $farm = FarmDetail::first();

        // Return the edit view and pass it the sale object and the arrays
        return view('menu_top.sales.edit_form', [
            'sale' => $sale,
            'sale_items' => $sale_items,
            'prices' => $prices,
            'exception_prices' => $exception_prices,
            'inventories' => $inventories,
            'farm' => $farm,
        ]);

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

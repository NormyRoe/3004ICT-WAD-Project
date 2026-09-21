<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Inventory;
use App\Models\Tree;
use App\Models\PotSize;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        // Return the create view
        return view('menu_top.customers.create_form');

    }


    /***************************************************

    store(Request $request)

    This function validates the new Customer and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',

            'surname' => [
                'required',
                'string',
                'max:50',

                // The combination of First Name, Surname and Company must be unique
                Rule::unique('customers')->where(function ($query) use ($request) {
                    return $query->where('first_name', $request->first_name)
                                ->where('last_name', $request->surname)
                                ->where('company', $request->company);
                }),

            ],

            'company' => 'nullable|string|max:150',
            'phone_number' => 'required|string|min:10|max:10',
            'email' => 'required|email|max:100',
            'street_address_1' => 'required|string|max:45',
            'street_address_2' => 'nullable|string|max:45',
            'suburb' => 'required|string|max:45',
            'postcode' => 'required|string|min:4|max:4',

        ], [

            // Custom message for the uniqueness rule
            'surname.unique' => 'This Customer already exists.',

        ]);

        // Create the new validated Customer and add it to the database
        $customer = Customer::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['surname'],
            'company' => $validated['company'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'street_address_1' => $validated['street_address_1'],
            'street_address_2' => $validated['street_address_2'],
            'suburb' => $validated['suburb'],
            'postcode' => $validated['postcode'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the show view to display the new Customer object and pass it a success message
        return redirect("customers/$customer->id")->with('success', 'The new Customer has been successfully added.');

    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    Customer's details.

    ****************************************************/
    public function show($id)
    {
        // Get the customer object
        $customer = Customer::findOrFail($id);

        // Return the show view and pass it the customer object
        return view('menu_top.customers.show', [
            'customer' => $customer
        ]);

    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Customer.

    ****************************************************/
    public function edit($id)
    {
        // Get the customer object
        $customer = Customer::findOrFail($id);

        // Return the edit view and pass it the customer object
        return view('menu_top.customers.edit_form', [
            'customer' => $customer,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified Customer object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the customer object
        $customer = Customer::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',

            'surname' => [
                'required',
                'string',
                'max:50',

                // The combination of First Name, Surname and Company must be unique
                Rule::unique('customers')
                        ->ignore($customer->id)
                        ->where(function ($query) use ($request) {
                            return $query->where('first_name', $request->first_name)
                                        ->where('last_name', $request->surname)
                                        ->where('company', $request->company);
                        }),

            ],

            'company' => 'nullable|string|max:150',
            'phone_number' => 'required|string|min:10|max:10',
            'email' => 'required|email|max:100',
            'street_address_1' => 'required|string|max:45',
            'street_address_2' => 'nullable|string|max:45',
            'suburb' => 'required|string|max:45',
            'postcode' => 'required|string|min:4|max:4',

        ], [

            // Custom message for the uniqueness rule
            'surname.unique' => 'This Customer already exists.',

        ]);

        // Update the validated Customer in the database
        $customer->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['surname'],
            'company' => $validated['company'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'street_address_1' => $validated['street_address_1'],
            'street_address_2' => $validated['street_address_2'],
            'suburb' => $validated['suburb'],
            'postcode' => $validated['postcode'],
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the show view to display the Customer object and pass it a success message
        return redirect("customers/$customer->id")->with('success', 'The Customer has been successfully updated.');
    }

    /***************************************************

    sales_history($id)

    This function displays the Customer's sales history.

    ****************************************************/
    public function sales_history($id)
    {
        // Get the customer object
        $customer = Customer::findOrFail($id);

        // Get the delivered sales for this customer
        $delivered_sales = $customer->sales()
                            ->where('status', 'Delivered')
                            ->with([
                                'sale_items',
                                'sale_items.inventory',
                                'sale_items.inventory.tree',
                                'sale_items.inventory.pot_size',
                            ])
                            ->orderBy('date', 'desc')
                            ->get();

        // Get all other sales for this customer
        $other_sales = $customer->sales()
                            ->where('status', '!=', 'Delivered')
                            ->with([
                                'sale_items',
                                'sale_items.inventory',
                                'sale_items.inventory.tree',
                                'sale_items.inventory.pot_size',
                            ])                            
                            ->orderBy('date', 'desc')
                            ->get();

        // Return the edit view and pass it the customer object
        return view('menu_top.customers.sales_history', [
            'customer' => $customer,
            'delivered_sales' => $delivered_sales,
            'other_sales' => $other_sales,
        ]);

    }


}

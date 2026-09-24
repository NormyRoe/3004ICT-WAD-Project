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
use App\Models\Location;
use App\Models\Area;
use App\Models\Task;
use App\Models\AllocatedTask;
use App\Models\AllocatedTasksUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

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

        // Create a cut off period of 6 months ago
        $cut_off = today()->subMonths(6);

        // Get the completed sales from the database
        $completed_sales = Sale::with(['customer', 'user'])
                                ->where('date', '>=', $cut_off)
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

        // If the status is Delivered or Cancelled
        if ($sale->status == 'Delivered' || $sale->status == 'Cancelled')
        {
            // Redirect to the show view
            return redirect()->route('sales.show', $sale->id);

        }

        // Get the sale items
        $sale_items = $sale->sale_items()->get();

        // Get the prices
        $prices = Price::with('pot_size')->get();

        // Get the exception prices
        $exception_prices = ExceptionPrice::with('tree')->with('pot_size')->get();

        // Get the current inventory
        $inventories = Inventory::select('inventories.*')
                                    ->join('trees', 'inventories.tree_id', '=', 'trees.id')
                                    ->join('locations', 'inventories.location_id', '=', 'locations.id')
                                    ->join('areas', 'locations.area_id', '=', 'areas.id')
                                    ->with([
                                        'tree',
                                        'pot_size',
                                    ])->where('areas.name', 'Selling')->orderBy('trees.common_name')->get();

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
        // Get the sale object
        $sale = Sale::with('customer')->findOrFail($id);

        // Wrap everything in a database transaction to prevent partial successes
        DB::transaction(function () use ($request, $sale) {

            // Validate the request
            $validated = $request->validate([
                'status' => 'required|string',
                'delivery_notes' => 'nullable|string|max:150',
                'delivery_kms' => 'required|numeric|min:0',
                'delivery_fee' => 'required|numeric|min:0',
                'discount' => 'nullable|numeric|min:0',
                'total_sales' => 'required|numeric|min:0',
                'items_json'     => 'required|string'

            ]);

            // Get the old and new statuses
            $old_status = $sale->status;
            $new_status = $request->status;

            // Decode the items_json array
            $items = json_decode($validated['items_json'], true);

            if (!is_array($items)) {
                throw new \Exception("Invalid sale items data.");
            }

            // Delete ALL existing sale_items for this sale
            $sale->sale_items()->delete();

            // Create ALL sale_items from items_json
            foreach ($items as $item) {

                // Get the inventory object
                $inventory = Inventory::with([
                                            'tree',
                                            'pot_size',
                                        ])->findOrFail($item['inventory_id']);

                // Create the Sale Item
                SaleItem::create([
                    'sales_id'     => $sale->id,
                    'inventory_id' => $item['inventory_id'],
                    'quantity'     => $item['quantity'],
                    'common_name'  => $inventory->tree->common_name,
                    'pot_size'     => $inventory->pot_size->size,
                    'unit_price'   => $item['unit_price'],
                    'discount'     => $item['discount'],
                    'total_price'  => $item['total_price'],
                    'created_by'   => auth()->id(),
                    'modified_by'  => auth()->id(),
                ]);

            }

            // If the status has gone straight from "In Progress" to "Delivered"
            if ($old_status === 'In Progress' && $new_status === 'Delivered')
            {
                // For each of the sale items
                foreach ($items as $item) {

                    // Get the inventory object
                    $inventory = Inventory::find($item['inventory_id']);

                    // Update the inventory's quantity
                    $inventory->quantity -= $item['quantity'];

                    // Save the inventory record
                    $inventory->save();

                    // Check if the inventory's quantity is now zero
                    if ($inventory->quantity === 0)
                    {
                        // Delete the inventory record
                        $inventory->delete();
                    }

                }

            }
            
            // Update the validated Sale record in the database
            $sale->update([
                'status' => $validated['status'],
                'delivery_notes' => $validated['delivery_notes'],
                'delivery_kms' => $validated['delivery_kms'],
                'delivery_fee' => $validated['delivery_fee'],
                'discount' => $validated['discount'],
                'total_sales_price' => $validated['total_sales'],
                'modified_by' => auth()->id(),
            ]);

            // If the status has gone to "Awaiting Delivery"
            if ($new_status === 'Awaiting Delivery')
            {
                // Get all of the current users
                $current_users = User::where('status', 'Approved')
                                        ->orderBy('last_name')
                                        ->orderBy('first_name')
                                        ->get();

                // Take just the field hands out of current_users list
                $field_hands = $current_users->filter(function ($u) {
                                                    return $u->hasRole('Field Hand');
                                                });

                // Get the 'Move' task type record
                $task_type = Task::where('name', 'Move')->first();

                // Get the delivery area location
                $delivery_location = Location::select('locations.*')
                                    ->join('areas', 'locations.area_id', '=', 'areas.id')
                                    ->where('areas.name', 'Delivery')
                                    ->first();

                // For each of the sale items
                foreach ($items as $item) {

                    // Get the inventory object
                    $inventory = Inventory::find($item['inventory_id']);

                    // Create a new 'Move' task and add it to the database
                    $new_task = AllocatedTask::create([
                        'date' => today(),
                        'task_id' => $task_type->id,
                        'notes' => "This tree is for {$sale->customer->first_name} {$sale->customer->last_name}.  Please move it to the delivery area",
                        'tree_id' => $inventory->tree_id,
                        'quantity' => $item['quantity'],
                        'location_1_id' => $inventory->location_id,
                        'location_2_id' => $delivery_location->id,
                        'current_pot_size_id' => $inventory->pot_size_id,
                        'new_pot_size_id' => null,
                        'done' => 0,
                        'allocated' => 1,
                        'created_by' => auth()->id(),
                        'modified_by' => auth()->id(),
                    ]);

                    // For loop through the field hands list of users
                    foreach ($field_hands as $user)
                    {
                        // Create the Allocated Tasks User records
                        AllocatedTasksUser::create([
                            'allocated_task_id' => $new_task->id,
                            'user_id' => $user->id,
                            'created_by' => auth()->id(),
                            'modified_by' => auth()->id(),
                        ]);
                                
                    }

                }

            }

            // If the status has gone from "Awaiting Delivery" to "Delivered"
            if ($old_status === 'Awaiting Delivery' && $new_status === 'Delivered')
            {
                // Get the delivery area location
                $delivery_location = Location::select('locations.*')
                                    ->join('areas', 'locations.area_id', '=', 'areas.id')
                                    ->where('areas.name', 'Delivery')
                                    ->first();

                // For each of the sale items
                foreach ($items as $item) {

                    // Get the sale inventory object
                    $sale_inventory = Inventory::find($item['inventory_id']);

                    // Get the delivery inventory record from the delivery area
                    $delivery_inventory = Inventory::with('location')
                                            ->where('tree_id', $sale_inventory->tree_id)
                                            ->where('location_id', $delivery_location->id)
                                            ->where('pot_size_id', $sale_inventory->pot_size_id)
                                            ->first();

                    // If the delivery record doesn't exist
                    if (!$delivery_inventory) {
                        throw new \Exception("Invalid: The Inventory record does not exist in the Delivery location.");
                    }

                    // Update the inventory's quantity
                    $delivery_inventory->quantity -= $item['quantity'];

                    // Save the inventory record
                    $delivery_inventory->save();

                    // Check if the delivery inventory's quantity is now zero
                    if ($delivery_inventory->quantity === 0)
                    {
                        // Delete the delivery inventory record
                        $delivery_inventory->delete();
                    }

                }

            }

        });

        // If the status is Delivered or Cancelled
        if ($sale->status == 'Delivered' || $sale->status == 'Cancelled')
        {
            // Redirect to the show view and and pass it a success message
            return redirect()->route('sales.show', $sale->id)->with('success', 'The Sales record has been successfully updated.');

        }

        // Redirect to the edit view and pass it a success message
        return redirect()->route('sales.edit', $sale->id)->with('success', 'The Sales record has been successfully updated.');

    }


    /***************************************************

    calcKms(Request $request)

    This function calculates the driving distance between 
    the farm's address and the customer's address.

    ****************************************************/
    public function calcKms(Request $request)
    {
        // Validate the request
        $request->validate([
            'farm_address' => 'required|string',
            'customer_address' => 'required|string',
        ]);

        $farmAddress = $request->farm_address;
        $customerAddress = $request->customer_address;

        /***************************************************
        *  Griffith Proxy Configuration
        ***************************************************/
        $proxyOptions = [
            'proxy' => [
                'https' => 'http://s3proxy.itc.griffith.edu.au:3128',
                'http'  => 'http://s3proxy.itc.griffith.edu.au:3128',
                'no'    => ['127.0.0.1', 'localhost', '.griffith.edu.au'],
            ]
        ];
        
        // Try block for getting the coordinates for the addresses
        try
        {
            // -----------------------------------------------
            // 1. Geocode farm address
            // -----------------------------------------------
            $farmGeo = Http::withOptions($proxyOptions)
                    ->withHeaders([
                        'Accept' => 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8'
                    ])->timeout(10)->get('https://api.heigit.org/pelias/v1/search', [
                        'api_key' => env('ORS_API_KEY'),
                        'text' => $farmAddress,
                        'layers' => 'address'
                    ]);

            $farmData = $farmGeo->json();
            $farmCoords = $farmData['features'][0]['geometry']['coordinates'] ?? null;

            if (!$farmCoords) {
                return response()->json(['error' => 'Unable to geocode farm address'], 422);
            }

            // -----------------------------------------------
            // 2. Geocode customer address
            // -----------------------------------------------
            $custGeo = Http::withOptions($proxyOptions)
                    ->withHeaders([
                        'Accept' => 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8'
                    ])->timeout(10)->get('https://api.heigit.org/pelias/v1/search', [
                        'api_key' => env('ORS_API_KEY'),
                        'text' => $customerAddress,
                        'layers' => 'address'
                    ]);

            $custData = $custGeo->json();
            $custCoords = $custData['features'][0]['geometry']['coordinates'] ?? null;

            if (!$custCoords) {
                return response()->json(['error' => 'Unable to geocode customer address'], 422);
            }

        } 
        catch (ConnectionException $e) 
        {
            return response()->json([
                'error' => 'Unable to contact routing service (timeout).',
            ], 503);
        }        

        // -----------------------------------------------
        // 3. Compute driving distance
        // -----------------------------------------------
        $response = Http::withOptions($proxyOptions)
                    ->withHeaders([
                        'Accept' => 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8'
                    ])->timeout(10)->post(
                        'https://api.heigit.org/openrouteservice/v2/directions/driving-car?api_key=' . env('ORS_API_KEY'),
                        [
                            'coordinates' => [
                                [$farmCoords[0], $farmCoords[1]],
                                [$custCoords[0], $custCoords[1]]
                            ]
                        ]
                );

        if (!$response->successful()) {
            return response()->json(['error' => 'Routing API failed'], 500);
        }

        $data = $response->json();
        $meters = $data['routes'][0]['summary']['distance'] ?? null;

        if (!$meters) {
            return response()->json(['error' => 'Unable to calculate distance'], 422);
        }

        $kms = round($meters / 1000, 2);

        return response()->json(['kms' => $kms]);

    }


}

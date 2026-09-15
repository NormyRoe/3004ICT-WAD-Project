<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Tree;
use App\Models\TreeType;
use App\Models\PotSize;
use App\Models\Location;
use App\Models\Area;
use App\Models\Block;
use App\Models\Aisle;
use Illuminate\Http\Request;

class InventoriesController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding Inventories.

    ****************************************************/
    public function index()
    {
        // Get the inventories from the database
        $inventories = Inventory::select('inventories.*')
                                    ->join('trees', 'inventories.tree_id', '=', 'trees.id')
                                    ->with([
                                        'tree',
                                        'tree.tree_type',
                                        'pot_size',
                                        'location.area',
                                        'location.block',
                                        'location.aisle',
                                    ])->orderBy('trees.common_name')->get();

        // Return the index view and pass it the array
        return view('menu_top.inventories.index', [
            'inventories' => $inventories,
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new Inventories.

    ****************************************************/
    public function create()
    {
        // Get the trees from the database
        $trees = Tree::orderBy('plant_id')->get();

        // Get the pot sizes from the database
        $pot_sizes = PotSize::orderBy('size')->get();

        // Get the areas from the database
        $areas = Area::orderBy('name')->get();

        // Get the blocks from the database
        $blocks = Block::orderBy('name')->get();

        // Get the aisles from the database
        $aisles = Aisle::orderBy('name')->get();
        
        // Return the create_form view and pass it the arrays
        return view('menu_top.inventories.create_form', [
            'trees' => $trees,
            'pot_sizes' => $pot_sizes,
            'areas' => $areas,
            'blocks' => $blocks,
            'aisles' => $aisles,
        ]);

    }


    /***************************************************

    store(Request $request)

    This function validates the new Inventory and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([

            'plant_id' => 'required|exists:trees,id',
            'pot_size_id' => 'required|exists:pot_sizes,id',
            'area_id' => 'required|exists:areas,id',
            'block_id' => 'nullable|exists:blocks,id',
            'aisle_id' => 'nullable|exists:aisles,id',
            'quantity' => 'required|numeric|min:0',
            
        ]);

        // Grab the location record
        $location = Location::where('area_id', $validated['area_id'])
                            ->where('block_id', $validated['block_id'])
                            ->where('aisle_id', $validated['aisle_id'])
                            ->first();
        
        // If the location doesn't exist
        if (!$location)
        {
            // Return back to the create page with errors
            return back()
                    ->withErrors(['area_id' => 'This Location does not exist in the Locations table.'])
                    ->withInput();

        }

        // Find out if an existing inventory record exists
        $exists = Inventory::where('tree_id', $validated['plant_id'])
                            ->where('pot_size_id', $validated['pot_size_id'])
                            ->where('location_id', $location->id)
                            ->exists();

        // If there is an existing Inventory reocrd
        if ($exists)
        {
            // Return back to the create page with errors
            return back()
                    ->withErrors(['plant_id' => 'An Inventory record already exists for this Tree, Pot Size and Location combination.'])
                    ->withInput();

        }

        // Create the new validated Inventory and add it to the database
        $inventory = Inventory::create([
            'tree_id' => $validated['plant_id'],
            'pot_size_id' => $validated['pot_size_id'],
            'location_id' => $location->id,
            'quantity' => $validated['quantity'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the show view to display the new Inventory object and pass it a success message
        return redirect("inventories/$inventory->id")->with('success', 'The new Inventory has been successfully added.');

    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    Inventory's details.

    ****************************************************/
    public function show($id)
    {
        // Get the inventory object
        $inventory = Inventory::with([
                                    'tree',
                                    'tree.tree_type',
                                    'pot_size',
                                    'location.area',
                                    'location.block',
                                    'location.aisle',
                                ])->findOrFail($id);

        // Return the show view and pass it inventory object
        return view('menu_top.inventories.show', [
            'inventory' => $inventory,
        ]);
    }


    /***************************************************

    edit($id)

    This function displays the form for updating an Inventory.

    ****************************************************/
    public function edit($id)
    {
        // Get the inventory object
        $inventory = Inventory::with([
                                    'tree',
                                    'pot_size',
                                    'location',
                                ])->findOrFail($id);

        // Get the areas from the database
        $areas = Area::orderBy('name')->get();

        // Get the blocks from the database
        $blocks = Block::orderBy('name')->get();

        // Get the aisles from the database
        $aisles = Aisle::orderBy('name')->get();
        
        // Return the edit_form view and pass it the arrays
        return view('menu_top.inventories.edit_form', [
            'inventory' => $inventory,
            'areas' => $areas,
            'blocks' => $blocks,
            'aisles' => $aisles,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified Inventory object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the inventory object
        $inventory = Inventory::findOrFail($id);

        // Validate the request
        $validated = $request->validate([

            'area_id' => 'required|exists:areas,id',
            'block_id' => 'nullable|exists:blocks,id',
            'aisle_id' => 'nullable|exists:aisles,id',
            'quantity' => 'required|numeric|min:0',
            
        ]);

        // Grab the location record
        $location = Location::where('area_id', $validated['area_id'])
                            ->where('block_id', $validated['block_id'])
                            ->where('aisle_id', $validated['aisle_id'])
                            ->first();
        
        // If the location doesn't exist
        if (!$location)
        {
            // Return back to the edit page with errors
            return back()
                    ->withErrors(['area_id' => 'This Location does not exist in the Locations table.'])
                    ->withInput();

        }

        // Find out if a duplicate inventory record exists
        $exists = Inventory::where('tree_id', $inventory->tree_id)
                            ->where('pot_size_id', $inventory->pot_size_id)
                            ->where('location_id', $location->id)
                            ->where('id', '!=', $inventory->id)
                            ->exists();

        // If there is an existing Inventory reocrd
        if ($exists)
        {
            // Return back to the edit page with errors
            return back()
                    ->withErrors(['area_id' => 'An Inventory record already exists for this Tree, Pot Size and Location combination.'])
                    ->withInput();

        }

        // Update the validated Inventory in the database
        $inventory->update([
            'location_id' => $location->id,
            'quantity' => $validated['quantity'],
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the show view to display the new Inventory object and pass it a success message
        return redirect("inventories/$inventory->id")->with('success', 'The Inventory has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified inventory object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the inventory object
        $inventory = Inventory::findOrFail($id);

        // Delete the inventory object
        $inventory->delete();

        // Return to the index view and pass it a success message
        return redirect('inventories')->with('success', 'The Inventory has been successfully deleted.');

    }

    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the inventory object
        $inventory = Inventory::with([
                                    'tree',
                                    'location.area',
                                    'location.block',
                                    'location.aisle',
                                ])->findOrFail($id);

        // Return the confirm_delete view and pass it the inventory object
        return view('menu_top.inventories.confirm_delete', [
            'inventory' => $inventory,
        ]);
        
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Tree;
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
        //
    }


    /***************************************************

    store(Request $request)

    This function validates the new Inventory and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        //
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
        //
    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified Inventory object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        //
    }


    /***************************************************

    destroy($id)

    This function deletes the specified inventory object.

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
        // Get the inventory object
        $inventory = Inventory::findOrFail($id);

        // Return the confirm_delete view and pass it the inventory object
        return view('menu_top.inventories.confirm_delete', [
            'inventory' => $inventory,
        ]);
        
    }

}

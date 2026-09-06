<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Area;
use App\Models\Block;
use App\Models\Aisle;
use Illuminate\Http\Request;

class LocationsController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding Locations.

    ****************************************************/
    public function index()
    {
        // Get the areas from the database
        $areas = Area::get();

        // Get the blocks from the database
        $blocks = Block::get();

        // Get the aisles from the database
        $aisles = Aisle::get();

        // Get the locations from the database
        $locations = Location::with('area')->with('block')->with('aisle')->get();

        // Return the index view and pass it the arrays
        return view('admin.locations.index', [
            'areas' => $areas,
            'blocks' => $blocks,
            'aisles' => $aisles,
            'locations' => $locations
        ]);
        
    }


    /***************************************************

    create()

    This function displays the form for creating new Locations.

    ****************************************************/
    public function create()
    {
        //
    }


    /***************************************************

    store(Request $request)

    This function validates the new Location and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        //
    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Location.

    ****************************************************/
    public function edit($id)
    {
        //
    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified location object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        //
    }


    /***************************************************

    destroy($id)

    This function deletes the specified location object.

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
        // Get the tree object
              

    }

}

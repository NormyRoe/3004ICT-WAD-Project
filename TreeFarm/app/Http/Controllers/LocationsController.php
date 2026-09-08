<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Area;
use App\Models\Block;
use App\Models\Aisle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        // Get the areas from the database
        $areas = Area::get();

        // Get the blocks from the database
        $blocks = Block::get();

        // Get the aisles from the database
        $aisles = Aisle::get();

        // Return the create_form view and pass it the arrays
        return view('admin.locations.create_form', [
            'areas' => $areas,
            'blocks' => $blocks,
            'aisles' => $aisles
        ]);
    }


    /***************************************************

    store(Request $request)

    This function validates the new Location and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'area_id' => [
                'required',
                'exists:areas,id',

                // Multi-column uniqueness rule (must be attached to a field)
                Rule::unique('locations')->where(function ($query) use ($request) {
                    return $query->where('area_id', $request->area_id)
                                ->where('block_id', $request->block_id)
                                ->where('aisle_id', $request->aisle_id);
                }),

            ],

            'block_id' => 'nullable|exists:blocks,id',
            'aisle_id' => 'nullable|exists:aisles,id',
            
        ], [

            // Custom message for the multi-column uniqueness rule
            'area_id.unique' => 'This combination of Area, Block and Aisle already exists.',

        ]);

        // Create the new validated Location and add it to the database
        Location::create([
            'area_id' => $validated['area_id'],
            'block_id' => $validated['block_id'],
            'aisle_id' => $validated['aisle_id'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The new Location has been successfully added.');

    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Location.

    ****************************************************/
    public function edit($id)
    {
        // Get the location object
        $location = Location::findOrFail($id);

        // Get the areas from the database
        $areas = Area::get();

        // Get the blocks from the database
        $blocks = Block::get();

        // Get the aisles from the database
        $aisles = Aisle::get();

        // Return the edit view and pass it the location object and 
        // the other arrays
        return view('admin.locations.edit_form', [
            'location' => $location,
            'areas' => $areas,
            'blocks' => $blocks,
            'aisles' => $aisles
        ]);
    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified location object.

    ****************************************************/
    public function update(Request $request, $id)
    {

        // Get the location object
        $location = Location::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'area_id' => [
                'required',
                'exists:areas,id',

                // Multi-column uniqueness rule (must be attached to a field)
                Rule::unique('locations')
                        ->ignore($location->id)
                        ->where(function ($query) use ($request) {
                            return $query->where('area_id', $request->area_id)
                                        ->where('block_id', $request->block_id)
                                        ->where('aisle_id', $request->aisle_id);
                        }),

            ],

            'block_id' => 'nullable|exists:blocks,id',
            'aisle_id' => 'nullable|exists:aisles,id',
            
        ], [

            // Custom message for the multi-column uniqueness rule
            'area_id.unique' => 'This combination of Area, Block and Aisle already exists.',

        ]);

        // Update the validated Location in the database
        $location->update([
            'area_id' => $validated['area_id'],
            'block_id' => $validated['block_id'],
            'aisle_id' => $validated['aisle_id'],
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The Location has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified location object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the location object
        $location = Location::findOrFail($id);

        // Delete the location object
        $location->delete();

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The Location has been successfully deleted.');

    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the location object
        $location = Location::with('area')->with('block')->with('aisle')->findOrFail($id);

        // Return the confirm_delete view and pass it the location object
        return view('admin.locations.confirm_delete', [
            'location' => $location,
        ]);              

    }

}

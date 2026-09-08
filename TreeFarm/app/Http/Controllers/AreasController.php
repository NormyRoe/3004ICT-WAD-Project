<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreasController extends Controller
{

    /***************************************************

    create()

    This function displays the form for creating new Areas.

    ****************************************************/
    public function create()
    {
        // Return the create_form view
        return view('admin.areas.create_form');

    }


    /***************************************************

    store(Request $request)

    This function validates the new Area and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'area' => 'required|string|max:45|unique:areas,name',
        ]);

        // Create the new validated Area and add it to the database
        Area::create([
            'name' => $validated['area'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The new Area has been successfully added.');

    }


    /***************************************************

    edit($id)

    This function displays the form for updating an Area.

    ****************************************************/
    public function edit($id)
    {
        // Get the area object
        $area = Area::findOrFail($id);

        // Return the edit view and pass it the area object
        return view('admin.areas.edit_form', [
            'area' => $area,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified area object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the area object
        $area = Area::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'area' => 'required|string|max:45|unique:areas,name,' . $area->id,
        ]);        

        // Update the validated Area in the database
        $area->update([
            'name' => $validated['area'],
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The Area has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified area object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the area object
        $area = Area::findOrFail($id);

        // Delete the area object
        $area->delete();

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The Area has been successfully deleted.');

    }

    
    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the area object
        $area = Area::findOrFail($id);

        // Return the confirm_delete view and pass it the area object
        return view('admin.areas.confirm_delete', [
            'area' => $area,
        ]);
        
    }

}

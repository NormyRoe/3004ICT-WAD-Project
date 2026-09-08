<?php

namespace App\Http\Controllers;

use App\Models\Aisle;
use Illuminate\Http\Request;

class AislesController extends Controller
{

    /***************************************************

    create()

    This function displays the form for creating new Aisles.

    ****************************************************/
    public function create()
    {
        // Return the create_form view
        return view('admin.aisles.create_form');

    }


    /***************************************************

    store(Request $request)

    This function validates the new Aisle and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'aisle' => 'required|integer|min:0|unique:aisles,name',
        ]);

        // Create the new validated Aisle and add it to the database
        Aisle::create([
            'name' => $validated['aisle'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The new Aisle has been successfully added.');

    }


    /***************************************************

    edit($id)

    This function displays the form for updating an Aisle.

    ****************************************************/
    public function edit($id)
    {
        // Get the aisle object
        $aisle = Aisle::findOrFail($id);

        // Return the edit view and pass it the aisle object
        return view('admin.aisles.edit_form', [
            'aisle' => $aisle,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified aisle object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the aisle object
        $aisle = Aisle::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'aisle' => 'required|integer|min:0|unique:aisles,name,' . $aisle->id,
        ]);        

        // Update the validated Aisle in the database
        $aisle->update([
            'name' => $validated['aisle'],
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The Aisle has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified aisle object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the aisle object
        $aisle = Aisle::findOrFail($id);

        // Delete the aisle object
        $aisle->delete();

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The Aisle has been successfully deleted.');

    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the aisle object
        $aisle = Aisle::findOrFail($id);

        // Return the confirm_delete view and pass it the aisle object
        return view('admin.aisles.confirm_delete', [
            'aisle' => $aisle,
        ]);              

    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\FarmDetail;
use Illuminate\Http\Request;

class FarmDetailsController extends Controller
{
    /***************************************************

    index()

    This function displays the Farm's current details 
    and provides a form for updating them.

    ****************************************************/
    public function index()
    {
        // Get the farm's details from the database
        $farm = FarmDetail::first();

        // Return the index view and pass it the Farm_Detail object
        return view('admin.farm_details.index', [
            'name' => session('name'),
            'farm' => $farm,
        ]);
    }

    

    /***************************************************

    update(Request $request, $id)

    This function updates the farm's details.

    ****************************************************/
    public function update(Request $request, $id)
    {
        
        // Get the farm_detail object
        $farm_Detail = FarmDetail::findOrFail($id);

        // Initialise an array to hold the fields containing updates
        $updates = [];        

        // If name is filled in
        if ($request->filled('name'))
        {
            // Add name to the updates array
            $updates['name'] = $request->input('name');
        }

        // If street_address_1 is filled in
        if ($request->filled('street_address_1'))
        {
            // Add street_address_1 to the updates array
            $updates['street_address_1'] = $request->input('street_address_1');

            // Add street_address_2 to the updates array
            // This ensures that if the user empties street_address_2, 
            // we can still update it in the database
            $updates['street_address_2'] = $request->input('street_address_2');
        }

        // If suburb is filled in
        if ($request->filled('suburb'))
        {
            // Add suburb to the updates array
            $updates['suburb'] = $request->input('suburb');
        }

        // If postcode is filled in
        if ($request->filled('postcode'))
        {
            // Add postcode to the updates array
            $updates['postcode'] = $request->input('postcode');
        }

        // Check if the updates array contains entries
        if (!empty($updates))
        {
            // Update the database
            $farm_Detail->update($updates);
        }

        // Return to the index page and display a success message
        return redirect()->route("farm_details.index")
                ->with("success", "Farm details have been updated successfully");

    }

    /***************************************************

    update_logo(Request $request, $id)

    This function updates the farm's logo.

    ****************************************************/
    public function update_logo(Request $request, $id)
    {
        // Validate the uploaded file
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,jpg|max:2048',
        ]);

        // Get the uploaded file
        $file = $request->file('logo');

        // Move the file (overwrite existing)
        // The second parameter is what the filename will be changed to so 
        // that it is overwriting the existing file
        $file->move(public_path('images'), 'Logo.jpg');

        // Return to the index page and display a success message
        return redirect()
            ->route('farm_details.index')
            ->with('success', 'The Logo has been updated successfully.');
    }



}

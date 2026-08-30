<?php

namespace App\Http\Controllers;

use App\Models\PotSize;
use Illuminate\Http\Request;

class PotSizesController extends Controller
{
    /***************************************************

    index()

    This function displays the information regarding Pots.

    ****************************************************/
    public function index()
    {
        // Get the pot details from the database
        $pot_sizes = PotSize::get();

        // Return the index view and pass it the pot_sizes array
        return view('admin.pots.index', [
            'name' => session('name'),
            'pot_sizes' => $pot_sizes,
        ]);
    }


    /***************************************************

    create()

    This function displays the form for creating new Pot Sizes.

    ****************************************************/
    public function create()
    {
        // Return the create_form view
        return view('admin.pots.create_form', [
            'name' => session('name'),
        ]);

    }


    /***************************************************

    store(Request $request)

    This function validates the new Pot Size and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'size' => 'required|string|max:10|unique:pot_sizes,size',
        ]);

        // Create the new validated Pot Size and add it to the database
        PotSize::create([
            'size' => $validated['size'],
            'created_by' => null,
            'modified_by' => null,
        ]);

        // Return to the index view and pass it a success message
        return redirect('pot_sizes')->with('success', 'The new Pot Size has been successfully added.');

    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Pot Size.

    ****************************************************/
    public function edit($id)
    {
        // Get the pot_size object
        $pot_size = PotSize::findOrFail($id);

        // Return the edit view and pass it the pot_size object
        return view('admin.pots.edit_form', [
            'name' => session('name'),
            'pot_size' => $pot_size,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified pot_size object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the pot_size object
        $pot_size = PotSize::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'size' => 'required|string|max:10|unique:pot_sizes,size,' . $pot_size->id,
        ]);        

        // Update the validated Pot Size in the database
        $pot_size->update([
            'size' => $validated['size'],
            'modified_by' => null,
        ]);

        // Return to the index view and pass it a success message
        return redirect('pot_sizes')->with('success', 'The Pot Size has been successfully updated.');
    }


    /***************************************************

    destroy($id)

    This function deletes the specified pot_size object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the pot_size object
        $pot_size = PotSize::findOrFail($id);

        // Delete the pot_size object
        $pot_size->delete();

        // Return to the index view and pass it a success message
        return redirect('pot_sizes')->with('success', 'The Pot Size has been successfully deleted.');
    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the pot_size object
        $pot_size = PotSize::findOrFail($id);

        // Return the confirm_delete view and pass it the pot_size object
        return view('admin.pots.confirm_delete', [
            'name' => session('name'),
            'pot_size' => $pot_size,
        ]);

    }


    /***************************************************

    list_json()

    This function returns the current Pot Sizes data.

    ****************************************************/
    public function list_json()
    {
        // Return the current data from the database
        return PotSize::select('id', 'size')->orderBy('id')->get();

    }

}

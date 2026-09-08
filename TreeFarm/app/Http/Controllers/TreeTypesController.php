<?php

namespace App\Http\Controllers;

use App\Models\TreeType;
use Illuminate\Http\Request;

class TreeTypesController extends Controller
{
    
    /***************************************************

    create()

    This function displays the form for creating new Tree Types.

    ****************************************************/
    public function create()
    {
        // Return the create_form view
        return view('admin.tree_types.create_form');
    }


    /***************************************************

    store(Request $request)

    This function validates the new Tree Type and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'type' => 'required|string|max:45|unique:tree_types,name',
        ]);

        // Create the new validated Tree Types and add it to the database
        TreeType::create([
            'name' => $validated['type'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('trees')->with('success', 'The new Tree Type has been successfully added.');
    }


    /***************************************************

    edit($id)

    This function displays the form for editing a Tree Type.

    ****************************************************/
    public function edit($id)
    {
        // Get the tree_type object
        $tree_type = TreeType::findOrFail($id);

        // Return the edit view and pass it the tree_type object
        return view('admin.tree_types.edit_form', [
            'tree_type' => $tree_type,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified tree_type object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the tree_type object
        $tree_type = TreeType::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'type' => 'required|string|max:45|unique:tree_types,name,' . $tree_type->id,
        ]);        

        // Update the validated Tree Type in the database
        $tree_type->update([
            'name' => $validated['type'],
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('trees')->with('success', 'The Tree Type has been successfully updated.');
    }


    /***************************************************

    destroy($id)

    This function deletes the specified tree_type object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the tree_type object
        $tree_type = TreeType::findOrFail($id);

        // Delete the tree_type object
        $tree_type->delete();

        // Return to the index view and pass it a success message
        return redirect('trees')->with('success', 'The Tree Type has been successfully deleted.');
    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the tree_type object
        $tree_type = TreeType::findOrFail($id);

        // Return the confirm_delete view and pass it the tree_type object
        return view('admin.tree_types.confirm_delete', [
            'tree_type' => $tree_type,
        ]);

    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Tree;
use App\Models\TreeType;
use Illuminate\Http\Request;

class TreesController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding Trees.

    ****************************************************/
    public function index()
    {
        // Get the tree types from the database
        $tree_types = TreeType::get();

        // Get the trees from the database
        $trees = Tree::with('tree_type')->get();

        // Return the index view and pass it the two arrays
        return view('admin.trees.index', [
            'tree_types' => $tree_types,
            'trees' => $trees
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new Trees.

    ****************************************************/
    public function create()
    {
        // Get the tree types from the database
        $tree_types = TreeType::orderBy('name')->get();

        // Return the create view and pass it the tree_types array
        return view('admin.trees.create_form', [
            'tree_types' => $tree_types
        ]);

    }


    /***************************************************

    store(Request $request)

    This function validates the new Tree and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'plant_id' => 'required|string|max:5',
            'tree_type_id' => 'required|exists:tree_types,id',
            'botanical_name' => 'required|string|max:150|unique:trees,botanical_name',
            'common_name' => 'required|string|max:100|unique:trees,common_name',
            'height_min' => 'nullable|numeric|min:0',
            'height_max' => 'required|numeric|min:0',
            'width_min' => 'nullable|numeric|min:0',
            'width_max' => 'required|numeric|min:0',
        ]);

        // Create the new validated Tree and add it to the database
        $tree = Tree::create([
            'plant_id' => $validated['plant_id'],
            'tree_type_id' => $validated['tree_type_id'],
            'botanical_name' => $validated['botanical_name'],
            'common_name' => $validated['common_name'],
            'mature_height_min' => $validated['height_min'],
            'mature_height_max' => $validated['height_max'],
            'mature_width_min' => $validated['width_min'],
            'mature_width_max' => $validated['width_max'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the show view to display the new Tree object and pass it a success message
        return redirect("trees/$tree->id")->with('success', 'The new Tree has been successfully added.');

    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    Tree's details.

    ****************************************************/
    public function show($id)
    {
        // Get the tree object
        $tree = Tree::with('tree_type')->findOrFail($id);

        // Return the show view and pass it the tree object
        return view('admin.trees.show', [
            'tree' => $tree
        ]);

    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Tree.

    ****************************************************/
    public function edit($id)
    {
        // Get the tree object
        $tree = Tree::findOrFail($id);

        // Get the tree types from the database
        $tree_types = TreeType::orderBy('name')->get();

        // Return the edit view and pass it the tree object and 
        // the tree_types array
        return view('admin.trees.edit_form', [
            'tree' => $tree,
            'tree_types' => $tree_types
        ]);
    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified tree object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the tree object
        $tree = Tree::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'plant_id' => 'required|string|max:5',
            'tree_type_id' => 'required|exists:tree_types,id',
            'botanical_name' => 'required|string|max:150|unique:trees,botanical_name,' . $tree->id,
            'common_name' => 'required|string|max:100|unique:trees,common_name,' . $tree->id,
            'height_min' => 'nullable|numeric|min:0',
            'height_max' => 'required|numeric|min:0',
            'width_min' => 'nullable|numeric|min:0',
            'width_max' => 'required|numeric|min:0',
        ]);

        // Update the validated Tree in the database
        $tree->update([
            'plant_id' => $validated['plant_id'],
            'tree_type_id' => $validated['tree_type_id'],
            'botanical_name' => $validated['botanical_name'],
            'common_name' => $validated['common_name'],
            'mature_height_min' => $validated['height_min'],
            'mature_height_max' => $validated['height_max'],
            'mature_width_min' => $validated['width_min'],
            'mature_width_max' => $validated['width_max'],
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the show view to display the updated Tree object and pass it a success message
        return redirect("trees/$tree->id")->with('success', 'The Tree has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified tree object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the tree object
        $tree = Tree::findOrFail($id);

        // Delete the tree object
        $tree->delete();

        // Return to the index view and pass it a success message
        return redirect('trees')->with('success', 'The Tree has been successfully deleted.');
    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the tree object
        $tree = Tree::findOrFail($id);

        // Return the confirm_delete view and pass it the tree object
        return view('admin.trees.confirm_delete', [
            'tree' => $tree,
        ]);
        
    }


}

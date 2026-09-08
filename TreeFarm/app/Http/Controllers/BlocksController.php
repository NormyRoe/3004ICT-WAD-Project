<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class BlocksController extends Controller
{

    /***************************************************

    create()

    This function displays the form for creating new Blocks.

    ****************************************************/
    public function create()
    {
        // Return the create_form view
        return view('admin.blocks.create_form');

    }


    /***************************************************

    store(Request $request)

    This function validates the new Block and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'block' => 'required|string|max:45|unique:blocks,name',
        ]);

        // Create the new validated Block and add it to the database
        Block::create([
            'name' => $validated['block'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The new Block has been successfully added.');

    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Block.

    ****************************************************/
    public function edit($id)
    {
        // Get the block object
        $block = Block::findOrFail($id);

        // Return the edit view and pass it the block object
        return view('admin.blocks.edit_form', [
            'block' => $block,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified block object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the block object
        $block = Block::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'block' => 'required|string|max:45|unique:blocks,name,' . $block->id,
        ]);        

        // Update the validated Block in the database
        $block->update([
            'name' => $validated['block'],
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The Block has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified block object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the block object
        $block = Block::findOrFail($id);

        // Delete the block object
        $block->delete();

        // Return to the index view and pass it a success message
        return redirect('locations')->with('success', 'The Block has been successfully deleted.');

    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the block object
        $block = Block::findOrFail($id);

        // Return the confirm_delete view and pass it the block object
        return view('admin.blocks.confirm_delete', [
            'block' => $block,
        ]);              

    }
    
}

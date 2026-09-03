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
            'name' => session('name'),
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
        //
    }


    /***************************************************

    store(Request $request)

    This function validates the new Tree and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        //
    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    Tree's details.

    ****************************************************/
    public function show($id)
    {
        //
    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Tree.

    ****************************************************/
    public function edit($id)
    {
        //
    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified tree object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        //
    }


    /***************************************************

    destroy($id)

    This function deletes the specified tree object.

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

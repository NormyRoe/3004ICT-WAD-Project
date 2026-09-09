<?php

namespace App\Http\Controllers;

use App\Models\ExceptionPrice;
use App\Models\PotSize;
use App\Models\Tree;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExceptionPricesController extends Controller
{

    /***************************************************

    create()

    This function displays the form for creating new 
    Exception Prices.

    ****************************************************/
    public function create()
    {
        // Get the pot_sizes from the database
        $pot_sizes = PotSize::orderBy('size')->get();

        // Get the trees from the database
        $trees = Tree::orderBy('common_name')->get();

        // Return the create_form view and pass it the arrays
        return view('admin.exception_prices.create_form', [
            'pot_sizes' => $pot_sizes,
            'trees' => $trees,
        ]);

    }


    /***************************************************

    store(Request $request)

    This function validates the new Exception Price and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'tree_id' => 'required|exists:trees,id',

            'pot_size_id' => [
                'required',
                'exists:pot_sizes,id',

                // The combination of Tree and Pot Size must be unique
                Rule::unique('exception_prices')->where(function ($query) use ($request) {
                    return $query->where('tree_id', $request->tree_id)
                                ->where('pot_size_id', $request->pot_size_id);
                }),

            ],

            'price' => 'required|numeric|min:0',
        ], [

            // Custom message for the uniqueness rule
            'pot_size_id.unique' => 'This Tree already has an Exception Price for this Pot Size.',

        ]);

        // Create the new validated Exception Price and add it to the database
        $exception_price = ExceptionPrice::create([
            'tree_id' => $validated['tree_id'],
            'pot_size_id' => $validated['pot_size_id'],
            'price' => $validated['price'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('prices')->with('success', 'The new Exception Price has been successfully added.');

    }


    /***************************************************

    edit($id)

    This function displays the form for updating an 
    Exception Price.

    ****************************************************/
    public function edit($id)
    {
        // Get the exception price object
        $exception_price = ExceptionPrice::findOrFail($id);

        // Get the pot_sizes from the database
        $pot_sizes = PotSize::orderBy('size')->get();

        // Get the trees from the database
        $trees = Tree::orderBy('common_name')->get();

        // Return the edit view and pass it the exception price object and 
        // the other arrays
        return view('admin.exception_prices.edit_form', [
            'exception_price' => $exception_price,
            'pot_sizes' => $pot_sizes,
            'trees' => $trees,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified exception price 
    object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the exception price object
        $exception_price = ExceptionPrice::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'tree_id' => 'required|exists:trees,id',

            'pot_size_id' => [
                'required',
                'exists:pot_sizes,id',

                // The combination of Tree and Pot Size must be unique
                Rule::unique('exception_prices')
                        ->ignore($exception_price->id)
                        ->where(function ($query) use ($request) {
                            return $query->where('tree_id', $request->tree_id)
                                        ->where('pot_size_id', $request->pot_size_id);
                        }),

            ],

            'price' => 'required|numeric|min:0',
        ], [

            // Custom message for the uniqueness rule
            'pot_size_id.unique' => 'This Tree already has an Exception Price for this Pot Size.',

        ]);

        // Update the validated Exception Price in the database
        $exception_price->update([
            'tree_id' => $validated['tree_id'],
            'pot_size_id' => $validated['pot_size_id'],
            'price' => $validated['price'],
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('prices')->with('success', 'The Exception Price has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified exception price 
    object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the exception price object
        $exception_price = ExceptionPrice::findOrFail($id);

        // Delete the exception price object
        $exception_price->delete();

        // Return to the index view and pass it a success message
        return redirect('prices')->with('success', 'The Exception Price has been successfully deleted.');

    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the exception price object
        $exception_price = ExceptionPrice::with('tree')->with('pot_size')->findOrFail($id);

        // Return the confirm_delete view and pass it the exception price object
        return view('admin.exception_prices.confirm_delete', [
            'exception_price' => $exception_price,
        ]);
                    

    }
    
}

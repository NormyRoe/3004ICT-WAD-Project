<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\ExceptionPrice;
use App\Models\PotSize;
use App\Models\Tree;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PricesController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding Prices.

    ****************************************************/
    public function index()
    {
        // Get the prices from the database
        $prices = Price::with('pot_size')->get();

        // Get the exception_prices from the database
        $exception_prices = ExceptionPrice::with('pot_size')->with('tree')->get();

        // Return the index view and pass it the arrays
        return view('admin.prices.index', [
            'prices' => $prices,
            'exception_prices' => $exception_prices,
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new Prices.

    ****************************************************/
    public function create()
    {
        // Get the pot_sizes from the database
        $pot_sizes = PotSize::get();

        // Return the create_form view and pass it the arrays
        return view('admin.prices.create_form', [
            'pot_sizes' => $pot_sizes,
        ]);

    }


    /***************************************************

    store(Request $request)

    This function validates the new Price and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Create the first part of the validation process
        $validator = \Validator::make($request->all(), [
            'name' => [
                'nullable',
                'string',
                'max:45',

                // If pot_size_id is null → name must be unique
                Rule::unique('prices')->where(function ($query) use ($request) {
                    return $query->whereNull('pot_size_id')
                                ->where('name', $request->name);
                }),

            ],

            'pot_size_id' => [
                'nullable',
                'exists:pot_sizes,id',

                // If pot_size_id is present → pot_size_id must be unique
                Rule::unique('prices')->where(function ($query) use ($request) {
                    return $query->where('pot_size_id', $request->pot_size_id);
                }),

            ],

            'price' => 'nullable|numeric|min:0',
            'rate' => 'nullable|numeric|min:0',
            
        ], [

            // Custom messages for the uniqueness rules
            'name.unique' => 'A price entry with this Name already exists.',
            'pot_size_id.unique' => 'A price entry for this Pot Size already exists.',

        ]);

        // Add custom validations and errors for after the initial validation checks.
        $validator->after(function ($validator) use ($request) {

            // Rule 1: If pot_size_id is present → price must be present, and there can't be a rate
            if ((!empty($request->pot_size_id) && empty($request->price)) || 
                (!empty($request->pot_size_id) && !empty($request->rate))) 
            {
                $validator->errors()->add('general', 'Pot Size Prices must include a Price and no Rate.');
            }

            // Rule 2: If name is present → either price or rate must be present
            if ((!empty($request->name) && empty($request->price) && empty($request->rate)) || 
                (!empty($request->name) && !empty($request->price) && !empty($request->rate)))
            {
                $validator->errors()->add('general', 'Named Prices must include either a Price or a Rate, but cannot have both.');
            }

            // Rule 3: Prevent completely empty rows
            if 
            (
                empty($request->name) &&
                empty($request->pot_size_id) &&
                empty($request->price) &&
                empty($request->rate)
            )
            {
                $validator->errors()->add('general', 'You must provide at least one field.');
            }
        });

        // Validate the request
        $validated = $validator->validate();

        // Create the new validated Price and add it to the database
        Price::create([
            'name' => $validated['name'] ?? null,
            'pot_size_id' => $validated['pot_size_id'] ?? null,
            'price' => $validated['price'] ?? null,
            'rate' => $validated['rate'] ?? null,
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('prices')->with('success', 'The new Price has been successfully added.');

    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Price.

    ****************************************************/
    public function edit($id)
    {
        // Get the price object
        $price = Price::findOrFail($id);

        // Get the pot_sizes from the database
        $pot_sizes = PotSize::get();

        // Return the edit view and pass it the price object and 
        // the other array
        return view('admin.prices.edit_form', [
            'price' => $price,
            'pot_sizes' => $pot_sizes
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified price object.

    ****************************************************/
    public function update(Request $request, $id)
    {

        // Get the price object
        $price = Price::findOrFail($id);

        // Create the first part of the validation process
        $validator = \Validator::make($request->all(), [
            'name' => [
                'nullable',
                'string',
                'max:45',

                // If pot_size_id is null → name must be unique
                Rule::unique('prices')->where(function ($query) use ($request, $id) {
                    return $query->whereNull('pot_size_id')
                                ->where('name', $request->name)
                                ->where('id', '!=', $id);
                }),

            ],

            'pot_size_id' => [
                'nullable',
                'exists:pot_sizes,id',

                // If pot_size_id is present → pot_size_id must be unique
                Rule::unique('prices')->where(function ($query) use ($request, $id) {
                    return $query->where('pot_size_id', $request->pot_size_id)
                                 ->where('id', '!=', $id);
                }),

            ],

            'price' => 'nullable|numeric|min:0',
            'rate' => 'nullable|numeric|min:0',
            
        ], [

            // Custom messages for the uniqueness rules
            'name.unique' => 'A price entry with this Name already exists.',
            'pot_size_id.unique' => 'A price entry for this Pot Size already exists.',

        ]);

        // Add custom validations and errors for after the initial validation checks.
        $validator->after(function ($validator) use ($request) {

            // Rule 1: If pot_size_id is present → price must be present, and there can't be a rate
            if ((!empty($request->pot_size_id) && empty($request->price)) || 
                (!empty($request->pot_size_id) && !empty($request->rate))) 
            {
                $validator->errors()->add('general', 'Pot Size Prices must include a Price and no Rate.');
            }

            // Rule 2: If name is present → either price or rate must be present
            if ((!empty($request->name) && empty($request->price) && empty($request->rate)) || 
                (!empty($request->name) && !empty($request->price) && !empty($request->rate)))
            {
                $validator->errors()->add('general', 'Named Prices must include either a Price or a Rate, but cannot have both.');
            }

            // Rule 3: Prevent completely empty rows
            if 
            (
                empty($request->name) &&
                empty($request->pot_size_id) &&
                empty($request->price) &&
                empty($request->rate)
            )
            {
                $validator->errors()->add('general', 'You must provide at least one field.');
            }
        });

        // Validate the request
        $validated = $validator->validate();

        // Update the validated Price in the database
        $price->update([
            'name' => $validated['name'] ?? null,
            'pot_size_id' => $validated['pot_size_id'] ?? null,
            'price' => $validated['price'] ?? null,
            'rate' => $validated['rate'] ?? null,
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('prices')->with('success', 'The Price has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified price object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the price object
        $price = Price::findOrFail($id);

        // Delete the price object
        $price->delete();

        // Return to the index view and pass it a success message
        return redirect('prices')->with('success', 'The Price has been successfully deleted.');

    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the price object
        $price = Price::with('pot_size')->findOrFail($id);

        // Return the confirm_delete view and pass it the price object
        return view('admin.prices.confirm_delete', [
            'price' => $price,
        ]);
                    

    }

}

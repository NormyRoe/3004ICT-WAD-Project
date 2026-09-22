<?php

namespace App\Http\Controllers;

use App\Models\AllocatedTask;
use App\Models\AllocatedTasksUser;
use App\Models\Task;
use App\Models\Inventory;
use App\Models\Tree;
use App\Models\PotSize;
use App\Models\Location;
use App\Models\Area;
use App\Models\Block;
use App\Models\Aisle;
use App\Models\User;
use App\Models\Role;
use App\Models\UsersRole;
use Illuminate\Http\Request;

class AllocatedTasksController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding 
    Allocated Tasks.

    ****************************************************/
    public function index()
    {
        // Get the unallocated tasks from the database
        $unallocated_tasks = AllocatedTask::with([
            'task',
            'tree',
            'current_pot_size',
            'new_pot_size',
            'location_1.area',
            'location_1.block',
            'location_1.aisle',
            'location_2.area',
            'location_2.block',
            'location_2.aisle',
            'allocated_task_users'
        ])->where('allocated', 0)->where('done', 0)->orderBy('date')->get();

        // Get all of the allocated tasks from the database
        $all_allocated_tasks = AllocatedTask::with([
            'task',
            'tree',
            'current_pot_size',
            'new_pot_size',
            'location_1.area',
            'location_1.block',
            'location_1.aisle',
            'location_2.area',
            'location_2.block',
            'location_2.aisle',
            'allocated_task_users'
        ])->where('allocated', 1)->orderBy('date')->get();

        // Derive the open allocated tasks
        $allocated_tasks = $all_allocated_tasks->filter(function ($t) {
                                            return $t->done === 0;
                                        });
        
        // Derive the completed tasks
        $completed_tasks = $all_allocated_tasks->filter(function ($t) {
                                            return $t->done === 1;
                                        });

        // Derive the current user tasks from the allocated tasks variable
        $current_user_tasks = $allocated_tasks->filter(function ($task) {
            return $task->allocated_task_users->contains('user_id', auth()->id());
        });

        // Return the index view and pass it the arrays
        return view('menu_top.allocated_tasks.index', [
            'current_user_tasks'     => $current_user_tasks,
            'unallocated_tasks' => $unallocated_tasks,
            'allocated_tasks'   => $allocated_tasks,
            'completed_tasks' => $completed_tasks,
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new 
    Allocated Tasks.

    ****************************************************/
    public function create()
    {
        // Get the tasks from the database
        $tasks = Task::orderBy('name')->get();

        // Get the trees from the database
        $trees = Tree::orderBy('plant_id')->get();

        // Get the pot sizes from the database
        $pot_sizes = PotSize::orderBy('size')->get();

        // Get the locations from the database
        $locations = Location::with('area')->with('block')->with('aisle')
                                ->leftJoin('areas', 'locations.area_id', '=', 'areas.id')
                                ->leftJoin('blocks', 'locations.block_id', '=', 'blocks.id')
                                ->leftJoin('aisles', 'locations.aisle_id', '=', 'aisles.id')
                                ->orderBy('areas.name')
                                ->orderByRaw('COALESCE(blocks.name, "") ASC')           // NULL block names first
                                ->select('locations.*')
                                ->get();

        // Get all of the current users
        $current_users = User::where('status', 'Approved')
                                ->orderBy('last_name')
                                ->orderBy('first_name')
                                ->get();

        // Take just the users that can be allocated tasks out of current_users list
        $users = $current_users->filter(function ($u) {
                                            return $u->hasAnyRole(['Field Hand', 'Potter']);
                                        });
        
        // Return the create_form view and pass it the arrays
        return view('menu_top.allocated_tasks.create_form', [
            'tasks' => $tasks,
            'trees' => $trees,
            'pot_sizes' => $pot_sizes,
            'locations' => $locations,
            'users' => $users,
        ]);

    }


    /***************************************************

    store(Request $request)

    This function validates the new Allocated Task and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([

            'date' => 'required|date',
            'task_id' => 'required|exists:tasks,id',
            'notes' => 'nullable|string|max:200',
            'tree_id' => 'nullable|exists:trees,id',
            'quantity' => 'nullable|numeric|min:0',
            'location_1_id' => 'nullable|exists:locations,id',
            'location_2_id' => 'nullable|exists:locations,id',
            'current_pot_size_id' => 'nullable|exists:pot_sizes,id',
            'new_pot_size_id' => 'nullable|exists:pot_sizes,id',
            'allocated_users' => 'nullable|array|min:1',
            'allocated_users.*'    => 'exists:users,id',
            
        ]);

        // Grab the task reference data record
        $task_type = Task::find($validated['task_id']);

        // Create an inventory variable
        $inventory = null;

        // If there is a tree, location 1 and current pot size in the task
        if ($validated['tree_id'] && $validated['location_1_id'] && $validated['current_pot_size_id'])
        {
            // Get the existing inventory record
            $inventory = Inventory::where('tree_id', $validated['tree_id'])
                                    ->where('location_id', $validated['location_1_id'])
                                    ->where('pot_size_id', $validated['current_pot_size_id'])
                                    ->first();
        }

        // If the inventory record doesn't exist, but the Tree, Location 1 and Current Pot Size were provided
        if (!$inventory && $validated['tree_id'] && $validated['location_1_id'] && $validated['current_pot_size_id'])
        {
            // Return back to the create page with errors
            return back()
                    ->withErrors(['task_id' => "There is no current Inventory record for this combination of Tree, 
                                                Existing Location and Current Pot Size"])
                    ->withInput();
        }

        // If the inventory record does exist but the quantity is less
        if ($inventory && $validated['quantity'] > $inventory->quantity)
        {
            // Return back to the create page with errors
            return back()
                    ->withErrors(['task_id' => "You have entered a higher quantity level then exists for this 
                                    combination of Tree and Existing Location"])
                    ->withInput();
        }

        // If the inventory record does exist but the pot size is the same
        if ($inventory && $validated['new_pot_size_id'] == $inventory->pot_size_id)
        {
            // Return back to the edit page with errors
            return back()
                    ->withErrors(['task_id' => "That combination of Tree, Existing Location and Current Pot Size already has that Pot Size.  
                                    You need to select a different Pot Size."])
                    ->withInput();
        }

        // If the task is 'Move'
        if ($task_type->name === 'Move')
        {
            // If Tree, Quantity, Current Pot Size, Location 1, or Location 2 are empty
            if (!$validated['tree_id'] || !$validated['quantity'] || !$validated['current_pot_size_id'] 
                || !$validated['location_1_id'] || !$validated['location_2_id'])
            {
                // Return back to the create page with errors
                return back()
                        ->withErrors(['task_id' => "You must provide the Tree, Quantity, Current Pot Size, Existing Location 
                                                    and New Location for a 'Move' task"])
                        ->withInput();
            }

        }

        // If the task is 'Re-Pot'
        if ($task_type->name === 'Re-Pot')
        {
            // If Tree, Quantity, Location 1, Current Pot Size or New Pot Size are empty
            if (!$validated['tree_id'] || !$validated['quantity'] || !$validated['location_1_id'] 
                || !$validated['current_pot_size_id'] || !$validated['new_pot_size_id'])
            {
                // Return back to the create page with errors
                return back()
                        ->withErrors(['task_id' => "You must provide the Tree, Quantity, Existing Location, Current Pot Size 
                                                    and New Pot Size for a 'Re-Pot' task"])
                        ->withInput();
            }

        }

        // If the task is 'Destroy'
        if ($task_type->name === 'Destroy')
        {
            // If Tree, Quantity, Location 1 or Current Pot Size are empty
            if (!$validated['tree_id'] || !$validated['quantity'] || !$validated['location_1_id'] || !$validated['current_pot_size_id'])
            {
                // Return back to the create page with errors
                return back()
                        ->withErrors(['task_id' => "You must provide the Tree, Quantity, Existing Location and Current Pot Size 
                                                    for a 'Destroy' task"])
                        ->withInput();
            }

        }

        // Create an allocated variable
        $allocated = 0;

        // If there are allocated users
        if (!empty($validated['allocated_users']))
        {
            // Update allocated to 1
            $allocated = 1;
        }

        // Create the new validated Task and add it to the database
        $task = AllocatedTask::create([
            'date' => $validated['date'],
            'task_id' => $validated['task_id'],
            'notes' => $validated['notes'],
            'tree_id' => $validated['tree_id'],
            'quantity' => $validated['quantity'],
            'location_1_id' => $validated['location_1_id'],
            'location_2_id' => $validated['location_2_id'],
            'current_pot_size_id' => $validated['current_pot_size_id'],
            'new_pot_size_id' => $validated['new_pot_size_id'],
            'done' => 0,
            'allocated' => $allocated,
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Allocate the users to the task        
        if (!empty($validated['allocated_users']))
        {
            // For loop through the selected users
            foreach ($validated['allocated_users'] as $user_id)
            {
                // Create the Allocated Tasks User record
                AllocatedTasksUser::create([
                    'allocated_task_id' => $task->id,
                    'user_id' => $user_id,
                    'created_by' => auth()->id(),
                    'modified_by' => auth()->id(),
                ]);
                
            }
        }

        // Redirect to the show view to display the new Task object and pass it a success message
        return redirect("allocated_tasks/$task->id")->with('success', 'The new task has been successfully added.');

    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    Allocated Tasks's details.

    ****************************************************/
    public function show($id)
    {
        // Get the task from the database
        $task = AllocatedTask::with([
            'task',
            'tree',
            'current_pot_size',
            'new_pot_size',
            'location_1.area',
            'location_1.block',
            'location_1.aisle',
            'location_2.area',
            'location_2.block',
            'location_2.aisle',
            'allocated_task_users'
        ])->findOrFail($id);

        // Get the allocated users
        $allocated_users = AllocatedTasksUser::select('allocated_tasks_users.*', 'users.first_name', 'users.last_name')
                                    ->join('users', 'allocated_tasks_users.user_id', '=', 'users.id')
                                    ->with('user')
                                    ->where('allocated_task_id', $task->id)
                                    ->orderBy('users.last_name')
                                    ->orderBy('users.first_name')
                                    ->get();

        // Return the show view and pass it task object
        return view('menu_top.allocated_tasks.show', [
            'task' => $task,
            'allocated_users' => $allocated_users,
        ]);

    }


    /***************************************************

    edit($id)

    This function displays the form for updating an 
    Allocated Task.

    ****************************************************/
    public function edit($id)
    {
        // Get the task from the database
        $task = AllocatedTask::with([
            'task',
            'tree',
            'current_pot_size',
            'new_pot_size',
            'location_1.area',
            'location_1.block',
            'location_1.aisle',
            'location_2.area',
            'location_2.block',
            'location_2.aisle',
            'allocated_task_users'
        ])->findOrFail($id);

        // Create the array for currently allocated users
        $allocated_user_ids = $task->allocated_task_users->pluck('user_id')->toArray();

        // Get the pot sizes from the database
        $pot_sizes = PotSize::orderBy('size')->get();

        // Get the locations from the database
        $locations = Location::with('area')->with('block')->with('aisle')
                                ->leftJoin('areas', 'locations.area_id', '=', 'areas.id')
                                ->leftJoin('blocks', 'locations.block_id', '=', 'blocks.id')
                                ->leftJoin('aisles', 'locations.aisle_id', '=', 'aisles.id')
                                ->orderBy('areas.name')
                                ->orderByRaw('COALESCE(blocks.name, "") ASC')           // NULL block names first
                                ->select('locations.*')
                                ->get();

        // Get all of the current users
        $current_users = User::where('status', 'Approved')
                                ->orderBy('last_name')
                                ->orderBy('first_name')
                                ->get();

        // Take just the users that can be allocated tasks out of current_users list
        $users = $current_users->filter(function ($u) {
                                            return $u->hasAnyRole(['Field Hand', 'Potter']);
                                        });

        // Take just the management users that can be allocated report tasks out of current_users list
        $management_users = $current_users->filter(function ($u) {
                                            return $u->hasAnyRole(['Operational Manager', 'Owner']);
                                        });

        // Return the edit view and pass it the sale object and the arrays
        return view('menu_top.allocated_tasks.edit_form', [
            'task' => $task,
            'pot_sizes' => $pot_sizes,
            'locations' => $locations,
            'users' => $users,
            'management_users' => $management_users,
            'allocated_user_ids' => $allocated_user_ids,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified Allocated Task object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the task from the database
        $task = AllocatedTask::with([
            'task',
            'tree',
            'current_pot_size',
            'new_pot_size',
            'location_1.area',
            'location_1.block',
            'location_1.aisle',
            'location_2.area',
            'location_2.block',
            'location_2.aisle',
            'allocated_task_users'
        ])->findOrFail($id);

        // Validate the request
        $validated = $request->validate([

            'notes' => 'nullable|string|max:200',
            'location_2_id' => 'nullable|exists:locations,id',
            'new_pot_size_id' => 'nullable|exists:pot_sizes,id',
            'allocated_users' => 'required|array|min:1',
            'allocated_users.*'    => 'exists:users,id',
            'done' => 'nullable|numeric',
            
        ]);

        // Create the done variable from the request
        $done = $request->has('done') ? 1 : 0;

        // Grab the task type
        $task_type = $task->task->name;

        // Create an inventory variable
        $inventory = null;

        // If there is a tree, location 1 and current pot size in the task
        if ($task->tree_id && $task->location_1_id && $task->current_pot_size_id)
        {
            // Get the existing inventory record
            $inventory = Inventory::where('tree_id', $task->tree_id)
                                    ->where('location_id', $task->location_1_id)
                                    ->where('pot_size_id', $task->current_pot_size_id)
                                    ->first();
        }

        // If the inventory record does exist but the new pot size is the same
        if ($inventory && $validated['new_pot_size_id'] == $inventory->pot_size_id)
        {
            // Return back to the edit page with errors
            return back()
                    ->withErrors(['task_id' => "That combination of Tree, Existing Location and Current Pot Size already has that Pot Size.  
                                    You need to select a different Pot Size."])
                    ->withInput();
        }

        // If the task is 'Move'
        if ($task_type === 'Move')
        {
            // If Location 2 is empty
            if (!$validated['location_2_id'])
            {
                // Return back to the edit page with errors
                return back()
                        ->withErrors(['task_id' => "You must provide the New Location for a 'Move' task"])
                        ->withInput();
            }

        }

        // If the task is 'Re-Pot'
        if ($task_type === 'Re-Pot')
        {
            // If new Pot Size is empty
            if (!$validated['new_pot_size_id'])
            {
                // Return back to the edit page with errors
                return back()
                        ->withErrors(['task_id' => "You must provide the new Pot Size for a 'Re-Pot' task"])
                        ->withInput();
            }

        }

        // Update the validated Task in the database
        $task->update([
            'notes' => $validated['notes'],
            'location_2_id' => $validated['location_2_id'],
            'new_pot_size_id' => $validated['new_pot_size_id'],
            'done' => $done,
            'allocated' => 1,
            'modified_by' => auth()->id(),
        ]);

        // Delete the existing allocated users
        $task->allocated_task_users()->delete();

        // For loop through the selected users
        foreach ($validated['allocated_users'] as $user_id)
        {
            // Create the Allocated Tasks User record
            AllocatedTasksUser::create([
                'allocated_task_id' => $task->id,
                'user_id' => $user_id,
                'created_by' => auth()->id(),
                'modified_by' => auth()->id(),
            ]);
                
        }

        // Create a new inventory variable
        $new_inventory = null;

        // Get all of the current users
        $current_users = User::where('status', 'Approved')
                                ->orderBy('last_name')
                                ->orderBy('first_name')
                                ->get();

        // Take just the field hands out of current_users list
        $field_hands = $current_users->filter(function ($u) {
                                            return $u->hasRole('Field Hand');
                                        });

        // Take just the potters out of current_users list
        $potters = $current_users->filter(function ($u) {
                                            return $u->hasRole('Potter');
                                        });

        // Get the new location from the database
        $new_location = Location::with('area')->with('block')->with('aisle')
                                ->where('id', $task->location_2_id)
                                ->first();

        // If the task is 'Move', the Inventory record exists and the task is completed
        if ($task_type === 'Move' && $inventory && $task->done == 1)
        {
            // Get the new inventory record
            $new_inventory = Inventory::where('tree_id', $task->tree_id)
                                    ->where('location_id', $task->location_2_id)
                                    ->where('pot_size_id', $task->current_pot_size_id)
                                    ->first();

            // Update the current inventory record
            $inventory->update([
                'quantity' => $inventory->quantity - $task->quantity,
                'modified_by' => auth()->id(),
            ]);

            // If the current inventory record now has a quantity of zero
            if ($inventory->quantity == 0)
            {
                // Delete the inventory record
                $inventory->delete();
            }

            // If new inventory record already exists
            if ($new_inventory)
            {
                // Update the new inventory record
                $new_inventory->update([
                    'quantity' => $new_inventory->quantity + $task->quantity,
                    'modified_by' => auth()->id(),
                ]);
            }
            else
            {
                // Create a new Inventory record and add it to the database
                $new_inventory = Inventory::create([
                    'tree_id' => $task->tree_id,
                    'pot_size_id' => $task->current_pot_size_id,
                    'location_id' => $task->location_2_id,
                    'quantity' => $task->quantity,
                    'created_by' => auth()->id(),
                    'modified_by' => auth()->id(),
                ]);
            }

            // If the new location is a Potting area
            if (str_starts_with($new_location->area->name, 'Potting'))
            {
                // Get the 'Re-Pot' task type record
                $new_task_type = Task::where('name', 'Re-Pot')->first();

                // Create a new 'Re-Pot' task and add it to the database
                $new_task = AllocatedTask::create([
                    'date' => today(),
                    'task_id' => $new_task_type->id,
                    'notes' => "This tree has been moved to a potting area, please re-pot it in to a larger pot.  The new Pot Size will need to be selected.",
                    'tree_id' => $task->tree_id,
                    'quantity' => $task->quantity,
                    'location_1_id' => $task->location_2_id,
                    'location_2_id' => null,
                    'current_pot_size_id' => $task->current_pot_size_id,
                    'new_pot_size_id' => null,
                    'done' => 0,
                    'allocated' => 1,
                    'created_by' => auth()->id(),
                    'modified_by' => auth()->id(),
                ]);

                // For loop through the potters list of users
                foreach ($potters as $user)
                {
                    // Create the Allocated Tasks User records
                    AllocatedTasksUser::create([
                        'allocated_task_id' => $new_task->id,
                        'user_id' => $user->id,
                        'created_by' => auth()->id(),
                        'modified_by' => auth()->id(),
                    ]);
                        
                }
            }

        }

        // If the task is 'Re-Pot', the Inventory record exists and the task is completed
        if ($task_type === 'Re-Pot' && $inventory && $task->done == 1)
        {
            // Get the new inventory record
            $new_inventory = Inventory::where('tree_id', $task->tree_id)
                                    ->where('location_id', $task->location_1_id)
                                    ->where('pot_size_id', $task->new_pot_size_id)
                                    ->first();

            // Update the current inventory record
            $inventory->update([
                'quantity' => $inventory->quantity - $task->quantity,
                'modified_by' => auth()->id(),
            ]);

            // If the current inventory record now has a quantity of zero
            if ($inventory->quantity == 0)
            {
                // Delete the inventory record
                $inventory->delete();
            }

            // If new inventory record already exists
            if ($new_inventory)
            {
                // Update the new inventory record
                $new_inventory->update([
                    'quantity' => $new_inventory->quantity + $task->quantity,
                    'modified_by' => auth()->id(),
                ]);
            }
            else
            {
                // Create a new Inventory record and add it to the database
                $new_inventory = Inventory::create([
                    'tree_id' => $task->tree_id,
                    'pot_size_id' => $task->new_pot_size_id,
                    'location_id' => $task->location_1_id,
                    'quantity' => $task->quantity,
                    'created_by' => auth()->id(),
                    'modified_by' => auth()->id(),
                ]);
            }

            // Get the 'Move' task type record
            $new_task_type = Task::where('name', 'Move')->first();

            // Create a new 'Move' task and add it to the database
            $new_task = AllocatedTask::create([
                'date' => today(),
                'task_id' => $new_task_type->id,
                'notes' => "This tree has been re-potted, please move it to it's new location.  The new location will need to be selected",
                'tree_id' => $task->tree_id,
                'quantity' => $task->quantity,
                'location_1_id' => $task->location_1_id,
                'location_2_id' => null,
                'current_pot_size_id' => $task->new_pot_size_id,
                'new_pot_size_id' => null,
                'done' => 0,
                'allocated' => 1,
                'created_by' => auth()->id(),
                'modified_by' => auth()->id(),
            ]);

            // For loop through the field hands list of users
            foreach ($field_hands as $user)
            {
                // Create the Allocated Tasks User records
                AllocatedTasksUser::create([
                    'allocated_task_id' => $new_task->id,
                    'user_id' => $user->id,
                    'created_by' => auth()->id(),
                    'modified_by' => auth()->id(),
                ]);
                        
            }

        }

        // If the task is 'Destroy', the Inventory record exists and the task is completed
        if ($task_type === 'Destroy' && $inventory && $task->done == 1)
        {
            // Update the current inventory record
            $inventory->update([
                'quantity' => $inventory->quantity - $task->quantity,
                'modified_by' => auth()->id(),
            ]);

            // If the current inventory record now has a quantity of zero
            if ($inventory->quantity == 0)
            {
                // Delete the inventory record
                $inventory->delete();
            }

        }

        // Redirect to the show view to display the Task object and pass it a success message
        return redirect("allocated_tasks/$task->id")->with('success', 'The task has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified allocated task object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the allocated task object
        $task = AllocatedTask::findOrFail($id);

        // Delete ALL existing allocated_tasks_users for this task
        $task->allocated_task_users()->delete();

        // Delete the task object
        $task->delete();

        // Return to the index view and pass it a success message
        return redirect('allocated_tasks')->with('success', 'The Task has been successfully deleted.');

    }

    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the allocated task from the database
        $task = AllocatedTask::with([
            'task',
            'tree',
            'pot_size',
            'location_1.area',
            'location_1.block',
            'location_1.aisle',
            'location_2.area',
            'location_2.block',
            'location_2.aisle',
            'allocated_task_users'
        ])->findOrFail($id);

        // Check if it is a completed task
        if ($task->done == 1)
        {
            // Redirect to the show view to display the Task object and pass it a success message
            return redirect("allocated_tasks/$task->id")->with('success', "This task can't be deleted as it has already been completed");

        }

        // Return the confirm_delete view and pass it the allocated task object
        return view('menu_top.allocated_tasks.confirm_delete', [
            'task' => $task,
        ]);
        
    }


    /***************************************************

    create_report()

    This function displays the form for creating a new 
    'Report' Allocated Task.

    ****************************************************/
    public function create_report()
    {
        // Get the report task from the database
        $task = Task::where('name', '=', 'Report')->firstOrFail();

        // Get the trees from the database
        $trees = Tree::orderBy('plant_id')->get();

        // Get the pot sizes from the database
        $pot_sizes = PotSize::orderBy('size')->get();

        // Get the locations from the database
        $locations = Location::with('area')->with('block')->with('aisle')
                                ->leftJoin('areas', 'locations.area_id', '=', 'areas.id')
                                ->leftJoin('blocks', 'locations.block_id', '=', 'blocks.id')
                                ->leftJoin('aisles', 'locations.aisle_id', '=', 'aisles.id')
                                ->orderBy('areas.name')
                                ->orderByRaw('COALESCE(blocks.name, "") ASC')           // NULL block names first
                                ->select('locations.*')
                                ->get();        
        
        // Return the create_report view and pass it the arrays
        return view('menu_top.allocated_tasks.create_report', [
            'task' => $task,
            'trees' => $trees,
            'pot_sizes' => $pot_sizes,
            'locations' => $locations,
        ]);

    }


    /***************************************************

    store_report(Request $request)

    This function validates the new 'Report' Allocated Task and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store_report(Request $request)
    {
        // Validate the request
        $validated = $request->validate([

            'date' => 'required|date',
            'task_id' => 'required|exists:tasks,id',
            'notes' => 'required|string|max:200',
            'tree_id' => 'nullable|exists:trees,id',
            'location_1_id' => 'nullable|exists:locations,id',
            'current_pot_size_id' => 'nullable|exists:pot_sizes,id',
            
        ]);

        // Create an inventory variable
        $inventory = null;

        // If there is a tree, location 1 and current pot size in the task
        if ($validated['tree_id'] && $validated['location_1_id'] && $validated['current_pot_size_id'])
        {
            // Get the existing inventory record
            $inventory = Inventory::where('tree_id', $validated['tree_id'])
                                    ->where('location_id', $validated['location_1_id'])
                                    ->where('pot_size_id', $validated['current_pot_size_id'])
                                    ->first();
        }

        // If the inventory record doesn't exist, but the Tree, Location 1 and Current Pot Size were provided
        if (!$inventory && $validated['tree_id'] && $validated['location_1_id'] && $validated['current_pot_size_id'])
        {
            // Return back to the create page with errors
            return back()
                    ->withErrors(['task_id' => "There is no current Inventory record for this combination of Tree, Existing Location 
                                                and Current Pot Size."])
                    ->withInput();
        }

        // Get all of the current users
        $current_users = User::where('status', 'Approved')
                                ->orderBy('last_name')
                                ->orderBy('first_name')
                                ->get();

        // Take just the management users that can be allocated report tasks out of current_users list
        $management_users = $current_users->filter(function ($u) {
                                            return $u->hasAnyRole(['Operational Manager', 'Owner']);
                                        });        

        // Create the new validated Task and add it to the database
        $task = AllocatedTask::create([
            'date' => $validated['date'],
            'task_id' => $validated['task_id'],
            'notes' => $validated['notes'],
            'tree_id' => $validated['tree_id'],
            'location_1_id' => $validated['location_1_id'],
            'current_pot_size_id' => $validated['current_pot_size_id'],
            'done' => 0,
            'allocated' => 1,
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Allocate the users to the task 
        // For loop through the management users
        foreach ($management_users as $user)
        {
            // Create the Allocated Tasks User record
            AllocatedTasksUser::create([
                'allocated_task_id' => $task->id,
                'user_id' => $user->id,
                'created_by' => auth()->id(),
                'modified_by' => auth()->id(),
            ]);
                
        }

        // Redirect to the index view and pass it a success message
        return redirect("allocated_tasks")->with('success', 'The new Report task has been successfully added.');

    }

}

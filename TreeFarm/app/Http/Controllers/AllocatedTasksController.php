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
            'pot_size',
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
            'pot_size',
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
            'pot_size_id' => 'nullable|exists:pot_sizes,id',
            'allocated_users' => 'nullable|array|min:1',
            'allocated_users.*'    => 'exists:users,id',
            
        ]);

        // Grab the task reference data record
        $task_type = Task::find($validated['task_id']);

        // Create an inventory variable
        $inventory = null;

        // If there is a tree and location 1 in the task
        if ($validated['tree_id'] && $validated['location_1_id'])
        {
            // Get the existing inventory record
            $inventory = Inventory::where('tree_id', $validated['tree_id'])
                                    ->where('location_id', $validated['location_1_id'])
                                    ->first();
        }

        // If the inventory record doesn't exist, but the Tree and Location 1 were provided
        if (!$inventory && $validated['tree_id'] && $validated['location_1_id'])
        {
            // Return back to the create page with errors
            return back()
                    ->withErrors(['task_id' => "There is no current Inventory record for this combination of Tree and Existing Location"])
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
        if ($inventory && $validated['pot_size_id'] == $inventory->pot_size_id)
        {
            // Return back to the create page with errors
            return back()
                    ->withErrors(['task_id' => "That combination of Tree and Existing Location already has that Pot Size.  
                                    You need to select a different Pot Size."])
                    ->withInput();
        }

        // If the task is 'Move'
        if ($task_type->name === 'Move')
        {
            // If Tree, Quantity, Location 1, or Location 2 are empty
            if (!$validated['tree_id'] || !$validated['quantity'] 
                || !$validated['location_1_id'] || !$validated['location_2_id'])
            {
                // Return back to the create page with errors
                return back()
                        ->withErrors(['task_id' => "You must provide the Tree, Quantity, Existing Location and New Location for a 'Move' task"])
                        ->withInput();
            }

        }

        // If the task is 'Re-Pot'
        if ($task_type->name === 'Re-Pot')
        {
            // If Tree, Quantity, Location 1 or Pot Size are empty
            if (!$validated['tree_id'] || !$validated['quantity'] || !$validated['location_1_id'] || !$validated['pot_size_id'])
            {
                // Return back to the create page with errors
                return back()
                        ->withErrors(['task_id' => "You must provide the Tree, Quantity, Existing Location and Pot Size for a 'Re-Pot' task"])
                        ->withInput();
            }

        }

        // If the task is 'Destroy'
        if ($task_type->name === 'Destroy')
        {
            // If Tree, Quantity, or Location 1 are empty
            if (!$validated['tree_id'] || !$validated['quantity'] || !$validated['location_1_id'])
            {
                // Return back to the create page with errors
                return back()
                        ->withErrors(['task_id' => "You must provide the Tree, Quantity and Existing Location for a 'Destroy' task"])
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
            'pot_size_id' => $validated['pot_size_id'],
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
            'pot_size',
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
            'pot_size',
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
        //
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
            
        ]);

        // Create an inventory variable
        $inventory = null;

        // If there is a tree and location 1 in the task
        if ($validated['tree_id'] && $validated['location_1_id'])
        {
            // Get the existing inventory record
            $inventory = Inventory::where('tree_id', $validated['tree_id'])
                                    ->where('location_id', $validated['location_1_id'])
                                    ->first();
        }

        // If the inventory record doesn't exist, but the Tree and Location 1 were provided
        if (!$inventory && $validated['tree_id'] && $validated['location_1_id'])
        {
            // Return back to the create page with errors
            return back()
                    ->withErrors(['task_id' => "There is no current Inventory record for this combination of Tree and Existing Location"])
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

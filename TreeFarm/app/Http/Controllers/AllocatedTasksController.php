<?php

namespace App\Http\Controllers;

use App\Models\AllocatedTask;
use App\Models\AllocatedTasksUser;
use App\Models\Inventory;
use App\Models\Tree;
use App\Models\PotSize;
use App\Models\Location;
use App\Models\Area;
use App\Models\Block;
use App\Models\Aisle;
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
        ])->where('allocated', 0)->get();

        // Get the allocated tasks from the database
        $allocated_tasks = AllocatedTask::with([
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
        ])->where('allocated', 1)->get();

        // Derive the current user tasks from the allocated tasks variable
        $current_user_tasks = $allocated_tasks->filter(function ($task) {
            return $task->allocated_task_users->contains('user_id', auth()->id());
        });

        // Return the index view and pass it the arrays
        return view('menu_top.allocated_tasks.index', [
            'current_user_tasks'     => $current_user_tasks,
            'unallocated_tasks' => $unallocated_tasks,
            'allocated_tasks'   => $allocated_tasks,
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new 
    Allocated Tasks.

    ****************************************************/
    public function create()
    {
        //
    }


    /***************************************************

    store(Request $request)

    This function validates the new Allocated Task and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        //
    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    Allocated Tasks's details.

    ****************************************************/
    public function show($id)
    {
        //
    }


    /***************************************************

    edit($id)

    This function displays the form for updating an 
    Allocated Task.

    ****************************************************/
    public function edit($id)
    {
        //
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
        //
    }

    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the allocated task object
        

        // Return the confirm_delete view and pass it the allocated task object
        return view('menu_top.allocated_tasks.confirm_delete');
        
    }

}

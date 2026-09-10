<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding Tasks.

    ****************************************************/
    public function index()
    {
        // Get the tasks from the database
        $tasks = Task::orderBy('name')->get();

        // Return the index view and pass it the tasks array
        return view('admin.tasks.index', [
            'tasks' => $tasks,
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new Tasks.

    ****************************************************/
    public function create()
    {
        // Return the create_form view
        return view('admin.tasks.create_form');

    }


    /***************************************************

    store(Request $request)

    This function validates the new Task and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'task' => 'required|string|max:60|unique:tasks,name',
        ]);

        // Create the new validated Task and add it to the database
        Task::create([
            'name' => $validated['task'],
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('tasks')->with('success', 'The new Task has been successfully added.');

    }


    /***************************************************

    edit($id)

    This function displays the form for updating a Task.

    ****************************************************/
    public function edit($id)
    {
        // Get the task object
        $task = Task::findOrFail($id);

        // Return the edit view and pass it the task object
        return view('admin.tasks.edit_form', [
            'task' => $task,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified task object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the task object
        $task = Task::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'task' => 'required|string|max:60|unique:tasks,name,' . $task->id,
        ]);        

        // Update the validated Task in the database
        $task->update([
            'name' => $validated['task'],
            'modified_by' => auth()->id(),
        ]);

        // Return to the index view and pass it a success message
        return redirect('tasks')->with('success', 'The Task has been successfully updated.');

    }


    /***************************************************

    destroy($id)

    This function deletes the specified task object.

    ****************************************************/
    public function destroy($id)
    {
        // Get the task object
        $task = Task::findOrFail($id);

        // Delete the task object
        $task->delete();

        // Return to the index view and pass it a success message
        return redirect('tasks')->with('success', 'The Task has been successfully deleted.');

    }


    /***************************************************

    delete_confirm($id)

    This function requires the user to confirm the 
    deletion request.

    ****************************************************/
    public function delete_confirm($id)
    {
        // Get the task object
        $task = Task::findOrFail($id);

        // Return the confirm_delete view and pass it the task object
        return view('admin.tasks.confirm_delete', [
            'task' => $task,
        ]);

    }

}

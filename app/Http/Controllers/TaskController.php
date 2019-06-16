<?php

namespace App\Http\Controllers;

use App\ToDoList;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getTasks()
    {

        $tasks = ToDoList::all();

        if (!$tasks)
            return response('No tasks found', 400);

        return response($tasks, 200);
    }

    public function addTask(Request $request)
    {
        if (!$request) {

            return response('no data detected', 400);
        }

        $validationData = $request->validate([
            'name' => 'required',
            'dueDate' => 'required|date_format:d-m-Y',
            'person' => 'required|regex:/^[a-zA-Z]+$/u',
            'description' => 'required |max:400'
        ],
        [
            'name.required'=>'Please add a task name',
            'dueDate.required'=>'Please add a date',
            'dueDate.date_format'=>'Please enter a date in the format dd/mm/yyyy.',
            'person.required'=>'Please add a persons name',
            'person.regex'=>'Please enter letters only',
            'description.required'=>'Please add a description',
            'description.max'=>'Please enter a maximun of 400 characters.'
        ]);


        $date = str_replace('/', '-', $request->dueDate);


        $task = new ToDoList;

        $task->name = $request->name;
        $task->due_date = date('Y-m-d', strtotime($date));
        $task->person = $request->person;
        $task->description = $request->description;
        $task->save();
//        if (!$saved)
//            App::abort(500, 'Error');

        return response('Success', 200);
    }

    public function editTask(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'dueDate' => 'required',
            'person' => 'required|regex:/^[a-zA-Z]+$/u',
            'description' => 'required |max:400',
            'status' => 'required',
            'id' => 'required '
        ]);
        $date = str_replace('/', '-', $request->dueDate);
        $task = ToDoList::where('id', '=', $request->id)->first();

        $task->name = $request->name;
        $task->due_date = date('Y-m-d', strtotime($date));
        $task->person = $request->person;
        $task->description = $request->description;
        $task->status = $request->status;
        $saved = $task->save();


        if (!$saved) {
            return response('Error', 500);
        }
        return response('Success', 200);
    }

    public function deleteTask(Request $request)
    {
        if (!$request) {
            return response('No id detected', 400);
        }

        $task = ToDoList::where('id', '=', $request->id);

        if (!$task) {
            return response('No task found', 400);
        }

        $saved = $task->delete();

        if (!$saved) {
            return response('Error', 500);
        }
        return response('Task Deleted', 200);
    }

    public function fetchTaskData(Request $request)
    {

        if (!$request) {
            return response('No id detected', 400);
        }
        $task = ToDoList::where('id', '=', $request->id)->first();

        if (!$task) {
            return response('No task found', 400);
        }

        return response($task, 200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tasks = Task::select('task_name' , 'due_date' , 'subject')->latest()->get();

        return view('dashboard', compact('tasks'));



        $tasks = Task::where('status')->latest()->get();
        $totalTasks=Task::where('status')->count();
        return view('dashboard', compact('tasks', 'totalTasks'));
    }


 
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    
             
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $incomingFields= $request->validate([
           'task_name' => ['required', 'string', 'max:40'],
            'due_date' => ['required', 'date'],
            'subject' => ['required', 'string'],
            'status' => ['required', 'in:pending,in_progress,completed']
        ]);

    $incomingFields['task_name'] = strip_tags($incomingFields['task_name']);
    $incomingFields['subject'] = strip_tags($incomingFields['subject']);   
    $incomingFields['user_id'] = auth()->id();
    Task::create($incomingFields);
    return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $incomingFields = $request->validate([
            'task_name' => ['required', 'string', 'max:40'],
            'due_date' => ['required', 'date'],
            'subject' => ['required', 'string'],
            'status' => ['required', 'in:pending,in_progress,completed']
        ]);

        $task->update($incomingFields);
        return redirect('dashboard');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Page;
use App\Models\Task;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
 
    $tasks = Task::where('user_id', auth()->id())
        ->latest()
        ->get();


         $notes = Note::where('user_id' , auth()->id())
        ->latest()
        ->get();




 
    $taskCounts = [
        'pending'     => $tasks->where('status', 'pending')->count(),
        'in_progress' => $tasks->where('status', 'in_progress')->count(),
        'completed'   => $tasks->where('status', 'completed')->count(),
    ];

    return view('dashboard', compact('tasks', 'taskCounts', 'notes'));
    }


 

             
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $incomingFields= $request->validate([
           'task_name' => ['required', 'string'],
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
            $task = Task::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $task->delete();

    return redirect('/dashboard');
    }
}

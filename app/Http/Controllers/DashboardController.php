<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pest\Support\View;

class DashboardController extends Controller
{
    //

    public function showDashboard()
    {
        return view('dashboard');
    }

    //fetching the user data 
    public function show($id)
    {
        $user = User::find($id);
        $user = User::findOrFail($id);
        return view('user.profile', compact('user'));
    }



    public function task(){
        $tasks = Task::where('user_id', auth()->id())
             ->orderBy('due_date', 'asc')
             ->get();
    }





// //add task
//     public function createTask(Request $request){
//         $incomingFields= $request->validate([
//            'task_name' => ['required', 'string', 'max:40'],
//             'due_date' => ['required', 'date'],
//             'subject' => ['required', 'string']
//         ]);

//     $incomingFields['task_name'] = strip_tags($incomingFields['task_name']);
//     $incomingFields['subject'] = strip_tags($incomingFields['subject']);   
//     $incomingFields['user_id'] = auth()->id();
//     Task::create($incomingFields);
//     return redirect('/dashboard');
    
//     }


    




    
}

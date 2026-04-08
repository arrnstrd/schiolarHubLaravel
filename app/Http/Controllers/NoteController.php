<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $notes = Note::where('user_id' , auth()->id())
        // ->latest()
        // ->get();


        // return view('dashboard',compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $incomingFields= $request->validate([
        'name'=>['required' , 'string', 'max:40'],
        'url'=>['required','string'],
        'date' =>['required' , 'string']
       ]);

    $incomingFields['name']= strip_tags($incomingFields['name']);
     $incomingFields['url']= strip_tags($incomingFields['url']);
     $incomingFields['user_id'] = auth()->id();
     Note::create($incomingFields);
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
        $note = Note::findOrFail($id);

        $incomingFields = $request->validate([
            'title'=>['required' , 'string', 'max:40'],
        'url'=>['required','string'],
        'note_date' =>['required' , 'string']
        ]);

        $note->update($incomingFields);
        return redirect('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::where('id' , $id)
        ->where('user_id' , auth()->id())
        ->firstOrFail();

        $note->delete();

        return redirect ('/dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $pages = Page::where('user_id', auth()->id())->latest()->get();
    return view('pages', compact('pages'));
  }

  public function store(Request $request)
  {
    $incomingFields = $request->validate([
      'title'   => ['required', 'string', 'max:80'],
      'content' => ['required', 'string'],
    ]);

    $incomingFields['user_id'] = auth()->id();
    $incomingFields['user_id'] = auth()->id();
    Page::create($incomingFields);
    return redirect('/pages');
  }



  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $page = Page::findOrFail($id);

    $incomingFields = $request->validate([
      'title' => ['required', 'string', 'max:80'],
      'content' => ['required', 'string']
    ]);

    $page->update($incomingFields);
    return redirect('pages');
  }


  public function destroy(string $id)
  {
    $page = Page::where('id', $id)
      ->where('user_id', auth()->id())
      ->firstOrFail();

    $page->delete();

    return redirect('/pages');
  }
}

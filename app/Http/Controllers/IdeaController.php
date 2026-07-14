<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = auth()->user()->ideas();

        $status = $request->get('status');
        $validStatuses = ['pending', 'in_progress', 'completed'];

        if ($status && in_array($status, $validStatuses)) {
            $query->where('status', $status);
        }

        $ideas = $query->latest()->get();
        $statusCounts = Idea::statusCounts(auth()->user());

        return view('ideas.index', compact('ideas', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ideas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
    {
        Idea::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
            'links' => $request->links ?? [],
            'user_id' => auth()->id()
        ]);

        return redirect()->route('ideas.index')->with('success', 'Idea created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        return view('ideas.show', compact('idea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        return view('ideas.edit', compact('idea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {


        $validated = $request->validated();
        $idea->update($validated);

        return redirect()->route('ideas.index')->with('success', 'Idea updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();
        return redirect()->route('ideas.index')->with('success', 'idea deleted!');
    }
}

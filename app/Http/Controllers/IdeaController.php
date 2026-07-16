<?php

namespace App\Http\Controllers;

use App\Actions\CreateIdea;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreIdeaRequest $request, CreateIdea $action)
    {
        $action->handle($request->safe()->all());
        return redirect()->route('ideas.index')->with('success', 'Idea created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {

        Gate::authorize('update', $idea);
        return view('ideas.show', compact('idea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        Gate::authorize('update', $idea);
        return view('ideas.edit', compact('idea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        Gate::authorize('update', $idea);

        $data = $request->safe()->only(['title', 'description', 'status', 'links']);

        if ($request->image) {
            // Eski resmi sil (varsa)
            if ($idea->image_path) {
                Storage::disk('public')->delete($idea->image_path);
            }
            $data['image_path'] = $request->image->store('ideas', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($idea->image_path) {
                Storage::disk('public')->delete($idea->image_path);
            }
            $data['image_path'] = null;
        }

        $idea->update($data);

        // Steps'i sil, formdan gelenlerle yeniden oluştur
        $idea->steps()->delete();
        $idea->steps()->createMany(
            collect($request->steps ?? [])->map(fn ($step) => ['description' => $step])
        );

        return redirect()->route('ideas.show', $idea)->with('success', 'Idea updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        Gate::authorize('update', $idea);

        $idea->delete();
        return redirect()->route('ideas.index')->with('success', 'idea deleted!');
    }
}

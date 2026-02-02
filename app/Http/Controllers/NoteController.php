<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('session.timeout');
    }

    public function index()
    {
        $notes = Auth::user()->notes()->latest()->paginate(10);
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        Auth::user()->notes()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')->with('success', 'یادداشت با موفقیت ایجاد شد');
    }

    public function show(Note $note)
    {
        $this->authorize('view', $note);
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $this->authorize('update', $note);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')->with('success', 'یادداشت با موفقیت به‌روزرسانی شد');
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'یادداشت با موفقیت حذف شد');
    }

    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));
        
        if (empty($query)) {
            $notes = collect();
            return view('notes.search', compact('notes', 'query'));
        }

        // Use parameter binding to safely search (case-insensitive for most collations)
        $searchTerm = '%' . $query . '%';

        $notes = Auth::user()->notes()
            ->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('content', 'LIKE', $searchTerm);
            })
            ->latest()
            ->paginate(10)
            ->appends(['q' => $query]);

        return view('notes.search', compact('notes', 'query'));
    }
}

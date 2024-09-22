<?php

namespace App\Http\Controllers;

use App\Models\Note; // Note modelini ekliyoruz
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        // Kullanıcı bazlı sorgu: Yalnızca oturum açan kullanıcının notlarını getirelim
        $query = auth()->user()->notes(); // Oturum açan kullanıcının notları

        // Arama sorgusu ekleyelim
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Sayfalama ile notları getirelim
        $notes = $query->with('tags')->paginate(10); // 10 notu bir sayfada gösterelim

        return view('notes.index', compact('notes'));
    }


    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        // Kullanıcıya not kaydetme
        $note = auth()->user()->notes()->create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

        // Etiketler eklemek için
        $tags = explode(',', $request->input('tags'));
        foreach ($tags as $tagName) {
            $tag = \App\Models\Tag::firstOrCreate(['name' => trim($tagName)]);
            $note->tags()->attach($tag);
        }

        return redirect()->route('notes.index');
    }

    public function edit(Note $note)
    {
        $this->authorize('update', $note);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $note->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

        // Etiketleri güncellemek
        $note->tags()->sync([]);
        $tags = explode(',', $request->input('tags'));
        foreach ($tags as $tag) {
            $tag = \App\Models\Tag::firstOrCreate(['name' => trim($tag)]);
            $note->tags()->attach($tag);
        }

        return redirect()->route('notes.index');
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);  // Kullanıcı yetkisini kontrol edin
        $note->delete();  // Silme işlemi
        return redirect()->route('notes.index');
    }
}

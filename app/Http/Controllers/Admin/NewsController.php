<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'author' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $image->getClientOriginalName());
            $image->move(public_path('assets/img/news'), $imageName);
            $validated['image'] = $imageName;
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Article ajouté avec succès !');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);

        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'author' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($news->image && file_exists(public_path('assets/img/news/' . $news->image))) {
                unlink(public_path('assets/img/news/' . $news->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $image->getClientOriginalName());
            $image->move(public_path('assets/img/news'), $imageName);
            $validated['image'] = $imageName;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Article mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image && file_exists(public_path('assets/img/news/' . $news->image))) {
            unlink(public_path('assets/img/news/' . $news->image));
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Article supprimé avec succès !');
    }
}

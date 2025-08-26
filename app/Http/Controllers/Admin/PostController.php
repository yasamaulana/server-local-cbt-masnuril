<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postingan = Post::when(request()->q, function ($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        $postingan->appends(['q' => request()->q]);

        return inertia('Admin/Postingan/Index', [
            'posts' => $postingan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Postingan/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('banner')) {
            $fotoPath = $request->file('banner')->store('postingan', 'public');
        }

        Post::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'banner' => $fotoPath,
        ]);

        return redirect()->route('admin.postingan.index');
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
        return inertia('Admin/Postingan/Edit', [
            'postingan' => Post::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            return redirect()->route('admin.postingan.index')->with('error', 'Postingan tidak ditemukan');
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        if ($request->hasFile('banner')) {
            if ($post->banner) {
                Storage::disk('public')->delete($post->banner);
            }
            $fotoPath = $request->file('banner')->store('postingan', 'public');
            $post->update(['banner' => $fotoPath]);
        }

        return redirect()->route('admin.postingan.index')->with('success', 'Postingan Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        if (!$post) {
            return redirect()->route('admin.postingan.index')->with('error', 'Postingan tidak ditemukan');
        }
        if ($post->foto) {
            Storage::disk('public')->delete($post->banner);
        }

        $post->delete();

        return redirect()->route('admin.postingan.index')->with('success', 'Postingan Berhasil Dihapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->status = $request->status;
        $post->save();

        return redirect()->route('admin.postingan.index')->with('success', 'Postingan Berhasil diubah statusnya');
    }
}

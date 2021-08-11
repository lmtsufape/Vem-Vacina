<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeedController extends Controller
{
    public function index()
    {
        $feeds = Feed::all();

        return view('admin.feed.index', compact('feeds'));
    }

    public function create()
    {
        
        return view('admin.feed.create');
    }
    
    public function store(Request $request)
    {

        $path = $request->file('image')->store(
            'feed/'.$request->user()->id, 'public'
        );
        $feed = Feed::create(['path' => $path]);

        return redirect()->route('admin.feed.index')->with(['message' => 'Adicionado com sucesso!']);
    }

    public function edit($id)
    {
        
        $feed = Feed::find($id);


        return view('admin.feed.edit', compact('feed'));
    }

    public function update(Request $request, $id)
    {
        $feed = Feed::find($id);

        Storage::disk('public')->delete($feed->path);

        $path = $request->file('image')->store(
            'feed/'.$request->user()->id, 'public'
        );
        $feed = $feed->update(['path' => $path]);
        
        return redirect()->route('admin.feed.index')->with(['message' => 'Atualizado com sucesso!']);
    }

    public function delete($id)
    {
        $feed = Feed::find($id);
        Storage::disk('public')->delete($feed->path);
        $feed->delete();

        return redirect()->route('admin.feed.index')->with(['message' => 'Apagado com sucesso!']);
    }

}

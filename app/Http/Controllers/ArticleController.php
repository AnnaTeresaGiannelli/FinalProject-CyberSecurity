<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\HtmlFilterService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth', except: ['index', 'show', 'byCategory', 'byUser', 'articleSearch']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::where('is_accepted', true)->orderBy('created_at', 'desc')->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, HtmlFilterService $htmlFilterService)
    {
        $request->validate([
            'title' => 'required|unique:articles|min:5',
            'subtitle' => 'required|min:5',
            'body' => 'required|min:10',
            'image' => 'required|image',
            'category' => 'required',
            'tags' => 'required'
        ]);

        $sanitizedBody = $htmlFilterService->sanitize($request->body);

        $article = Article::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'body' => $sanitizedBody,
            'image' => $request->file('image')->store('public/images'),
            'category_id' => $request->category,
            'user_id' => Auth::user()->id,
            'slug' => Str::slug($request->title),
        ]);
        
        $tags = explode(',', $request->tags);

        foreach($tags as $i => $tag){
            $tags[$i] = trim($tag);
        }

        foreach($tags as $tag){
            $newTag = Tag::updateOrCreate([
                'name' => strtolower($tag)
            ]);
            $article->tags()->attach($newTag);
        }

        Log::info('Articolo creato', [
            'article_id' => $article->id,
            'title' => $article->title,
            'user_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'timestamp' => now(),
        ]);

        return redirect(route('homepage'))->with('message', 'Article created successfully! You can find it in Pending Articles on your panel.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        if(Auth::user()->id != $article->user_id){
            return redirect()->route('homepage')->with('alert', 'Not Authorized.');
        }
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article, HtmlFilterService $htmlFilterService)
    {
        $request->validate([
            'title' => 'required|min:5|unique:articles,title,' . $article->id,
            'subtitle' => 'required|min:5',
            'body' => 'required|min:10',
            'image' => 'image',
            'category' => 'required',
            'tags' => 'required'
        ]);

        $sanitizedBody = $htmlFilterService->sanitize($request->body);

        $article->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'body' => $sanitizedBody,
            'category_id' => $request->category,
            'user_id' => Auth::user()->id,
            'is_accepted' => null,
            'slug' => Str::slug($request->title),
        ]);

        if($request->image){
            Storage::delete($article->image);
            $article->update([
                'image' => $request->file('image')->store('public/images')
            ]);
        }
        
        $tags = explode(',', $request->tags);

        foreach($tags as $i => $tag){
            $tags[$i] = trim($tag);
        }

        $newTags = [];

        foreach($tags as $tag){
            $newTag = Tag::updateOrCreate([
                'name' => strtolower($tag)
            ]);
            $newTags[] = $newTag->id;
        }
        $article->tags()->sync($newTags);

        Log::info('Articolo modificato', [
            'article_id' => $article->id,
            'title' => $article->title,
            'user_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'timestamp' => now(),
        ]);

        $article->sendToRevision();

        return redirect(route('writer.dashboard'))->with('message', 'Article successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        foreach ($article->tags as $tag) {
            $article->tags()->detach($tag);
        }
        $article->delete();

        Log::info('Articolo eliminato', [
            'article_id' => $article->id,
            'title' => $article->title,
            'user_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'timestamp' => now(),
        ]);
        
        return redirect()->back()->with('message', 'Article successfully deleted.');
    }

    public function byCategory(Category $category){
        $articles = $category->articles()->where('is_accepted', true)->orderBy('created_at', 'desc')->get();
        return view('articles.by-category', compact('category', 'articles'));
    }
    
    public function byUser(User $user){
        $articles = $user->articles()->where('is_accepted', true)->orderBy('created_at', 'desc')->get();
        return view('articles.by-user', compact('user', 'articles'));
    }

    public function articleSearch(Request $request){
        $query = $request->input('query');
        $articles = Article::search($query)->where('is_accepted', true)->orderBy('created_at', 'desc')->get();
        return view('articles.search-index', compact('articles', 'query'));
    }
}

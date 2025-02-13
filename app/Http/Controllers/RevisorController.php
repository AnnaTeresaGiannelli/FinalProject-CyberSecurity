<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RevisorController extends Controller
{
    public function dashboard(){
        $unrevisionedArticles = Article::where('is_accepted', NULL)->get();
        $acceptedArticles = Article::where('is_accepted', true)->get();
        $rejectedArticles = Article::where('is_accepted', false)->get();
        
        return view('revisor.dashboard', compact('unrevisionedArticles', 'acceptedArticles', 'rejectedArticles'));
    }

    public function acceptArticle(Article $article){
        $article->is_accepted = true;
        $article->save();

        Log::info('Articolo accettato', [
            'article_id' => $article->id,
            'title' => $article->title,
            'revisore' => Auth::user()->name ?? Auth::user()->email
        ]);

        return redirect(route('revisor.dashboard'))->with('message', 'Article Published');
    }

    public function rejectArticle(Article $article){
        $article->is_accepted = false;
        $article->save();

        Log::info('Articolo rifiutato', [
            'article_id' => $article->id,
            'title' => $article->title,
            'azione' => 'rifiutato',
            'revisore' => Auth::user()->name ?? Auth::user()->email
        ]);

        return redirect(route('revisor.dashboard'))->with('message', 'Article Declined');
    }

    public function undoArticle(Article $article){
        $article->is_accepted = NULL;
        $article->save();

        Log::info('Articolo riportato in revisione', [
            'article_id' => $article->id,
            'title' => $article->title,
            'azione' => 'in revisione',
            'revisore' => Auth::user()->name ?? Auth::user()->email
        ]);
        
        return redirect(route('revisor.dashboard'))->with('message', 'Article back to review');
    }
}

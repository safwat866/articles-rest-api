<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::where('published',true)->paginate(10);
        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        $user->articles()->create($data);

        return response()->json([
            'message' => 'article ' . $request->title . ' added sucsessfully!'
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        Gate::authorize('view', $article);

        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $data = $request->validated();

        Gate::authorize('update', $article);

        $article->update($data);

        return response()->json([
            'message' => 'article ' . $request->title . ' updated successfuly.'
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $title = $article->title;

        Gate::authorize('delete', $article);

        $article->delete();

        return response()->json(
            ['message' => 'article '. $title . ' has been deleted'],201
        );
    }
}

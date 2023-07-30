<?php

namespace App\Services\v1;

use App\Models\v1\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ArticleServices 
{
    public function getArticles($request) {
    //   dd($request);
        $articles = Article::orderByDesc('published_at')
            ->when($request->date_from && $request->date_to, function(Builder $builder) use ($request) {
                $builder->whereBetween(DB::raw('DATE(published_at)'), [$request->date_from, $request->date_to]);
            })
            ->when($request->q, function(Builder $builder) use ($request) {
                $builder->where('title', 'like', "%{$request->q}%")
                        ->orWhere('author', 'like', "%{$request->q}%")
                        ->orWhere('content', 'like', "%{$request->q}%")
                        ->orWhere('description', 'like', "%{$request->q}%");
            })
            ->when($request->authors, function(Builder $builder) use ($request) {
                $builder->whereIn('author', explode(',',$request->authors));
            })
            ->when($request->sources, function(Builder $builder) use ($request) {
                $builder->whereIn('source_name', explode(',',$request->sources))->orWhereIn('source_id', explode(',',$request->sources));
            })
            ->paginate(16);

        return $articles;
    }

    public function getAuthors() {
        return Article::pluck('author')->unique()->all();
        
    }
    public function getSources() {
        return Article::pluck('source_name')->unique()->all();
        
    }
}

?>
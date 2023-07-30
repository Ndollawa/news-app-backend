<?php

namespace App\Http\Controllers\v1\Articles;


use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Article\GetArticlesRequest;
use App\Http\Resources\v1\Article\ArticlesResource;
use App\Services\v1\ArticleServices;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetArticlesRequest $request, ArticleServices $articleService)
    {
      $request->validated($request->all());
      return ArticlesResource::collection($articleService->getArticles($request));

    }

    /**
     * Display a listing of the article authors.
     */
    public function getAuthors(ArticleServices $articleService)
    {
      return $articleService->getAuthors();

    }

    /**
     * Display a listing of the article sources.
     */
    public function getSources(ArticleServices $articleService)
    {
      return $articleService->getSources();

    }

 
}

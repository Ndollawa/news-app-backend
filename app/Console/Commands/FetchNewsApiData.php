<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Article;


class FetchNewsApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:newsApiData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch News data 60secs from NewsApi.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
          // Calculate the date range
        $endDate = now()->toDateString();
        $startDate = now()->subDays(7)->toDateString();

         // Fetch data from the news source API
        $client = new Client();  
        
    $perPage = 3000; // Specify the number of articles you want per page
    $totalPages = 3; // Specify the total number of pages you want to retrieve

    // Fetch articles for each page
    for ($page = 1; $page <= $totalPages; $page++) {
        // Build the API request URL with the page parameter
        $url = "https://newsapi.org/v2/everything?q=global%20news&page=$page&from=$startDate&to=$endDate&sortBy=popularity&apiKey=".env('NEWSAPI_API_KEY');

        $response = $client->get($url);
        $articles = json_decode($response->getBody()->getContents(), true)['articles'];

        $statusCode = $response->getStatusCode();
        // $headers = $response->getHeaders();
        // $body = $response->getBody()->getContents();
        // $data = json_decode($body, true);
        // Store non-duplicate data in the database
        // dd($articles);
        if($statusCode >= 200 && $statusCode < 300){
        foreach (array_reverse($articles) as $article) {
            $existingArticle = Article::where('title', $article['title'])->where('article_url',$article['url'])->first();

            if (!$existingArticle) {
                // Create a new record in the database
                Article::create([
                    'title' => $article['title'],
                    'source_id' => $article['source']['id'],
                    'source_name' => $article['source']['name'],
                    'source' => 'New York Times',
                    'content' => $article['content'],
                    // 'category' => $article['id'],
                    'author' => $article['author'],
                    'image_url' => $article['urlToImage'],
                    'article_url' => $article['url'],
                    'published_at' => date_format(date_create($article['publishedAt']),'Y-m-d H:i:s'),
                    'description' => $article['description']
                ]);
            }
        }
    }

    }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Article;
  

class FetchTheGuardianApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:theGuardianApiData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch News data 60secs from The Guardian News Api.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Fetch data from the news source API
       $client = new Client();
      // Fetch articles from The Guardian News API
      $guardianResponse = $client->get('https://content.guardianapis.com/search?&page-size=200&api-key='.env('THEGUARDIAN_API_KEY'));
      $guardianArticles = json_decode($guardianResponse->getBody()->getContents(), true)['response']['results'];
  
        $statusCode = $guardianResponse->getStatusCode();
        // $headers = $guardianResponse->getHeaders();
        // $body = $guardianResponse->getBody()->getContents();
        // $data = json_decode($body, true);

        // $newsData =  $data; // Fetch data using the appropriate API or library
// dd($guardianArticles);

if($statusCode >= 200 && $statusCode < 300){
        // Store non-duplicate data in the database
        foreach (array_reverse($guardianArticles) as $article) {
            $existingArticle = Article::where('source_id', $article['id'])->where('article_url' , $article['webUrl'])->where( 'title', $article['webTitle'])->first();
          
            if (!$existingArticle) {
                // Create a new record in the database
                Article::create([
                    'source_id' => $article['id'],
                    'source' => 'The Guardian',
                    // 'description' => $article['fields'],
                    'title' => $article['webTitle'],
                    'article_url' => $article['webUrl'],
                    'source_name' => "The Guardian | ".$article['sectionName'],
                    // 'content' => $article['content'],
                    'category' => $article['sectionName'],
                    // 'author' => $article['author'],
                    // 'image_url' => $article['urlToImage'],
                    'published_at' => date_format(date_create($article['webPublicationDate']),'Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
}

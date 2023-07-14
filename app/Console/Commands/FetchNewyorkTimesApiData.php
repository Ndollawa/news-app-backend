<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Article;
  

class FetchNewyorkTimesApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:newyorkTimesApiData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch News data 60secs from NewyorkTimes Api.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Fetch data from the news source API
       $client = new Client();
      // Fetch articles from New York Times API
        $nytResponse = $client->get('https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key='.env('NYT_API_KEY'));
        $nytArticles = json_decode($nytResponse->getBody()->getContents(), true)['response']['docs'];

        $statusCode = $nytResponse->getStatusCode();
        // $headers = $nytResponse->getHeaders();
        // $body = $nytResponse->getBody()->getContents();
        // $data = json_decode($body, true);

        // $newsData =  $data; // Fetch data using the appropriate API or library
// dd($nytArticles);

if($statusCode >= 200 && $statusCode < 300){
        // Store non-duplicate data in the database
        foreach (array_reverse($nytArticles) as $article) {
            $existingArticle = Article::where('source_id', $article['_id'])->where('article_url' , $article['web_url'])->first();
            if (!$existingArticle) {
                // Create a new record in the database
                Article::create([
                    'source_id' => $article['_id'],
                    'source_name' => $article['source'],
                    'source' => 'The New York Times',
                    'content' => $article['lead_paragraph'],
                    'category' => $article['type_of_material'],
                    'author' => $article['byline']['person'][0]['firstname']." ".$article['byline']['person'][0]['middlename']." ".$article['byline']['person'][0]['lastname'],
                    'image_url' => $article['multimedia'][0]['url'],
                    'article_url' => $article['web_url'],
                    'published_at' => date_format(date_create($article['pub_date']),'Y-m-d H:i:s'),
                    'description' => $article['abstract'],
                    'title' => $article['headline']['main'],
                    // Store other relevant data
                ]);
            }
        }
    }
}
}

<?php

namespace App\Console\Commands;

use App\Models\Youtube as ModelYoutube;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Youtube extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save yotube data to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("Cron Job Youtube running at " . now());

        $youtubeKey = env('YOUTUBE_KEY');

        $url = "https://www.googleapis.com/youtube/v3/search?key=".$youtubeKey."&channelId=UCh6HstgGZcDf7J_oVd2A_EQ&part=snippet&maxResults=10&order=date";
        
        $response = Http::get($url);
        $datas = $response->json()['items'];

        if (!empty($datas)) {
            ModelYoutube::truncate();

            foreach ($datas as $item) {
                $dataThumbnails = [
                    'default' => $item['snippet']['thumbnails']['default']['url'],
                    'medium' => $item['snippet']['thumbnails']['medium']['url'],
                    'high' => $item['snippet']['thumbnails']['high']['url'],
                ];

                ModelYoutube::create([
                    'e_tag' => $item['etag'],
                    'vidio_id' => $item['id']['videoId'],
                    'channel_id' => $item['snippet']['channelId'],
                    'title' => $item['snippet']['title'],
                    'description' => $item['snippet']['description'],
                    'thumbnails' => json_encode($dataThumbnails),
                    'channelTitle' => $item['snippet']['channelTitle'],
                    'publishedAt' => Carbon::parse($item['snippet']['publishedAt'])
                ]);
            }
        }
    }
}

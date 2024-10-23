<?php

namespace App\Console\Commands;

use App\Models\InstagramToken;
use Illuminate\Console\Command;

class Instagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instagram:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instagram access token update';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("Cron Job Instagram running at " . now());

        $baseUrl = "https://graph.instagram.com/refresh_access_token?";

        $instagramToken = InstagramToken::select('access_token')->latest()->first();
        $accessToken = env('INSTAGRAM_TOKEN2');

        if ($instagramToken != null) {
            $accessToken = $instagramToken->access_token;
        }
        
        $params = array(
            'grant_type' => 'ig_refresh_token',
            'access_token' => $accessToken
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responseText = curl_exec($ch);
        $result = json_decode($responseText, true);

        curl_close($ch);


        if ($newAccessToken = $result['access_token']) {
            $instagramToken = new InstagramToken();
            $instagramToken->access_token = $newAccessToken;
            $instagramToken->token_type = $result['token_type'];
            $instagramToken->expires_in = $result['expires_in'];
            $instagramToken->save();
        }
    }
}

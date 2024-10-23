<?php

namespace App\Http\Controllers;

use App\Models\InstagramToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class InstagramController extends Controller
{   
    private function makeCurlRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
  

    public function index()
    {
        $baseUrl = "https://graph.instagram.com/me/media?";

        $instagramToken = InstagramToken::select('access_token')->latest()->first();

        // dd($instagramToken);

        $accessToken = env('INSTAGRAM_TOKEN2');

        if ($instagramToken != null) {
            $accessToken = $instagramToken->access_token;
        }

        $params = array(
            'fields' => implode(',', array('id', 'caption', 'permalink', 'media_url', 'media_type', 'thumbnail_url', 'is_shared_to_feed', 'username', 'timestamp')),
            'access_token' => $accessToken,
            'limit' => 20
        );

        $url = $baseUrl . http_build_query($params);
        $result = $this->makeCurlRequest($url);

        // return response()->json($result);

        return view('instagram', [
            'mediaData' => $result['data'],
            'paging' => $result['paging']
        ]);
    }

    // public function detailMedia($id)
    // {
    //     try {
    //         $instagramToken = InstagramToken::select('access_token')->latest()->first();

    //         // dd($instagramToken);
            
    //         $accessToken = env('INSTAGRAM_TOKEN');

    //         if ($instagramToken->access_token) {
    //             $accessToken = $instagramToken->access_token;
    //         }
            
    //         $mediaId = $id;

    //         $urlGetAllMediaId = 'https://graph.instagram.com/' . $mediaId . '/children?access_token=' . $accessToken . '';

    //         $result = $this->makeCurlRequest($urlGetAllMediaId);

    //         if (count($result['data']) != 0) {
    //             // $resultMediaUrl = [];
                
    //             foreach ($result['data'] as $value) {
    //                 $idMediaSpecific = $value['id'];
                    
    //                     $urlSpecificMedia = 'https://graph.instagram.com/' . $idMediaSpecific . '?fields=id,media_type,media_url&access_token=' . $accessToken . '';
    //                     $resultSpecificMedia = $this->makeCurlRequest($urlSpecificMedia);
                        
    //                     // $resultMediaUrl[] = $resultSpecificMedia['media_url'];
    //                     $resultMediaUrl[] = [
    //                         'media_url_of' => $resultSpecificMedia['media_url'],
    //                         'media_type_of' => $resultSpecificMedia['media_type']
    //                     ];
    //                 }
    //                 $urlMediaById = 'https://graph.instagram.com/' . $mediaId . '?fields=id,media_type,media_url,thumbnail_url,caption,permalink,username,is_shared_to_feed,timestamp&access_token=' . $accessToken . '';
    //                 $resultMedia = $this->makeCurlRequest($urlMediaById);
    //                 $resultMedia['media_url'] = $resultMediaUrl;


    //         } else {
    //             $urlMediaById = 'https://graph.instagram.com/' . $mediaId . '?fields=id,media_type,media_url,thumbnail_url,caption,permalink,username,is_shared_to_feed,timestamp&access_token=' . $accessToken . '';

    //             $resultMedia = $this->makeCurlRequest($urlMediaById);
    //             $resultMediaUrl[] = [
    //                 'media_url_of' => $resultMedia['media_url'],
    //                 'media_type_of' => $resultMedia['media_type']
    //             ];
    //             $resultMedia['media_url'] = $resultMediaUrl;
    //         }

    //         return response()->json(['items' => $resultMedia]);
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => 'Terjadi kesalahan dalam mengambil data media.']);
    //     }
    // }
}

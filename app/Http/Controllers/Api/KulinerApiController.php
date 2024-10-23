<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreKulinerRequest;
use App\Http\Requests\UpdateKulinerRequest;
use App\Models\Wisatawan;
use App\Models\ReviewRatingKuliner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\KulinerResource;
use App\Models\Kuliner;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KulinerApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
{
    // Mendapatkan semua Kuliner yang aktif beserta relasinya
    $datakuliner = Kuliner::where('active', 1)->with(['kulinerproduk', 'created_by'])->get();

    // Loop melalui setiap Kuliner untuk mendapatkan review dan rata-rata rating
    $kuliners = $datakuliner->map(function($kuliner) {
        $reviews = ReviewRatingKuliner::where('kuliner_id', $kuliner->id)
            ->where('status', 'active')
            ->get();

        $averageRating = $reviews->isNotEmpty() ? round($reviews->avg('star_rating'), 1) : 0;

        // Mengkonversi model Kuliner ke KulinerResource
        $kulinerResource = new KulinerResource($kuliner);
        $kulinerResource->average_rating = $averageRating;

        return $kulinerResource;
    });

    return response()->json([
        'message' => 'Data Kuliner',
        'success' => true,
        'data' => $kuliners
    ], 200);
}



public function show($id)
{
    if (isset($id)) {
        $kuliner = Kuliner::with(['kulinerproduk' => function($query) {
            $query->where('active', 1);
        }])->findOrFail($id);
        
        // Ambil ulasan untuk kuliner ini
        $reviews = ReviewRatingKuliner::where('kuliner_id', $kuliner->id)
            ->where('status', 'active')
            ->get();
        
        // Periksa apakah pengguna sudah memberikan ulasan
        $userReview = null;
        $wisatawan = Auth::guard('wisatawans')->user();
        if ($wisatawan) {
            $userReview = ReviewRatingKuliner::where('kuliner_id', $kuliner->id)
                ->where('wisatawan_id', $wisatawan->id)
                ->where('status', 'active')
                ->first();
        }
        
        // Hitung rata-rata rating
        $averageRating = $reviews->isNotEmpty() ? round($reviews->avg('star_rating'), 1) : 0;
        
        // Hitung jumlah ulasan berdasarkan kategori rating
        $ratingCounts = $reviews->groupBy('star_rating')->map->count();

        // Tambahkan rating 0 jika kategori rating tidak ada
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingCounts[$i])) {
                $ratingCounts[$i] = 0;
            }
        }

        // Hitung jumlah pengguna yang memberikan rating pada setiap kategori rating
        $userRatingCounts = $reviews->count();
        
        // Transformasi ulasan untuk menambahkan nama wisatawan
        $transformedReviews = $reviews->map(function ($review) {
            $wisatawanName = Wisatawan::find($review->wisatawan_id)->name;
            return [
                'id' => $review->id,
                'wisatawan_id' => $review->wisatawan_id,
                'wisatawan_name' => $wisatawanName,
                'comments' => $review->comments,
                'star_rating' => $review->star_rating,
                'created_at' => $review->created_at,
                'updated_at' => $review->updated_at,
            ];
        });

        return response()->json([
            'message' => 'Kuliner data retrieved successfully',
            'success' => true,
            'data' => [
                'kuliner' => $kuliner,
                'reviews' => $transformedReviews,
                'userReview' => $userReview,
                'averageRating' => $averageRating,
                'ratingCounts' => $ratingCounts,
                'userRatingCounts' => $userRatingCounts,
            ]
        ], 200);
    } else {
        $kuliners = Kuliner::with(['kulinerproduk' => function($query) {
            $query->where('active', 1);
        }])->get();

        return response()->json([
            'message' => 'Data Kuliner',
            'success' => true,
            'data' => $kuliners
        ], 200);
    }
}



public function storeReview(Request $request, $id)
{
    // Validate request data
    $request->validate([
        'comment' => 'nullable|string',
        'rating' => 'required|integer|min:1|max:5',
        'wisatawan_id' => 'required|integer',
    ]);

    try {
        // Find the kuliner by ID
        $kuliner = Kuliner::findOrFail($id);

        // Create new review
        $review = new ReviewRatingKuliner();
        $review->kuliner_id = $kuliner->id;
        $review->comments = $request->comment;
        $review->star_rating = $request->rating;
        $review->wisatawan_id = $request->wisatawan_id;
        $review->status = 'active'; // Assuming you want to set it active by default
        $review->save();

        return response()->json(['message' => 'Your review has been submitted successfully.', 'success' => true], 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to store review.', 'success' => false], 500);
    }
}

public function updateReview(Request $request, $id, $reviewId)
{
$request->validate([
    'comment' => 'required|string',
    'rating' => 'required|integer|min:1|max:5',
    'wisatawan_id' => 'required|integer',
]);

try {
    $review = ReviewRatingKuliner::findOrFail($reviewId);

    // Pastikan hanya pemilik ulasan yang bisa melakukan update
    if ($review->wisatawan_id !== $request->wisatawan_id) {
        return response()->json(['message' => 'Unauthorized action.', 'success' => false], 403);
    }

    // Lakukan update ulasan
    $review->update([
        'comments' => $request->comment,
        'star_rating' => $request->rating,
    ]);

    return response()->json(['message' => 'Your review has been updated successfully.', 'success' => true], 200);
} catch (\Exception $e) {
    return response()->json(['message' => 'Failed to update review.', 'success' => false], 500);
}
}



    
}

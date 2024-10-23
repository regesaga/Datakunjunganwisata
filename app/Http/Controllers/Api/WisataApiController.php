<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWisataRequest;
use App\Http\Requests\UpdateWisataRequest;
use App\Http\Resources\WisataResource;
use App\Models\ReviewRatingWisata;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Wisatawan;
use App\Models\Wisata;
use App\Models\Company;
use App\Models\HargaTiket;
use App\Models\Kecamatan;
use App\Models\CategoryWisata;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WisataApiController extends Controller
{
    use MediaUploadingTrait;

 public function index()
{
  // Get all active Wisata with related models
  $datawisata = Wisata::where('active', 1)
  ->with(['hargatiket', 'fasilitas', 'created_by']) 
  ->get();

// Loop through each Wisata to get reviews and average rating
$wisatas = $datawisata->map(function($wisata) {
  $reviews = ReviewRatingWisata::where('wisata_id', $wisata->id)
      ->where('status', 'active')
      ->get();

  $averageRating = $reviews->isNotEmpty() ? round($reviews->avg('star_rating'), 1) : 0;

  // Convert Wisata model to WisataResource
  $wisataResource = new WisataResource($wisata);
  $wisataResource->average_rating = $averageRating;

  return $wisataResource;
});

return response()->json([
  'message' => 'Data Wisata',
  'success' => true,
  'data' => $wisatas
], 200);
}

    

   
// Contoh implementasi dalam controller
public function show($id)
{
    if (isset($id)) {
        $wisata = Wisata::with(['hargatiket', 'fasilitas', 'created_by'])->findOrFail($id);

        // Ambil ulasan untuk wisata ini
        $reviews = ReviewRatingWisata::where('wisata_id', $wisata->id)
            ->where('status', 'active')
            ->get();

            // Periksa apakah pengguna sudah memberikan ulasan
        $userReview = null;
        $wisatawan = Auth::guard('wisatawans')->user();
        if ($wisatawan) {
            $userReview = ReviewRatingWisata::where('wisata_id', $wisata->id)
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
            $wisatawanName = Wisatawan::find($review->wisatawan_id)->name; // Ubah sesuai dengan model dan nama kolom Anda
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
            'message' => 'Wisata data retrieved successfully',
            'success' => true,
            'data' => [
                'wisata' => $wisata,
                'reviews' => $transformedReviews,
                'userReview' => $userReview,
                'averageRating' => $averageRating,
                'ratingCounts' => $ratingCounts,
                'userRatingCounts' => $userRatingCounts,
            ]
        ], 200);
    } else {
        $wisatas = Wisata::with(['hargatiket', 'fasilitas', 'created_by'])->get();
        return response()->json([
            'message' => 'Data Wisata',
            'success' => true,
            'data' => $wisatas
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
        // Find the wisata by ID
        $wisata = Wisata::findOrFail($id);

        // Create new review
        $review = new ReviewRatingWisata();
        $review->wisata_id = $wisata->id;
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
    $review = ReviewRatingWisata::findOrFail($reviewId);

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
   


    // function store(WisataRequest $request)
    // {
    //     $wisata = Wisata::create($request->all());
    //     return response()->json(['msg' => 'Data created', 'data' => $wisata], 201);
    // }

    // function update($id, WisataRequest $request)
    // {
    //     $wisata = Wisata::findOrFail($id);
    //     $wisata->update($request->all());
    //     return response()->json(['msg' => 'Data updated', 'data' => $wisata], 200);
    // }

    // function destroy($id)
    // {
    //     $wisata = Wisata::findOrFail($id);
    //     $wisata->delete();
    //     return response()->json(['msg' => 'Data deleted'], 200);
    // }
}

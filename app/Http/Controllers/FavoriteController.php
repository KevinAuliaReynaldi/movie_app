<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

/**
 * FavoriteController menangani pengelolaan film favorit pengguna.
 */
class FavoriteController extends Controller
{
    /**
     * Menampilkan daftar film favorit.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $favorites = Favorite::orderBy('created_at', 'desc')->get();
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Menyimpan favorit baru ke penyimpanan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required|string',
            'title' => 'required|string',
            'year' => 'required|string',
            'type' => 'required|string',
            'poster' => 'nullable|string'
        ]);

        try {
            $favorite = Favorite::updateOrCreate(
                ['imdb_id' => $request->imdb_id],
                [
                    'title' => $request->title,
                    'year' => $request->year,
                    'type' => $request->type,
                    'poster' => $request->poster
                ]
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.favorite_added'),
                'data' => $favorite
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.favorite_add_failed')
            ], 500);
        }
    }

    /**
     * Menghapus favorit yang ditentukan dari penyimpanan.
     *
     * @param  string  $id  ID IMDB dari favorit yang akan dihapus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $favorite = Favorite::where('imdb_id', $id)->first();

            if ($favorite) {
                $favorite->delete();
                return response()->json([
                    'success' => true,
                    'message' => __('messages.favorite_removed')
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => __('messages.favorite_not_found')
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.favorite_remove_failed')
            ], 500);
        }
    }

    /**
     * Cek apakah film ada di favorit.
     *
     * @param  string  $id  ID IMDB yang akan dicek
     * @return \Illuminate\Http\JsonResponse
     */
    public function check($id)
    {
        $exists = Favorite::where('imdb_id', $id)->exists();
        return response()->json(['is_favorite' => $exists]);
    }
}

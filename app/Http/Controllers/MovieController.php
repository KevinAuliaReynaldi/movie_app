<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Favorite;

/**
 * MovieController menangani operasi yang berkaitan dengan film seperti 
 * pencarian, menampilkan daftar, dan detail film dari API OMDB.
 */
class MovieController extends Controller
{
    private $apiKey;
    private $apiUrl;

    /**
     * Menginisialisasi controller dengan kredensial API OMDB.
     */
    public function __construct()
    {
        $this->apiKey = env('OMDB_API_KEY');
        $this->apiUrl = env('OMDB_API_URL');
    }

    /**
     * Menampilkan halaman pencarian film.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('movies.index');
    }

    /**
     * Mencari film menggunakan API OMDB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array  Respon JSON dari API OMDB
     */
    public function search(Request $request)
    {
        $title = $request->query('title');
        $year = $request->query('year');
        $type = $request->query('type');
        $page = $request->query('page', 1);

        $response = Http::get($this->apiUrl, [
            'apikey' => $this->apiKey,
            's' => $title,
            'y' => $year,
            'type' => $type,
            'page' => $page
        ]);

        return $response->json();
    }

    /**
     * Menampilkan detail dari film tertentu.
     *
     * @param  string  $id  ID IMDB dari film
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $response = Http::get($this->apiUrl, [
            'apikey' => $this->apiKey,
            'i' => $id,
            'plot' => 'full'
        ]);

        $movie = $response->json();

        if (isset($movie['Error'])) {
            return redirect()->route('movies.index')->with('error', __('messages.movie_not_found'));
        }

        // Cek apakah film sudah ada di favorit pengguna
        $movie['is_favorite'] = Favorite::where('imdb_id', $id)->exists();

        return view('movies.show', compact('movie'));
    }
}

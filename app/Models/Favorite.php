<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Favorite
 * 
 * Merepresentasikan film favorit pengguna.
 */
class Favorite extends Model
{
    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'imdb_id',
        'title',
        'year',
        'type',
        'poster'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
    use HasFactory;
    
    protected $table = 'nrh_billets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nominal',
        'quantite',
        'caisse_id',
    ];

    /**
     * Get the caisse that owns the billet.
     */
    public function caisse()
    {
        return $this->belongsTo(Caisse::class, 'caisse_id', 'id');
    }
}

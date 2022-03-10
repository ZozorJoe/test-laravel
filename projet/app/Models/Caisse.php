<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    use HasFactory;
    
    protected $table = 'nrh_caisses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'note',
        'operation_id',
    ];

    /**
     * Get the operation that owns the caisse.
     */
    public function operation()
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }

    /**
     * Get thes billets that owns the caisse.
     */
    public function billets()
    {
        return $this->hasMany(Billet::class, 'caisse_id', 'id');
    }

    /**
     * Get thes pieces that owns the caisse.
     */
    public function pieces()
    {
        return $this->hasMany(Piece::class, 'caisse_id', 'id');
    }

    /**
     * Get thes centimes that owns the caisse.
     */
    public function centimes()
    {
        return $this->hasMany(Centime::class, 'caisse_id', 'id');
    }
}

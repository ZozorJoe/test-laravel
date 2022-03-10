<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    
    protected $table = 'nrh_operations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cle',
        'valeur',
    ];

    /**
     * Get thes caisses that owns the operation.
     */
    public function caisses()
    {
        return $this->hasMany(Caisse::class, 'caisse_id', 'id');
    }
}

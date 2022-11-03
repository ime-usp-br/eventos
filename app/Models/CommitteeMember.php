<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'bancaID',
        'vinculo',
        'nome',
        'codpes',
        'sexo',
        'staptp',
    ];

    protected $hidden = [
        'id',
        'codpes',
        'bancaID',
        "created_at",
        "updated_at",
    ];

    public function banca()
    {
        $this->belongsTo(Committee::class, "bancaID");
    }
}

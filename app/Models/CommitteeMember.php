<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Committee;
use App\Models\Institution;

class CommitteeMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'instituicaoID',
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
        return $this->belongsTo(Committee::class, "bancaID");
    }

    public function instituicao()
    {
        return $this->belongsTo(Institution::class, "instituicaoID");
    }
}

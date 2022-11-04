<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommitteeMember;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sigla',
    ];
    
    public $timestamps = false;

    protected $hidden = [
        'id',
    ];

    public function membros()
    {
        return $this->hasMany(CommitteeMember::class, "instituicaoID");
    }
}

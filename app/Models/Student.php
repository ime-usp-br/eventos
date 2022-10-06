<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "nome",
        "codpes",
        "sexo",
    ];

    protected $hidden = [
        'id',
        'codpes',
        'pivot',
        "created_at",
        "updated_at",
    ];

    public function orientadores()
    {
        return $this->belongsToMany(Advisor::class);
    }

    public function defesas()
    {
        return $this->hasMany(Defense::class, "alunoID");
    }

    public function trabalhos()
    {
        return $this->hasMany(Thesis::class, "alunoID");
    }
}

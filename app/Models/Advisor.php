<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Advisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'nome',
        'codpes',
        'sexo',
    ];

    protected $hidden = [
        'id',
        'codpes',
        'pivot',
        "created_at",
        "updated_at",
    ];

    public function orientandos()
    {
        return $this->belongsToMany(Student::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Defense;

class Thesis extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'title',
        'resumo',
        'abstract',
        'palavrasChave',
        'keyWords',
        'alunoID',
        'defesaID',
    ];

    protected $hidden = [
        'id',
        'alunoID',
        'defesaID',
        "created_at",
        "updated_at",
    ];

    public function aluno()
    {
        $this->belongsTo(Student::class, 'alunoID');
    }

    public function defesa()
    {
        $this->belongsTo(Defense::class, "defesaID");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Thesis;
use App\Models\Committee;
use Carbon\Carbon;

class Defense extends Model
{
    use HasFactory;

    protected $fillable = [
        'nivel',
        'programa',
        'data',
        'horario',
        'local',
        'alunoID',
    ];

    protected $hidden = [
        'id',
        'alunoID',
        "created_at",
        "updated_at",
    ];

    protected $casts = [
        'data' => 'date:d/m/Y',
        'horario' => 'datetime:H:i',
    ];

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = $value ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getDataAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function setHorarioAttribute($value)
    {
        $this->attributes['horario'] = $value ? Carbon::createFromFormat('H:i', $value) : null;
    }

    public function getHorarioAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function aluno()
    {
        return $this->belongsTo(Student::class, "alunoID");
    }

    public function trabalho()
    {
        return $this->hasOne(Thesis::class, "defesaID");
    }

    public function banca()
    {
        return $this->hasOne(Committee::class, "defesaID");
    }
}
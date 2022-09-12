<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'caminhoArquivo',
        'eventoID',
    ];
    
    public $timestamps = false;

    public function evento()
    {
        return $this->belongsTo(Event::class, "eventoID");
    }
}

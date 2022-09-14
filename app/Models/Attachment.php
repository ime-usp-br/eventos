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
        'link',
    ];
    
    public $timestamps = false;

    protected $hidden = [
        'id',
        'caminhoArquivo',
        'eventoID',
    ];

    public function evento()
    {
        return $this->belongsTo(Event::class, "eventoID");
    }
}

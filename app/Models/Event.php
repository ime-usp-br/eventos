<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attachment;
use App\Models\Modality;
use App\Models\Kind;
use App\Models\Language;
use App\Models\Location;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'cadastradorID',
        'dataInicial',
        'dataFinal',
        'horarioInicial',
        'horarioFinal',
        'localID',
        'exigeInscricao',
        'gratuito',
        'emiteCertificado',
        'idiomaID',
        'nomeOrganizador',
        'descricao',
        'aprovado',
        'moderadorID',
        'dataAprovacao',
        'modalidadeID',
        'tipoID',
    ];

    protected $casts = [
        'dataAprovacao' => 'date:d/m/Y',
        'dataInicial' => 'date:d/m/Y',
        'dataFinal' => 'date:d/m/Y',
        'horarioInicial' => 'datetime:H:i',
        'horarioFinal' => 'datetime:H:i',
    ];

    protected $hidden = [
        "id",
        "cadastradorID",
        "idiomaID",
        "localID",
        "moderadorID",
        "modalidadeID",
        "tipoID",
        "created_at",
        "updated_at",
        "dataAprovacao",
        'aprovado',
    ];

    public function setDataAprovacaoAttribute($value)
    {
        $this->attributes['dataAprovacao'] = $value ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getDataAprovacaoAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }

    public function setDataInicialAttribute($value)
    {
        $this->attributes['dataInicial'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getDataInicialAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }

    public function setDataFinalAttribute($value)
    {
        $this->attributes['dataFinal'] = $value ? Carbon::createFromFormat('d/m/Y', $value) : null;
    }

    public function getDataFinalAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }

    public function setHorarioInicialAttribute($value)
    {
        $this->attributes['horarioInicial'] = Carbon::createFromFormat('H:i', $value);
    }

    public function getHorarioInicialAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : '';
    }

    public function setHorarioFinalAttribute($value)
    {
        $this->attributes['horarioFinal'] = $value ? Carbon::createFromFormat('H:i', $value) : null;
    }

    public function getHorarioFinalAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : '';
    }

    public function anexos()
    {
        return $this->hasMany(Attachment::class, "eventoID");
    }

    public function modalidade()
    {
        return $this->belongsTo(Modality::class, "modalidadeID");
    }

    public function tipo()
    {
        return $this->belongsTo(Kind::class, "tipoID");
    }

    public function idioma()
    {
        return $this->belongsTo(Language::class, "idiomaID");
    }

    public function local()
    {
        return $this->belongsTo(Location::class, "localID");
    }

    public function criador()
    {
        return $this->belongsTo(User::class, "cadastradorID");
    }

    public function moderador()
    {
        return $this->belongsTo(User::class, "moderadorID");
    }
}

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
        'googleAgendaId',
        'googleEventoId'
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

    public function getGoogleEvent()
    {
        $start = Carbon::createFromFormat("d/m/Y-H:i", $this->dataInicial."-".$this->horarioInicial)->format("Y-m-d\\TH:i:s")."-03:00";
        if($this->horarioFinal){
            $end = Carbon::createFromFormat("d/m/Y-H:i", $this->dataInicial."-".$this->horarioFinal)->format("Y-m-d\\TH:i:s")."-03:00";
        }else{
            $end = Carbon::createFromFormat("d/m/Y-H:i", $this->dataInicial."-".$this->horarioInicial)->format("Y-m-d\\TH:i:s")."-03:00";
        }

        $evento_array = array(
            'summary' => $this->titulo,
            'description' => $this->descricao,
            'start' => array(
              'dateTime' => $start,
              'timeZone' => 'America/Sao_Paulo',
            ),
            'end' => array(
              'dateTime' => $end,
              'timeZone' => 'America/Sao_Paulo',
            ),
        );

        if($this->dataFinal){
            $evento_array["recurrence"] = [
                "RRULE:FREQ=WEEKLY;WKST=SU;UNTIL=".Carbon::createFromFormat("d/m/Y", $this->dataFinal)->format("Ymd\\T235959\\Z").";BYDAY=FR,MO,TH,TU,WE",
            ];
        }
        
        return new \Google\Service\Calendar\Event($evento_array);
    }
}

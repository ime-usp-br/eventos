<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Defense;
use App\Models\CommitteeMember;

class Committee extends Model
{
    use HasFactory;

    protected $fillable = [
        'defesaID',
    ];

    protected $hidden = [
        'id',
        'defesaID',
        "created_at",
        "updated_at",
    ];

    public function defesa()
    {
        return $this->belongsTo(Defense::class, "defesaID");
    }

    public function membros()
    {
        return $this->hasMany(CommitteeMember::class, "bancaID");
    }

    public function getPresidente()
    {
        return $this->membros()->where("vinculo", "Presidente")->first();
    }

    public function getTitulares()
    {   
        if($this->membros()->where("staptp",true)->exists()){
            return $this->membros()->where("staptp", true)->where("vinculo", "!=", "Presidente")->get();
        }else{
            return $this->membros()->where("vinculo", "Titular")->get();
        }
    }
}

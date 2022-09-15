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
}

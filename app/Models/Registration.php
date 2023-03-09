<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'eventoID',
        'fullName',
        'nickname',
        'email',
        'passport',
        'rg',
        'phone',
        'affiliation',
        'position',
        'department',
        'cep',
        'address',
        'city',
        'state',
        'country',
    ];

    public function evento()
    {
        return $this->belongsTo(Event::class, "eventoID");
    }
}

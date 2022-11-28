<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Uspdev\Replicado\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \Spatie\Permission\Traits\HasRoles;
    use \Uspdev\SenhaunicaSocialite\Traits\HasSenhaunica;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function booted()
    {
        static::created(function($user){
            $codpes = $user->codpes;

            $query = " SELECT *";
            $query .= " FROM VINCULOPESSOAUSP AS VP";
            $query .= " WHERE VP.codpes = :codpes";
            $query .= " AND VP.tipfnc = :tipfnc";
            $query .= " AND VP.codund = :codund";
            $param = [
                'codpes' => $codpes,
                'tipfnc' => "Docente",
                'codund' => "45",
            ];
    
            $eh_doc = array_unique(DB::fetchAll($query, $param),SORT_REGULAR);

            if($eh_doc){
                $user->assignRole("Operador");
            }
        });
    }
}

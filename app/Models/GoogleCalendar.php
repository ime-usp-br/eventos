<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'refreshToken',
        'agendaId',
    ];

    public function getGoogleService()
    {
        if($this->refreshToken){
            $client = new \Google\Client();
            $client->setAuthConfig(env("GOOGLE_CLIENT_SECRET"));
            $client->addScope("https://www.googleapis.com/auth/calendar");
            $client->fetchAccessTokenWithRefreshToken($this->refreshToken);

            if($client->getAccessToken()){
                return new \Google\Service\Calendar($client);
            }
        }

        return null;
    }
}

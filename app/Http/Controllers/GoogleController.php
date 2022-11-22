<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GoogleCallBackRequest;
use App\Models\GoogleCalendar;
use Session;

class GoogleController extends Controller
{
    public function login()
    {
        $client = new \Google\Client();
        $client->setAuthConfig(env("GOOGLE_CLIENT_SECRET"));
        $client->addScope("https://www.googleapis.com/auth/calendar");
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $client->setLoginHint(env('MAIL_USERNAME'));
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        $auth_url = $client->createAuthUrl();

        return redirect()->away($auth_url);
    }

    public function callback(GoogleCallBackRequest $request)
    {
        $validated = $request->validated();
        if(isset($validated["code"]) and $validated["code"]){
            $client = new \Google\Client();
            $client->setAuthConfig(env("GOOGLE_CLIENT_SECRET"));
            $client->addScope("https://www.googleapis.com/auth/calendar");
            $client->addScope("https://www.googleapis.com/auth/userinfo.email");
            $client->fetchAccessTokenWithAuthCode($validated["code"]);
    
            $auth = new \Google\Service\Oauth2($client);
    
            if($client->getAccessToken()){
                $gc = GoogleCalendar::updateOrCreate([
                    'email'=>$auth->userinfo->get()->email
                ],[
                    'refreshToken'=>$client->getAccessToken()["refresh_token"]
                ]);
    
                $service = new \Google\Service\Calendar($client);

                foreach($service->calendarList->listCalendarList()->getItems() as $c){
                    if($c->getSummary()=="IME Eventos"){
                        $gc->agendaId = $c->getId();
                        $gc->save();
                    }
                }

                if(!$gc->agendaId){    
                    $newcalendar = new \Google\Service\Calendar\Calendar();
                    $newcalendar->setSummary("IME Eventos");
                    $newcalendar->setTimeZone("America/Sao_Paulo");
    
                    $newcalendar = $service->calendars->insert($newcalendar);
    
                    $gc->agendaID = $newcalendar->getId();
                    $gc->save();
                }
                Session::flash("alert-success", "Conta do Google cadastrada com sucesso");
            }else{
                Session::flash("alert-warning", "Não foi possivel pegar um token de acesso a conta do Google");
            }
        }else{
            Session::flash("alert-warning", "Não foi possivel logar na conta Google");
        }

        return redirect(route("users.index"));
    }
}

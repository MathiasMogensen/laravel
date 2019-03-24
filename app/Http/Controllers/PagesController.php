<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\LightOpenID;

class PagesController extends Controller
{
    public function index() {
        //return view('pages.index', compact('title'));
        return view('pages.index');
    }
    public function about() {
        $data = array(
            'array' => ['Something', 'Something else']
        );
        return view('pages.about')->with($data);
    }

    public function steam() {
            $message = "";
            $openid = new LightOpenID('localhost.trukslaravel');
            
            if(!$openid->mode) {
                $openid->identity = 'https://steamcommunity.com/openid';
                return redirect($openid->authUrl());
            } elseif ($openid->mode == 'cancel') {
                $message .= ' Authentication has been cancelled!';
            } else {
                if($openid->validate()) { 
                    $id = $openid->identity;
                    $ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                    preg_match($ptn, $id, $matches);

                    $url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=26D6248719B1D26624DB6CE190D51AA4&steamids=".$matches[1]); 
                    $content = json_decode($url, true);
                    $steamid = $content['response']['players'][0]['steamid'];
                    
                    session()->put('steamName', $content['response']['players'][0]['personaname']);
                    session()->put('steamid', $steamid);

                }
            }
        $data = [
            'message' => $content
        ];
        return redirect('/steam')->with('message', $content);
    }
    public function steamShow() {
        return view('pages.steam');
    }
    public function steamLogout (){
        session()->forget('steamid');
        session()->forget('steamName');
        return redirect('/steam');
    }
}

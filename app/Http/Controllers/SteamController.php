<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\LightOpenID;

class SteamController extends Controller
{
    public function index() {
        return view('pages.steam');
    }

    public function login() {
        
        if (empty(session('steamName'))) {
            $openid = new LightOpenID(url('/'));
            $content = "";
            if(!$openid->mode) {
                $openid->identity = 'https://steamcommunity.com/openid';
                return redirect($openid->authUrl());
            } elseif ($openid->mode == 'cancel') {
                $content = ' Authentication has been cancelled!';
            } else {
                if($openid->validate()) { 
                    $id = $openid->identity;
                    $ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                    preg_match($ptn, $id, $matches);
    
                    $url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=26D6248719B1D26624DB6CE190D51AA4&steamids=".$matches[1]); 
                    $content = json_decode($url, true);
                    $steamid = $content['response']['players'][0]['steamid'];
                    $steamName = $content['response']['players'][0]['personaname'];
                    
                    session()->put('steamName', $steamName);
                    session()->put('steamid', $steamid);
                }
            }
            return redirect('/steam')->with('message', $content);
        } else {
            return redirect('/steam')->with('error', "You're already logged in with Steam");
        }

    }
    public function logout (){
        session()->forget('steamid');
        session()->forget('steamName');
        return redirect('/steam');
    }
}

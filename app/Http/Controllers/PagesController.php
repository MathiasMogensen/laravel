<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\LightOpenID;
use App\Classes\G2APay;
use Tuxxx128\G2aPay\G2aPayApi;
use Tuxxx128\G2aPay\G2aPayItem;

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
    public function payment2 () {

        return view('pages.payment2')->with('message', 'hello');

    }
    public function pay() {
        $g2aPayApi = new G2aPayApi('e2ce9d93-58b7-4ce3-8d4b-f51c3b069ce7', '5g80jVlviC7Fb8*T_mQ^7~5QQNUMvbc-5j-o2YXjkfz9mxcbX=Yeud~8-MUjy@W+', false, 'mathiasmg1@gmail.com');

        $item = (new G2aPayItem)->itemTemplate();

        $item->name = "My item";
        $item->url = "http://bigboytruks.com/product";
        $item->price = 10; // default currency is 'EUR'

        $g2aPayApi->addItem($item);

        $g2aPayApi->setUrlFail("http://bigboytruks.com/fail");
        $g2aPayApi->setUrlSuccess("http://bigboytruks.com/success");
        $g2aPayApi->setOrderId(1);
        // $g2aPayApi->setEmail('user@server.tld');
        header('Location: '.$g2aPayApi->getRedirectUrlOnGateway());
    }

    public function payment() {
        // Set required variables
        $success = 'http://bigboytruks.com/success/'; // URL for successful callback;
        $fail = 'http://bigboytruks.com/failed/'; // URL for failed callback;
        $order = 2234; // Choose your order id or invoice number, can be anything

        // Optional
        $currency = 'USD'; // Pass currency, if no given will use "USD"

        // Create payment instance
        $payment = new G2APay($success, $fail, $order, $currency);

        // Set item parameters
        $sku = 1; // Item number (In most cases $sku can be same as $id)
        $name = 'My Game';
        $quantity = 1; // Must be integer
        $id = 1; // Your items' identifier
        $price = 9; // Must be float
        $url = 'http://bigboytruks.com/my-game/';

        // Optional
        $extra = '';
        $type = '';

        // Add item to payment
        $payment->addItem($sku, $name, $quantity, $id, $price, $url, $extra, $type);

        $orderId = 1; // Generate or save in your database
        $extras = []; // Optional extras passed to order (Please refer G2APay docs)

        // Or if you want to create sandbox payment (for testing only)
        $response = $payment->test()->createOrder($orderId, $extras);

        // Check if successful
        if ($response['success']) {
            header('Location: '.$response['url']); // redirect
        }

        return view('pages.payment')->with('message', $response['message']);
    }

    public function steam() {
            $message = "";
            $openid = new LightOpenID('104.248.22.220');
            
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

<?php

namespace App\Helpers;

use App\Models\PartyContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WhatsappHelper {

    static function checkWhatsappNumber($partyId){
        $checkNumber = PartyContact::where('type', 1)->where('mst_party_id',$partyId)->first();
        if($checkNumber){
             return $checkNumber->number;  
        }
        return false;
    }
    
    static function sendMessage($template = 'hello_world',$number = '7888776725'){
        $url = 'https://graph.facebook.com/v18.0/'.config('app.phone_number_id').'/messages';
        $accessToken = config('app.whatsapp_bearer');
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post($url, [
            'messaging_product' => 'whatsapp',
            'to' => '91'. $number,
            'type' => 'template',
            'template' => [
                'name' => $template,
                'language' => [
                    'code' => 'en_US',
                ],
            ],
        ]);
    
        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
        }
    }


}



?>

<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Contact
{

   private $api_key = 'da588ecc5e6182f1f8c29c27d3694f5a';
   private $api_key_secret = 'e1e50ccb255b7e994e0437d02faa4d16';

   public function contact($to_email, $to_name, $content)
   {    
    $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);

    $body = [
    'FromEmail' => $to_email,
    'FromName' => $to_name,
    // 'Subject' => "Your email flight plan!",
    // 'Text-part' => $content,
    'Html-part' => $content,
    'Recipients' => [
        [
            'Email' => "contact.rhumasug@gmail.com"
        ]
        ]
    ];
    // On passe notre corps de message à $mj avec la méthode POST pour qu'il l'envoie. Resources est une classe dans notre méthode $mj post qui va envoyer nos mails.
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    // On regarde la réponse avec un dd
    // $response->success() && dd($response->getData());
    $response->success();

    }
}
?>

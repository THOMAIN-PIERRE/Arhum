<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
//    private $api_key = 'c4bd289568dd6b6999a5463c68b13518';
//    private $api_key_secret = '60a40a5a3037b67cbcddc8af138410da';
   private $api_key = 'da588ecc5e6182f1f8c29c27d3694f5a';
   private $api_key_secret = 'e1e50ccb255b7e994e0437d02faa4d16';

   public function send($to_email, $to_name, $subject, $content)
   {    
        // Instanciation de l'objet mailjet dans la variable $mj
        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        // $mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
        // On créé le corps de notre mail
        $body = [
            'Messages' => [
                [
                    'From' => [
                        // 'Email' => "contact.maboutique594@gmail.com",
                        // 'Name' => "Ma boutique"
                        'Email' => "contact.rhumasug@gmail.com",
                        'Name' => "Rhuma Sug"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name,
                        ]
                    ],
                    // 'TemplateID' => 2225337,
                    'TemplateID' => 2835863,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
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
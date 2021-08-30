<?php
/**
 * @see https://github.com/Edujugon/PushNotification
 */

return [
    'gcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'My_ApiKey',
    ],
    'fcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'AAAA8IlH1LM:APA91bEwEqR-qe_Oxk2_WF-QXZSi_0oGofBUgnUpaMm0V40k0t1_E1L5TP96SB-NnuG9zkt_WrBVDV_Fi-86NdsVftD9q8zDXT-o_r0hG9gt-OvMR2z1IbV2E5FBtBv77QbyG775Pty9',
    ],
    'apn' => [
        'certificate' => __DIR__ . '/iosCertificates/apns-dev-cert.pem',
        'passPhrase' => 'secret', //Optional
        'passFile' => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
        'dry_run' => true,
    ],
];

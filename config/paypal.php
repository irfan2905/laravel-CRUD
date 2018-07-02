<?php 
return [ 
    'client_id' => env('PAYPAL_CLIENT_ID','AWTdz-Lp_c-CAF6b-qDSRqiBow3VmqM7wpYjyusFDOGJFvA37IEikp3q_cTdvLyEHr7EI-joNQulyKVr'),
    'secret' => env('PAYPAL_SECRET','EDjpgJIIIVfwU18lxkhALloKJX0980Drnj5j-KLsP2HfDyUu7D87ModTlRPavcMDLfRF9pfjg0VhgsQa'),
    'settings' => array(
        'mode' => env('PAYPAL_MODE','sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'ERROR'
    ),
];
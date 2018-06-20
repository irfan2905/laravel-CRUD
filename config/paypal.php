<?php

return array(
/** set your paypal credential **/
'client_id' =>'AUFxOYwvc8kP7ZL_ncHehmrqZ0Hn8VB5kh2Fk_eNMRjb1bXCIcrSOY1tR_hfwsGjudzc88NIO8Ldlg4y',
'secret' => 'ECeI7G5M3vn0YZ7vVRJvzjPPJeIZ6q7fVuWNGniDRNGh_og6JSAetInhlBuocHiaOnGUeHNI7E3mem8s',
/**
* SDK configuration
*/
'settings' => array(
/**
* Available option 'sandbox' or 'live'
*/
'mode' => 'sandbox',
/**
* Specify the max request time in seconds
*/
'http.ConnectionTimeOut' => 1000,
/**
* Whether want to log to a file
*/
'log.LogEnabled' => true,
/**
* Specify the file that want to write on
*/
'log.FileName' => storage_path() . '/logs/paypal.log',
/**
* Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
*
* Logging is most verbose in the 'FINE' level and decreases as you
* proceed towards ERROR
*/
'log.LogLevel' => 'FINE'
),
);

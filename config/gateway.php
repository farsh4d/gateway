<?php

return [

    //-------------------------------
    // Timezone for insert dates in database
    // If you want Gateway not set timezone, just leave it empty
    //--------------------------------
    'timezone' => 'Asia/Tehran',

    //-------------------------------
    // Tables names
    //--------------------------------
    'table'    => 'gateway_transactions',

    //-------------------------------
    // Gateway Configs Tables names
    //--------------------------------
    'gateway_config'    => [
        'asanpardakht'  =>  'asanpardakht_gateway_configs',
        'irankish'  =>  'irankish_gateway_configs',
        'jahanpay'  =>  'jahanpay_gateway_configs',
        'maskan'  =>  'maskan_gateway_configs',
        'mellat'  =>  'mellat_gateway_configs',
        'parsian'  =>  'parsian_gateway_configs',
        'pasargad'  =>  'pasargad_gateway_configs',
        'payir'  =>  'payir_gateway_configs',
        'payline'  =>  'payline_gateway_configs',
        'paypal'  =>  'paypal_gateway_configs',
        'paypal_settings'  =>  'paypal_gateway_settings',
        'sadad'  =>  'sadad_gateway_configs',
        'saman'  =>  'saman_gateway_configs',
        'zarinpal'  =>  'zarinpal_gateway_configs',
        'zarinpal'  =>  'zarinpal_gateway_configs',
    ],

    //-------------------------------
    // Default Config Record ID
    //--------------------------------
    'default_config_id'    => [
        'asanpardakht'  =>  '1',
        'irankish'  =>  '1',
        'jahanpay'  =>  '1',
        'maskan'  =>  '1',
        'mellat'  =>  '1',
        'parsian'  =>  '1',
        'pasargad'  =>  '1',
        'payir'  =>  '1',
        'payline'  =>  '1',
        'paypal'  =>  '1',
        'paypal_settings'  =>  '1',
        'sadad'  =>  '1',
        'saman'  =>  '1',
        'zarinpal'  =>  '1',
        'zarinpal'  =>  '1',
    ],
];

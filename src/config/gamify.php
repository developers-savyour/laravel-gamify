<?php

return [
    // Model which will be having points, generally it will be User
    'payee_model' => '\App\User\User',


    // Allow duplicate reputation points
    'allow_reputation_duplicate' => true,

    // Broadcast on private channel
    'broadcast_on_private_channel' => true,

    // Channel name prefix, user id will be suffixed
    'channel_name' => 'user.reputation.',



    // Where all badges icon stored
    'level_icon_folder' => 'images/badges/',

    // Extention of badge icons
    'badge_icon_extension' => '.svg',



    // Default level
    'badge_default_level' => 1,
    'level_default_badge'=>1,
    'badges'    =>  [
        '1' =>  'Novice',
        '2' =>  'Hobbyist',
        '3' =>  'Pro',
        '4' =>  'Connoisseur',
    ],
    'default_level_order'   =>  500000
];

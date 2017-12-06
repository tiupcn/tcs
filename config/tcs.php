<?php

return [
    'host' => env('TCS_HOST', 'https://tcs.tiup.cn'),
    'token' => env('TCS_TOKEN', ''),
    'prefix' => env('TCS_PREFIX', 'tcs_verify_'),
    'expire' => env('TCS_EXPIRE', 5),
    'template' => env('TCS_TEMPLATE', '你的验证码是#code#'),
];

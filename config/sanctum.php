<?php

/*
|--------------------------------------------------------------------------
| Sanctum Configuration (DISABLED)
|--------------------------------------------------------------------------
| Sanctum tidak digunakan di project ini.
| File ini dikosongkan agar tidak terjadi error "Class Sanctum not found"
| saat Laravel melakukan boot. Login mobile menggunakan simple token,
| login admin web menggunakan session biasa.
*/

return [

    'stateful' => [],

    'guard' => ['web'],

    'expiration' => null,

    'token_prefix' => '',

    'middleware' => [],

];

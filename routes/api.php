<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctun')->get('/user',function(Request $request){
    return $request->user();
});
// Route::get('/api',function (){
//     return 'welcome api';
// });

<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 13/07/16
 * Time: 21:54
 */

use Illuminate\Http\Response;

Route::get('/', function () {
    return response()->json([
        'status_code' => Response::HTTP_FORBIDDEN,
        'message' => 'Not Allowed'
    ], Response::HTTP_FORBIDDEN);
});
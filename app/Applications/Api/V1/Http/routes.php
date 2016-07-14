<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 13/07/16
 * Time: 21:54
 */

/**
 * Base Route for APIs
 */
Route::group(['prefix' => 'api'], function () {
    /**
     * Base Route for Api version 1
     */
    Route::group(['prefix' => 'v1'], function () {
        
        /*
         * USERS ROUTE
         */
        Route::get('users', 'UsersController@index');
        
        
    });
});
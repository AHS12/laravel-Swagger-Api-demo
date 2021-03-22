<?php

use App\Http\Controllers\Book\BookController;

Route::group(['prefix' => 'v1'], function () {

    //get
    Route::get('book/get/all', [BookController::class, 'getBookAll']);
    // get paginated
    Route::post('book/get/all/paginated', [BookController::class, 'getBookPaginated']);
    //get details
    Route::get('book/details/{id}', [BookController::class, 'getBookDetails']);


    //create
    Route::post('book/insert', [BookController::class, 'bookInsert']);
    //update
    Route::post('book/update', [BookController::class, 'bookUpdate']);
    //delete
    Route::post('book/delete', [BookController::class, 'bookDelete']);
});

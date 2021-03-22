<?php

namespace App\Http\Services\Book;

use App\Models\Book\BookModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;


class BookService
{

    /**
     * Validate book insert request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function validateBookInsertRequest(Request $request)
    {
        $request->validate(BookModel::$insertRules);
    }


    /**
     * Validate book update request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function validateBookUpdateRequest(Request $request)
    {
        $request->validate(BookModel::$updateRules);
    }


    /**
     * Validate book delete request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function validateBookDeleteRequest(Request $request)
    {
        $request->validate(BookModel::$deletRules);
    }



    /**
     * @name insertBook
     * @role insert book record into database
     * @param \Illuminate\Http\Request $reques
     * @return \App\Models\Book\BookModel $book
     *
     * @throws 500 internal server error
     */

    public function insertBook(Request $request)
    {
        try {
            $book = new BookModel();

            $book->name     = $request->name;
            $book->price    =  $request->price;

            $book->save();

            return $book;
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /**
     * @name updateBook
     * @role update a book record into database
     * @param \Illuminate\Http\Request $reques
     * @param \App\Models\Book\BookModel $book
     * @return \App\Models\Book\BookModel $book
     *
     * @throws 500 internal server error
     */
    public function updateBook(Request $request, BookModel $book)
    {
        try {
            $book->name  = $request->name;
            $book->price = $request->price;

            $book->save();

            return $book;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

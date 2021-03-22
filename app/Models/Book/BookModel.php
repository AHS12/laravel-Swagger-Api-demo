<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'books';

    protected $fillable = [

        'name',
        'price'
    ];

    //media collection
    //realtions

    //rules

    /**
     * Validation book insert rules
     *
     * @var array
     */
    public static $insertRules = [

        'name'     => 'required|string|min:3',
        'price'    =>  'required|numeric',
    ];

    /**
     * Validation book update rules
     *
     * @var array
     */
    public static $updateRules = [

        'id'        => 'required|exists:books,id,deleted_at,NULL',
        'name'      => 'required|string|min:3',
        'price'    =>  'required|numeric',


    ];

    /**
     * Validation book delete rules
     *
     * @var array
     */
    public static $deletRules = [
        'id'        => 'required|exists:books,id,deleted_at,NULL',
    ];
}

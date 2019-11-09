<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookBoorewer extends Model
{
    use SoftDeletes;

    public $table = 'book_boorewers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'issue',
        'due_date',
        'book_name',
        'created_at',
        'updated_at',
        'deleted_at',
        'return_date',
    ];
}

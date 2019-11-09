<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Libbook extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'libbooks';

    protected $appends = [
        'book_cover',
    ];

    protected $dates = [
        'add_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'lib_no',
        'add_date',
        'book_name',
        'created_at',
        'updated_at',
        'deleted_at',
        'author_name',
        'book_detail',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function getBookCoverAttribute()
    {
        $file = $this->getMedia('book_cover')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function getAddDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setAddDateAttribute($value)
    {
        $this->attributes['add_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}

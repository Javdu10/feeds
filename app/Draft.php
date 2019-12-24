<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Draft extends Model
{
    protected $fillable = array('title', 'heading', 'body', 'owner_id');

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($draft) {
            $draft->{$draft->getKeyName()} = (string) Str::uuid();
        });

    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}

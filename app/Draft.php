<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Draft extends Model
{
    use \Conner\Tagging\Taggable;
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

    /**
    * @codeCoverageIgnore
    */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('App\User','owner_id');
    }
}

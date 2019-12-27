<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use \Conner\Tagging\Taggable;
    protected $fillable = array('title', 'heading', 'body','owner_id');

    /**
     * Get the user that owns the draft.
     */
    public function user()
    {
        return $this->belongsTo('App\User','owner_id');
    }
}

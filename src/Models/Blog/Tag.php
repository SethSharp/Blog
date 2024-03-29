<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_tag')
            ->withTimestamps();
    }
}

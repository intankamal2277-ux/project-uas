<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'title', 'description', 'url', 'image_url', 'source_name', 'category', 'published_at'])]
class SavedNews extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the saved news.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
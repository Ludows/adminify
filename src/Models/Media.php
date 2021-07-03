<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Post;
use Ludows\Adminify\Traits\PathableMedia;
use Ludows\Adminify\Traits\Helpers;
class Media extends Model
{
    protected $table = 'medias';

    use HasFactory;
    use PathableMedia;
    use Helpers;

    protected $fillable = [
        'title',
        'src', //the path you uploaded the image
        'mime_type',
        'description',
        'alt',
    ];

    public function getPathAttribute() {
        return $this->getFullPath($this->src) . '/' . $this->src;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

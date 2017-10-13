<?php

namespace Achillesp\Matryoshka\Test\Models;

use Achillesp\Matryoshka\Cacheable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Cacheable;
}
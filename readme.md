# Matryoshka

Matryoshka is a package for Laravel that provides Russian-Doll caching for views.
This package is based on a series of laracasts lessons with a few modifications [See Laracasts.com](https://laracasts.com/series/russian-doll-caching-in-laravel).

## Installation

### Step 1: Composer

From the command line, run:

```
composer require achillesp/matryoshka
```

### Step 2: Service Provider (Laravel < 5.5)

For your Laravel app, open `config/app.php` and, within the `providers` array, append:

```
Achillesp\Matryoshka\MatryoshkaServiceProvider::class
```

### Config

This package uses a config file which you can override by publishing to your config dir.

```
php artisan vendor publish --provider=MatryoshkaServiceProvider --tag=config
```

In the config file you can set the tag that the cache uses. If you can't use a cache that supports tagging, set it to null. 

Also in the config file, you can set whether you want to flush caches on your local machine to help with development.

## Usage

To use the plugin, you use the blade directives `@cache` and `@endcache` in your views.
The directive needs an identifier, which can be either a unique string, a Model or a Collection.

### Caching HTML

```html
@cache('my-cache-key')
    <div>
        <h1>Hello World</h1>
    </div>
@endcache
```

### Caching Models

```html
@cache($post)
    <article>
        <h2>{{ $post->title }}></h2>
        <p>Written By: {{ $post->author->username }}</p>

        <div class="body">{{ $post->body }}</div>
    </article>
@endcache
```

In order to cache a Model, one more step is needed. You need to use the Cacheable trait in your Model.

```php
use Achillesp\Matryoshka\Cacheable;

class Post extends Eloquent
{
    use Cacheable;
}
```

### Caching Collections 

```html
@cache($posts)
    @foreach ($posts as $post)
        @include ('post')
    @endforeach
@endcache
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
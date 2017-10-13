<?php

namespace Achillesp\Matryoshka\Test;

use Achillesp\Matryoshka\MatryoshkaServiceProvider;
use Achillesp\Matryoshka\Test\Models\Post;
use Illuminate\Database\Capsule\Manager as DB;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();
        $this->migrateTables();
    }

    protected function getPackageProviders($app)
    {
        return [
            MatryoshkaServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        $database = new DB();

        $database->addConnection(['driver' => 'sqlite', 'database' => ':memory:']);
        $database->bootEloquent();
        $database->setAsGlobal();
    }

    protected function migrateTables()
    {
        DB::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }

    protected function makePost()
    {
        $post = new Post();
        $post->title = 'Some title';
        $post->save();

        return $post;
    }
}

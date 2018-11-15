<?php

namespace Tests\Feature\Api\Filters;

use TestCase;
use Tests\Traits\JWTAuth;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class Filter extends TestCase
{
    use JWTAuth, DatabaseMigrations;

    /**
     * url endpoint
     * @var [type]
     */
    protected $endpoint;
    /**
     * model class
     * @var string
     */
    protected $model;
    /**
     * seeder data insert, update,show
     * @var array
     */
    protected $seederObject;
    /**
     * data transform
     * @var array
     */
    protected $transform;

    /**
     * data filter search
     * @return array
     */
    abstract public function listtingFilterSearchProvider();

    /**
     * listting filter search
     * @dataProvider listtingFilterSearchProvider
     */
    public function testListtingFilterSearch($q)
    {
        factory($this->model)->create($this->seederObject);

        // $this->authWithSupperAdmin();
        $params = [
            'limit' => 10,
            'q' => $q
        ];

        $this->json('GET', $this->endpoint . '?' . http_build_query($params), [], $this->headers)
             ->seeStatusCode(200)
             ->seeJsonStructure([
                'code',
                'status',
                'data'  => [$this->transform],
                'meta'  => [
                    'pagination'
                ]
             ]);
    }
}

<?php

namespace Tests\Feature\Api\Transformers;

use TestCase;
use Tests\Traits\JWTAuth;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class Transformer extends TestCase
{
    use JWTAuth, DatabaseMigrations;
    protected $object;
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
     * params of testTransformisNull
     * @var array
     */
    protected $params_transform_is_null;

    /**
     * data relationship belongsTo
     * @return array
     */
    abstract public function belongsToDataProvider();

    /**
     * create data for test by model factory
     */
    protected function geretateTestData()
    {
        $this->object = factory($this->model)->create($this->seederObject);
    }

    public function setUp()
    {
        parent::setUp();
        $this->geretateTestData();
    }

    /**
     * Model is null
     * @return [type] [description]
     */
    // public function testTransformIsNull()
    // {
    //     // $this->authWithSupperAdmin();
    //     $this->json('GET', $this->endpoint . '?' . http_build_query($this->params_transform_is_null), [], $this->headers)
    //           ->seeStatusCode(200)
    //           ->seeJsonStructure([
    //             'code',
    //             'data'  => []
    //         ]);
    // }

    /**
     * test include of transformer
     * @dataProvider belongsToDataProvider
     * @param  [type] $info_factory     array           infomation array of the factories
     * @param  [type] $params           array           params query request
     * @param  [type] $transform_part   array           transform of model belongsTo
     */
    public function testTransformer($info_factory , $params, $transform_part)
    {
        // $this->authWithSupperAdmin();

        foreach ($info_factory as $key => $info) {
            factory($info['class'], $info['init_data'])->create($info['value']);
        }

        $this->json('GET', $this->endpoint . '?' . http_build_query($params), [], $this->headers)
              ->seeStatusCode(200)
              ->seeJsonStructure([
                'code',
                'status',
                'data'  => [array_merge($this->transform, $transform_part)],
                'meta'  => [
                    'pagination'
                ]
            ]);
    }

}

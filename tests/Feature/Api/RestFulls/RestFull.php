<?php

namespace Tests\Feature\Api\RestFulls;

use TestCase;
use Tests\Traits\JWTAuth;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class RestFull extends TestCase
{
    use JWTAuth, DatabaseMigrations;

    /**
     * seeder data insert, update,show
     * @var array
     */
    protected $seederObject = [
        'name' => 'bb'
    ];

    /**
     * number row to test
     * @var [type]
     */
    protected $initDataNumber = 10;

    /**
     * data store not valid
     * @return array
     */
    abstract public function storeFailedDataProvider();

    /**
     * data update not valid
     * @return array
     */
    abstract public function updateFailedDataProvider();

    /**
     * create data for test by model factory & initDataNumber
     * @author KingDarkness <nguyentranhoan13@gmail.com>
     * @date   2018-10-16
     * @return [type]     [description]
     */
    public function setUp()
    {
        parent::setUp();
        $this->generateTestData();
        // $this->authWithSupperAdmin();
    }

    protected function generateTestData()
    {
        factory($this->model, $this->initDataNumber)->create();
        factory($this->model)->create($this->seederPosition);
    }

    public function failedResponse()
    {
        return [
            'code',
            'status',
            'data',
            'message'
        ];
    }

    public function deleteResponse()
    {
        return [
            'code',
            'status',
            'data',
            'message'
        ];
    }

    public function successResponse($meta = true)
    {
        if ($meta) {
            return [
                'code',
                'status',
                'data'  => [
                    $this->transform
                ],
                'meta'  => [
                    'pagination'
                ]
            ];
        } else {
            return [
                'code',
                'status',
                'data'  => $this->transform
            ];
        }
    }

    /**
     * Listting api with pagination
     * should return 200
     */
    public function testListting()
    {
        $this->json('GET', $this->endpoint)
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse());

        $this->assertCount(11, $this->response->getData()->data);
    }

    /**
     * show api not found
     * should return 404
     */
    public function testShowNotFound()
    {
        $idNotFound = \DB::table($this->table)->count() + 1;

        $this->json('GET', $this->endpoint . '/' . $idNotFound)
        ->seeStatusCode(404)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * show api found
     * should return 200
     */
    public function testShowSuccess()
    {
        $this->json('GET', $this->endpoint . '/1')
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse(false));

        $this->assertEquals(1, $this->response->getData()->data->id);
    }

    /**
     * test store not valid data
     * should return 422
     * @dataProvider storeFailedDataProvider
     */
    public function testStoreFailed($data, $errors)
    {
        $this->json('POST', $this->endpoint, $data)
        ->seeStatusCode(422)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * store sucess
     * should return 200
     */
    public function testStoreSuccess()
    {
        $this->json('POST', $this->endpoint, $this->seederObject)
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse(false));

        $id_success   = \DB::table($this->table)->count();
        $success_data = array_merge(['id' => $id_success], $this->seederObject);

        $this->seeInDatabase($this->table, $success_data);
    }

    /**
     * update not valid data
     * should return 422
     * @dataProvider updateFailedDataProvider
     */
    public function testUpdateFailed($data, $errors)
    {
        $this->json('PUT', $this->endpoint . '/1' , $data)
        ->seeStatusCode(422)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * update not found
     * should return 404
     */
    public function testUpdateNotFound()
    {
        $idNotFound = \DB::table($this->table)->count() + 1;

        $this->json('PUT', $this->endpoint . '/' . $idNotFound, $this->seederObject)
        ->seeStatusCode(404)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * update success
     * should return 200
     */
    public function testUpdateSuccess()
    {
        $this->json('PUT', $this->endpoint . '/1', $this->seederPositionUpdate)
        ->seeStatusCode(200)
        ->seeJsonStructure($this->successResponse(false));

        $success_data = array_merge(['id' => 1], $this->seederPositionUpdate);
        $this->seeInDatabase($this->table, $success_data);
    }

    /**
     * delete not found
     * should return 404
     */
    public function testDeleteNotFound()
    {
        $idNotFound = \DB::table($this->table)->count() + 1;

        $this->json('DELETE', $this->endpoint . '/' . $idNotFound)
        ->seeStatusCode(404)
        ->seeJsonStructure($this->failedResponse());
    }

    /**
     * delete success
     * should return 200
     */
    public function testDeleteSuccess()
    {
        $this->json('DELETE', $this->endpoint . '/1')
        ->seeStatusCode(200)
        ->seeJsonStructure($this->deleteResponse());

        $this->notSeeInDatabase($this->table, [
            'id' => 1
        ]);
    //     // if ($this->isSoftDelete) {
    //     //     $object_soft_delete = \DB::table($this->table)->where('deleted_at', '!=', null)->find($object->id);

    //     //     $this->assertFalse(empty($object_soft_delete));

    //     // } else {
    //     //     $this->notSeeInDatabase($this->table, [
    //     //         'id'         => $object->id
    //     //     ]);
    //     // }
    }

    /**
     * is soft delete
     * @var boolean
     */
    // protected $isSoftDelete = false;

    /**
     * module permission
     * @var [type]
     */
    // protected $resfullPermission;

    /**
     * restful api
     * @return array     [
            permissions
            method,
            url
        ]
     */
    public function restfulEndpoidProvider()
    {
        return [
            [
                [$this->resfullPermission . '.view'],
                'GET',
                $this->endpoint
            ],
            [
                [$this->resfullPermission . '.view'],
                'GET',
                $this->endpoint . '/1'
            ],
            [
                [$this->resfullPermission . '.create'],
                'POST',
                $this->endpoint
            ],
            [
                [$this->resfullPermission . '.update'],
                'PUT',
                $this->endpoint . '/1'
            ],
            [
                [$this->resfullPermission . '.delete'],
                'DELETE',
                $this->endpoint . '/1'
            ],
        ];
    }

        /**
     * test not authen return 401
     * @dataProvider restfulEndpoidProvider
     * @param  array     $permissions permission list
     * @param  text     $method      [GET, POST, PUT, DELETE]
     * @param  text     $endpoint    url endpoint
     */
    // public function testAuthorization($permissions, $method, $endpoint)
    // {
    //     $this->json($method, $endpoint, [], $this->headers)
    //          ->seeStatusCode(401);
    // }

    /**
     * test user not has permission
     * @dataProvider restfulEndpoidProvider
     * @param  array    $permissions permission list
     * @param  text     $method      [GET, POST, PUT, DELETE]
     * @param  text     $endpoint    url endpoint
     */
    // public function testForbidden($permissions, $method, $endpoint)
    // {
    //     // $this->authWithAdminHasPermissions();
    //     $this->json($method, $endpoint, [])
    //          ->seeStatusCode(403);
    // }

    /**
     * test user as permission can access
     * @dataProvider restfulEndpoidProvider
     * @param  array    $permissions permission list
     * @param  text     $method      [GET, POST, PUT, DELETE]
     * @param  text     $endpoint    url endpoint
     */
    // public function testAuthorized($permissions, $method, $endpoint)
    // {
    //     $this->authWithAdminHasPermissions($permissions);
    //     $response = $this->json($method, $endpoint, [], $this->headers);

    //     $this->assertTrue(in_array($response->response->getStatusCode(), [200, 422]));
    // }

    /**
     * test supper admin can access
     * @dataProvider restfulEndpoidProvider
     * @param  array    $permissions permission list
     * @param  text     $method      [GET, POST, PUT, DELETE]
     * @param  text     $endpoint    url endpoint
     */
    // public function testAuthorizedWithSupperAdmin($permissions, $method, $endpoint)
    // {
    //     $response = $this->json($method, $endpoint, [], $this->headers);

    //     $this->assertTrue(in_array($response->response->getStatusCode(), [200, 422]));
    // }


    /**
     * Listting api not pagination
     * should return 200
     */
    // public function testListtingWithUnLimit()
    // {
    //     $params = [
    //         'limit' => -1
    //     ];

    //     $this->json('GET', $this->endpoint . '?' . http_build_query($params), [], $this->headers)
    //          ->seeStatusCode(200)
    //          ->seeJsonStructure([
    //             'code',
    //             'status',
    //             'data'  => [$this->transform]
    //          ]);

    //     $this->assertCount(\DB::table($this->table)->count(), $this->response->getData()->data);
    // }

    /**
     * Listting api return none object
     * should return 200
     */
    // public function testListtingSingle()
    // {
    //     $params = [
    //         'limit' => 0
    //     ];

    //     $this->json('GET', $this->endpoint . '?' . http_build_query($params), [], $this->headers)
    //          ->seeStatusCode(200)
    //          ->seeJsonStructure([
    //             'code',
    //             'status',
    //             'data'  => $this->transform
    //          ]);
    // }

}

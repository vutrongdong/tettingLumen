<?php

namespace Tests\Feature\Api\RestFulls;

class PositionRestFullTest extends RestFull
{
    protected $endpoint = '/api/positions';
    protected $model    = \App\Repositories\Positions\Position::class;
    protected $transform = [
        'id',
        'name',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $table = 'positions';
    protected $seederPosition = [
        'name' => 'aa'
    ];
    protected $seederPositionUpdate = [
        'name' => 'cc'
    ];

    protected $resfullPermission = 'position';
    // protected $isSoftDelete      = true;

    public function storeFailedDataProvider()
    {
        return [
            [
                [
                    'name' => ''
                ],
                [
                    'name'
                ]
            ],

            [
                [
                    'name' => $this->seederPosition['name']
                ],
                [
                    'name'
                ]
            ],
        ];
    } 

    public function updateFailedDataProvider()
    {
        return [
            [
                [
                    'name' => ''
                ],
                [
                    'name'
                ]
            ],
            [
                [
                    'name' => $this->seederPosition['name']
                ],
                [
                    'name'
                ]
            ],
        ];
    }
}

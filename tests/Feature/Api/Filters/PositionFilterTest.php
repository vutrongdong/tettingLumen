<?php

namespace Tests\Feature\Api\Filters;

class DistrictFilterTest extends Filter
{
    protected $endpoint     = '/api/positions';
    protected $model        = \App\Repositories\Positions\Position::class;
    protected $seederObject = [
        'name'       => 'Trưởng phòng',
        'status'       => '0',
    ];
    protected $transform         = [
        'id',
        'name',
        'status',
        'created_at'
    ];

    public function listtingFilterSearchProvider()
    {
        return [
            [
                ''
            ],
            [
                'Trưởng phòng'
            ],
            [
                '0'
            ],
        ];
    }

}

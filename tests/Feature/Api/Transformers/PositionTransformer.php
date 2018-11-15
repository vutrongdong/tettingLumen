<?php

namespace Tests\Feature\Api\Transformers;

class DistrictTransformerTest extends Transformer
{
    protected $endpoint     = '/api/positions';
    protected $model        = \App\Repositories\Positions\Position::class;
    protected $seederObject = [
        'name'       => 'Trưởng phòng',
        'status'       => '0'
    ];
    protected $transform = [
        'id',
        'name'.
        'status'
    ];

    public function belongsToDataProvider()
    {
        // return [
        //     [
        //         [
        //             [
        //                 'class'     => \App\Repositories\Wards\Ward::class,
        //                 'init_data' => 3,
        //                 'value'     => [
        //                     'district_code'  => $this->seederObject['code']
        //                 ]
        //             ]
        //         ],
        //         [
        //             'include'   => 'wards'
        //         ],
        //         [
        //             'wards'  => [
        //                 'data'  => [$this->transformWard]
        //             ]
        //         ]
        //     ]
        // ];
    }

}
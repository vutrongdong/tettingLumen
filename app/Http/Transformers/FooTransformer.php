<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Foos\Foo;

class FooTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
    ];

    public function transform(Foo $foo = null)
    {
        if (is_null($foo)) {
            return [];
        }

        return [
            'id'          => $foo->id
        ];
    }

    // public function includeFoo(Foo $foo = null)
    // {
    //     if (is_null($foo)) {
    //         return $this->null();
    //     }
    //     return $this->item($foo->foo, new FooTransformer);
    // }

    // public function includeBars(Foo $foo = null)
    // {
    //     if (is_null($foo)) {
    //         return $this->null();
    //     }
    //     return $this->collection($foo->bars, new BarTransformer);
    // }
}

<?php

namespace App\Traits;

trait TypeaheadResponseTrait
{
    /**
     * Response template for typeahead.
     *
     * @param  array  $info
     * @return \Illuminate\Http\Response
     */
    protected function typeaheadResponse($info)
    {
        return response()->json([
            'status' => true,
            'error' => null,
            'data' => [
                'info' => $info
            ]
        ]);
    }
}

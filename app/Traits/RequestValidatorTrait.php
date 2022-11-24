<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait RequestValidatorTrait
{
    /**
     * @param Request $request
     * @param $rules
     * @return false|\Illuminate\Http\JsonResponse
     */
    public static function isValidRequest(Request $request, $rules = [])
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }

        return false;
    }
}

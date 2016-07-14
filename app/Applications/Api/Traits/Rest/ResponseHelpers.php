<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 13/07/16
 * Time: 22:41
 */

namespace App\Applications\Api\Traits\Rest;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Pagination\AbstractPaginator;

trait ResponseHelpers
{
    public function ApiResponse($data, $status = Response::HTTP_OK)
    {
        switch ($data) {
            case ($data instanceof Model):
                $data = ['data' => $data];
                break;

            case ($data instanceof AbstractPaginator):
                $data = $data->toArray();
                break;

            case (! is_array($data)):
                $data = ['message' => ($data != null) ? $data : 'HTTP_CODE_'. $status];
                break;
        }

        return response()->json(array_merge(['status_code' => $status], $data), $status);
    }
}
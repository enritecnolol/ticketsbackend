<?php

namespace App\Http\Controllers;

use App\Product;
use App\Services\ProductsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    private $service;

    public function __construct(ProductsServices $service)
    {
        $this->service = $service;
    }

    public function ProductsPaginate(Request $request)
    {
        $size = isset($request['size']) ? $request['companies']: '10';
        $search = isset($request['search']) ? $request['search']: '';

        try{
            $res = $this->service->getProductsPaginate($size, $search);

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

}

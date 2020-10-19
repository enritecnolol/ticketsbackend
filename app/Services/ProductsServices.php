<?php
namespace App\Services;

use App\Product;
use Illuminate\Support\Facades\DB;

class ProductsServices
{
    public function getProductsPaginate($size = 10, $search)
    {
        $products = DB::connection('client')
            ->table('public.inv_productos')
            ->select('cia_codigo', 'prod_codigo', 'prod_referencia', 'prod_nombre', 'prod_precio1')
            ->where('prod_referencia', $search)
            ->orWhere('prod_nombre', 'like', '%' . $search . '%')
            ->paginate($size);

        return $products;
    }
}

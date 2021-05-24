<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Food;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class FoodController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $type = $request->input('type');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        $rate_from = $request->input('rate_from');
        $rate_to = $request->input('rate_to');

        if($id)
        {
            $food = Food::find($id);

            if($food)
            {
                return  ResponseFormatter::success(
                    $food,
                    'Data produk berhasil di ambil'
                );
            }
            else
            {
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ada',
                    404
                );
            }
        }

        $food = Food::query();

        if($name)
        {
            $food->where('name', 'like', '%' . $name . '%');
        }
        if($type)
        {
            $food->where('name', 'like', '%' . $type . '%');
        }
        if($price_from)
        {
            $food->where('price', '>=', $price_from);
        }
        if($price_to)
        {
            $food->where('price', '<=', $price_to);
        }
        if($rate_from)
        {
            $food->where('price', '>=', $rate_from);
        }
        if($rate_to)
        {
            $food->where('price', '<=', $rate_to);
        }

        return ResponseFormatter::success(
            $food->paginate($limit),
            'Data list produk berhasil di ambil'
        );
        
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use Validator;

class HomepageController extends Controller
{
    public function listHomepage(){
        // 每頁資料量
        $row_per_page = 10;
        
        // 撈取商品分頁資料
        $MerchandisePaginate = Merchandise::OrderBy('updated_at', 'desc')
            ->where('status', 'S') // 可販售
            ->paginate($row_per_page);

        // 撈取商品類別資料
        // $MerchandiseCategory = MerchandiseCategory::get();

        $binding = [
            'title' => '首頁',
            'MerchandisePaginate' => $MerchandisePaginate,
            // 'MerchandiseCategory' => $MerchandiseCategory,
        ];

        return view('frontend.index', $binding);
    }
}

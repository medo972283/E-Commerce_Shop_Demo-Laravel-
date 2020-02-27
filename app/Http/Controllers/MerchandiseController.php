<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use Validator;
use Image;

class MerchandiseController extends Controller
{
    // 販賣_商品清單
    public function merchandiseListPage(){
        // 每頁資料量
        $row_per_page = 10;
        
        // 撈取商品分頁資料
        $MerchandisePaginate = Merchandise::OrderBy('updated_at', 'desc')
            ->where('status', 'S') //可販售
            ->paginate($row_per_page);
        
        // 設定商品圖片網址
        foreach($MerchandisePaginate as $Merchandise)
        {
            if(!is_null($Merchandise->photo))
            {
                //設定商品照片網址
                $Merchandise->photo = url($Merchandise->photo);
            }
        }

        $binding = [
            'title' => '商品列表',
            'MerchandisePaginate' => $MerchandisePaginate,
        ];

        return view('frontend.merchandise.listMerchandise', $binding);
    }

    // 新增商品
    public function merchandiseCreateProcess(){

        //建立商品基本資訊
        $merchandise_data = [
            'status' => 'C', // 建立中
            'category' => '', // 類別
            'name' => '', // 商品名稱
            'introduction' => '', // 商品介紹
            'photo' => null, // 商品照片
            'price' => 0, // 價格
            'remain_count' => 0, // 商品剩餘數量
            'customer_id' => session()->get('customer_id'), // 上傳者
        ];
        // 檢查是否已有類別，若無則新增
        $MerchandiseCategory = MerchandiseCategory::where('name', $merchandise_data['category'])->get();
        if(count($MerchandiseCategory) == 0){
            $merchandiseCategory_data = [
                'name' => $merchandise_data['category'],
            ];
            $MerchandiseCategory = MerchandiseCategory::create($merchandiseCategory_data);
        }
        $Merchandise = Merchandise::create($merchandise_data);

        //重新導向製商品編輯頁
        return redirect('/merchandise/'.$Merchandise->id.'/edit');
    }

    // 管理商品清單檢視
    public function merchandiseManageListPage(){
        
        // 每頁資料量
        $row_per_page = 5;
        // 撈取商品分頁資料
        $MerchandisePaginate = Merchandise::OrderBy('created_at', 'desc')->paginate($row_per_page);

        //設定商品圖片網址
        foreach($MerchandisePaginate as $Merchandise)
        {
            if(!is_null($Merchandise->photo))
            {
                //設定商品圖片網址
                $Merchandise->photo = url($Merchandise->photo);
            }
        }

        $binding = [
            'title' => '管理商品',
            'MerchandisePaginate' => $MerchandisePaginate,
        ];

        return view('frontend.merchandise.manageMerchandise', $binding);
    }
    
    // 販賣_單一商品頁
    public function merchandiseItemPage($merchandise_id){
        //撈取商品資料
        $Merchandise = Merchandise::findOrFail($merchandise_id);

        if(!is_null($Merchandise->photo))
        {
            //設定商品照片網址
            $Merchandise->photo = url($Merchandise->photo);
        }

        $binding = [
            'title' => '商品頁',
            'Merchandise' => $Merchandise,
        ];

        return view('frontend.merchandise.showMerchandise', $binding);
    }
    
    // 單一商品編輯頁 ，透過路由的{merchandise_id}取得參數
    public function merchandiseItemEditPage($merchandise_id){
        //撈取商品資料
        $Merchandise = Merchandise::findOrFail($merchandise_id);

        if(!is_null($Merchandise->photo))
        {
            //設定商品照片網址，url將相對路徑轉為網址的絕對路徑(http://)
            $Merchandise->photo = url($Merchandise->photo);
        }

        $binding = [
            'title' => '編輯商品',
            'Merchandise' => $Merchandise,
        ];
        return view('frontend.merchandise.editMerchandise', $binding);
    }
    
    // 單一商品資料更新處理
    public function merchandiseItemUpdateProcess($merchandise_id){
        //撈取商品資料
        $Merchandise = Merchandise::findOrFail($merchandise_id);

        //接收輸入資料
        $input = request()->all();

        //驗證規則
        $rules = [
            // 商品狀態
            'status' => [
                'required',
                'in:C,S' //S前面不能有空格
            ],
            // 商品類別
            'category' => [
                'required',
                'string',
                'max:80',
            ],
            //商品名稱
            'name' => [
                'required',
                'string',
                'max:80',
            ],

            //商品介紹
            'introduction' => [
                'required',
                'max:2000',
            ],

            //商品照片
            'photo' => [
                'file',
                'image',
                'max:10240', //10 MB
            ],

            //商品價格
            'price' => [
                'required',
                'integer',
                'min:0',
            ],

            //商品剩餘數量
            'remain_count' => [
                'required',
                'integer',
                'min:0',
            ],
        ];

        //驗證資料
        $validator = Validator::make($input, $rules);

        if($validator->fails())
        {
            //資料驗證錯誤
            return redirect('/merchandise/'.$Merchandise->id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        // 處理上傳的圖片
        if(isset($input['photo']))
        {
            $photo = $input['photo'];
            // 檔案副檔名，使用Laravel函式取得上傳時的原副檔名
            $file_extension = $photo->getClientOriginalExtension();
            // 產生唯一值的隨機檔案名稱
            $file_name = uniqid().'.'.$file_extension;
            // 檔案相對路徑
            $file_relative_path = 'img\\merchandise\\'.$file_name;
            // 檔案存取目錄為對外公開public目錄下的相對位置的完整路徑
            $file_path = public_path($file_relative_path);

            Log::notice('原圖片路徑 = '.$photo);
            Log::notice('圖片類型 = '.$photo->getMimeType());
            Log::notice('新圖片路徑 = '.$file_path);
            //裁切圖片，使用別人在Packagist提供的開源套件，下載：composer require intervention/image，之後修改config/app.php中的providers和aliases
            $image = Image::make($photo)->fit(450, 300)->save($file_path);
            //設定圖片檔案相對位置
            $input['photo'] = $file_relative_path;
        }

        $Merchandise->update($input);

        //重新導向到商品編輯頁
        return redirect('/merchandise/'.$Merchandise->id.'/edit')->with('message', '更新完成');
    }

    // 商品購買相關處理
    public function merchandiseItemBuyProcess($merchandise_id){
        //接收輸入資料
        $input = request()->all();
        //驗證規則
        $rules = [
            //商品購買數量
            'buy_count' => [
                'required',
                'integer',
                'min:1',
            ],
        ];

        //驗證規則
        $validator = Validator::make($input, $rules);

        if($validator->fails())
        {
            //資料驗證錯誤
            return redirect('/merchandise/'.$merchandise_id)
                ->withErrors($validator)
                ->withInput();
        }

        var_dump($input);
    }


}

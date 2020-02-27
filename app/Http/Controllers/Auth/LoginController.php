<?php

namespace App\Http\Controllers\Auth;


// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Validator;
use Hash;


class LoginController extends Controller
{
    // use AuthenticatesUsers;


    public function loginPage(){
        $binding = [
            'title' => '登入',
        ];
        return view('frontend.auth.login', $binding);
    }

    public function loginProcess(){
        // 接收資料
        $input = request()->all();

        // 驗證規則
        $rules = [
            'account' => [
                'required',
                'max:150',
                'string'
            ],
            'password' =>[
                'required',
                'min:3'
            ]
        ];

        // 驗證
        $validator = Validator::make($input,$rules);

        if($validator->fails()){
            return redirect(route('loginPage'))
                ->withErrors($validator)
                ->withInput();
        }

        // //啟用紀錄SQL語法
        // DB::enableQueryLog();

        // 撈取使用者資料, 使用firstOrFail()的方法限制只撈取第一筆資料，當沒有找到該使用者資料時，則會丟出例外錯誤訊息
        // 綁定的資料Laravel都會協助處理SQL資料隱碼攻擊(SQL Injection)的問題
        $customerData = Customer::where('account', $input['account'])->firstOrFail();
        
        // //列印出資料庫目前所有執行的SQL語法
        // var_dump(DB::getQueryLog());
        // exit();

        // 比對
        $is_password_correct = Hash::check($input['password'], $customerData->password);
    
        if(!$is_password_correct)
        {
            //密碼錯誤回傳錯誤訊息
            $error_message = [
                'msg' => [
                    '密碼驗證錯誤',
                ],
            ];

            return redirect(route('loginPage'))
                ->withErrors($error_message)
                ->withInput();
        }

        // 加入session
        session()->put('customer_id', $customerData->id);

        // 重新導向到原先使用者造訪頁面，沒有嘗試造訪頁則重新導向回首頁
        return redirect()->intended('/');
    }

    public function signOut(){
        //清除Session
        session()->forget('customer_id');

        //重新導向回首頁
        return redirect('/');
    }
}

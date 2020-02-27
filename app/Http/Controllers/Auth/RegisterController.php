<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\RegistersUsers;
use Hash;
use Validator;
use Mail;
use App\Models\Customer;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function registerPage(){
        $binding = [
            'title' => '註冊',
        ];
        return view('frontend.auth.register', $binding);
    }

    public function registerProcess(){
        //接收輸入資料
        $input = request()->all();
        
        //驗證規則
        $rules = [
            //暱稱
            'nickname' => [
                'required',
                'string',
                'max:50',
            ],
            //E-mail
            'email' => [
                'required',
                'string',
                'max:150',
                'email',
            ],
            //帳號
            'account' => [
                'required',
                'min:3',
            ],
            //密碼
            'password' => [
                'required',
                'same:password_confirmation',
                'min:3',
            ],
            //密碼驗證
            'password_confirmation' => [
                'required',
                'min:3'
            ]
        ];

        //驗證資料
        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            //資料驗證錯誤
            return redirect( route('registerPage') )
                ->withErrors($validator)
                ->withInput();
        }

        //密碼加密
        $input['password'] = Hash::make($input['password']);
        $input['password_confirmation'] = '';

        //新增會員資料
        $Users = Customer::create($input);

        /*先不做
        //寄送註冊通知信
        $mail_binding = [
            'nickname' => $input['nickname']
        ];

        // 第一個參數為信件模板，第二個參數為傳入模板的變數，第三個參數為email寄送相關資訊，如寄件人 收件人 主旨等。
        Mail::send('components.emailFormat', $mail_binding,
        function($mail) use ($input){
            //收件人
            $mail->to($input['email']);
            //寄件人
            $mail->from('medo972283@gmail.com');
            //郵件主旨
            $mail->subject('恭喜註冊 E-commerce Shop Laravel 成功!');
        });
        */

        //重新導向到登入頁
        return redirect( route('loginPage') );

    }
}

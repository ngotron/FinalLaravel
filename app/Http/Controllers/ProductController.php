<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Cart;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Slide;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Contracts\Service\Attribute\Required;

class ProductController extends Controller
{
    //
    public function homepage()
    {
        //

        // $products = Product::all();
        $slide = Slide::all();
        // $typeProduct = ProductType::all();
        // $newProduct = Product::find('new', 1)->paginate(4);
        $newProduct = Product::where('new', 1)->paginate(4);
        $productSale = Product::where('promotion_price', '<>', 0)->paginate(8);

        // dd($newProduct);

        return view('page.homePage', compact('slide', 'newProduct', 'productSale'));
    }
    // public function showTypePro()
    // {
    //     //

    //     // $products = Product::all();

    //     $typeProduct = ProductType::all();
    //     return view('page.homePage', compact('typeProduct'));
    // }
    public function showTypePro(Request $request)
    {
        // $typeProduct = ProductType::all();
        $spLoai = Product::where('id_type', $request->id)->get();
        $spKhac = Product::where('id_type', '<>', $request->id)->paginate(6);
        // $spLoai = Product::find($id);
        return view('page.typeproduct', compact('spLoai', 'spKhac'));
    }
    public function AboutUs()
    {
        // $typeProduct = ProductType::all();
        return view('page.about');
    }
    public function ContactUs()
    {
        // $typeProduct = ProductType::all();
        return view('page.contact');
    }
    // public function getDetail($id, Request $request)
    // {
    //     $product = Product::find($id);
    //     $comments = Comment::where('id_product', $request->id)->get();
    //     return view('banhang.detail', compact('product', 'comments'));
    // }
    public function detail(Request $request)
    {
        $detailPro = Product::where('id', $request->id)->first();
        $comments = Comment::where('id_product', $request->id)->get();
        $relatePro = Product::where('id_type', $detailPro->id_type)->paginate(3);
        // $typeProduct = ProductType::all();
        return view('page.detail', compact('detailPro', 'relatePro', 'comments'));
    }
    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $request->session()->put('cart', $cart);
        return redirect()->back();
    }
    public function deleteCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : Session(null);
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        Session::put('cart', $cart);
        return redirect()->back();
    }
    public function showCheckout()
    {
        return view('page.checkout');
    }

    public function checkout(Request $request)
    {
        if ($request->input('payment_method') != "VNPAY") {

            $cart = Session::get('cart');

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->gender = $request->gender;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->phone_number = $request->phone;
            $customer->note = $request->notes;

            $customer->save();
            $bill = new Bill();
            $bill->id_customer = $customer->id;
            $bill->date_order = date('Y-m-d');
            $bill->total = $cart->totalPrice;
            $bill->payment = $request->payment;

            $bill->note = $request->notes;
            $bill->save();

            foreach ($cart->items as $key => $value) {
                $billDetail = new BillDetail();
                $billDetail->id_bill = $bill->id;
                $billDetail->id_product = $key;
                $billDetail->quantity = $value['qty'];
                $billDetail->unit_price = $value['price'] / $value['qty'];
                $billDetail->save();
            }
            Session::forget('cart');
            return redirect()->back()->with('alert', '??a?? ??????t ha??ng tha??nh c??ng!');
        } else {
            $cart = Session::get('cart');
            return view('page.vnpayIndex', compact('cart'));
        }
    }
    public function vnpayReturn(Request $request)
    {
        //dd($request->all());
        // if($request->vnp_ResponseCode=='00'){
        //     $secureHash = $request->query('vnp_SecureHash');
        //     if ($secureHash == env('VNP_HASHSECRECT')) {
        //      $cart=Session::get('cart');

        //      //lay du lieu vnpay tra ve
        //      $vnpay_Data=$request->all();

        //      //insert du lieu vao bang payments
        //      //.........

        //     //truyen vnpay_Data vao trang vnpay_return
        //     return view('vnpay_return',compact('vnpay_Data'));
        //     }
        // }
        //PHIEEN BAN 2022
        $vnp_SecureHash = $request->vnp_SecureHash;
        //echo $vnp_SecureHash;
        $vnpay_Data = array();
        foreach ($request->query() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $vnpay_Data[$key] = $value;
            }
        }

        unset($vnpay_Data['vnp_SecureHash']);
        ksort($vnpay_Data);
        $i = 0;
        $hashData = "";
        foreach ($vnpay_Data as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, env('VNP_HASHSECRECT'));
        // echo $secureHash;


        if ($secureHash == $vnp_SecureHash) {
            if ($request->query('vnp_ResponseCode') == '00') {
                $cart = Session::get('cart');
                //lay du lieu vnpay tra ve
                $vnpay_Data = $request->all();

                //insert du lieu vao bang payments
                //.........

                //truyen vnpay_Data vao trang vnpay_return
                return view('page.vnpayReturn', compact('vnpay_Data'));
            }
        }
    }

    public function createPayment(Request $request)
    {
        $cart = Session::get('cart');
        $vnp_TxnRef = $request->transaction_id; //M?? giao d???ch. Trong th???c t??? Merchant c???n insert ????n h??ng v??o DB v?? g???i m?? n??y sang VNPAY
        $vnp_OrderInfo = $request->order_desc;
        $vnp_Amount = str_replace(',', '', $cart->totalPrice * 100);
        $vnp_Locale = $request->language;
        $vnp_BankCode = $request->bank_code;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];


        $vnpay_Data = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => env('VNP_TMNCODE'),
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => route('vnpayReturn'),
            "vnp_TxnRef" => $vnp_TxnRef,

        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $vnpay_Data['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($vnpay_Data);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($vnpay_Data as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = env('VNP_URL') . "?" . $query;
        if (env('VNP_HASHSECRECT')) {
            // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            //$vnpSecureHash = hash('sha256', env('VNP_HASHSECRECT'). $hashdata);
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('VNP_HASHSECRECT')); //  
            // $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        //dd($vnp_Url);
        return redirect($vnp_Url);
        die();
    }

    public function showSignup()
    {
        return view('page.signup');
    }
    public function signup(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:20',
                'rePassword' => 'required|same:password'
            ],
            [
                'email.required' => 'Vui lo??ng nh????p mail',
                'email.email' => 'Kh??ng ??u??ng ??i??nh da??ng email',
                'email.unique' => '??a?? co?? ng??????i s???? du??ng',
                'password.required' => 'Vui lo??ng nh????p password',
                'password.min' => 'M????t kh????u co?? i??t nh????t 6 ki?? t????',
                'password.max' => 'M????t kh????u chi?? n??n d??????i 20 ki?? t????',
                'rePassword.required' => 'M????t kh????u kh??ng tru??ng',
                'rePassword.same' => 'M????t kh????u kh??ng tru??ng',

            ]
        );
        $user = new User();
        $user->email = $request->email;
        $user->full_name = $request->fullName;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->back()->with('thanhcong', '??a?? ????ng ki?? tha??nh c??ng!');
    }
    public function showSignin()
    {

        return view('page.signin');
    }
    public function signin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:20',

            ],
            [
                'email.required' => 'Vui lo??ng nh????p mail',
                'email.email' => 'Kh??ng ??u??ng ??i??nh da??ng email',
                'password.required' => 'Vui lo??ng nh????p password',
                'password.min' => 'M????t kh????u co?? i??t nh????t 6 ki?? t????',
                'password.max' => 'M????t kh????u chi?? n??n d??????i 20 ki?? t????',
            ]
        );
        $credentials = array('email' => $request->email, 'password' => $request->password);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Session::put('user', $user);
            return redirect()->back()->with('thongbao', '????ng nh????p tha??nh c??ng');
        } else {
            return redirect()->back()->with('thongbao', '????ng nh????p th????t ba??i');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::forget('user');
        Session::forget('cart');
        return redirect()->route('homepage');
    }
    // comment 


    public function AddComment(Request $request, $id)
    {
        if (Session::has('user')) {
            $input = [
                'username' => Session::get('user')->full_name,
                'comment' => $request->comment,
                'id_product' => $id
            ];
            Comment::create($input);
            return redirect()->back();
        } else {
            return '<script>alert("Vui l??ng ????ng nh???p ????? s??? d???ng ch???c n??ng n??y.");window.location.assign("/signin");</script>';
        }
    }
    public function deleteComment($id)
    {
        //
        $comment = Comment::find($id);
        $comment->delete();
        return redirect()->back()->with('alert', 'Xo??a tha??nh c??ng !!');;
    }
    //h??m x??? l?? g???i email
    public function InputEmail()
    {
        return view('Mails.inputEmail');
    }

    public function postInputEmail(Request $request)
    {

        $email = $request->txtEmail;

        //validate

        // ki???m tra c?? user c?? email nh?? v???y kh??ng

        $user = User::where('email', $email)->get();

        //dd($user);

        if ($user->count() != 0) {

            //g???i m???t kh???u reset t???i email

            $sentData = [

                'title' => 'M???t kh???u m???i c???a b???n l??:',

                'body' => '123456'

            ];

            Mail::to($email)->send(new \App\Mail\SendMail($sentData));

            Session::flash('message', 'Send email successfully!');

            return view('Page.signin'); //v??? l???i trang ????ng nh???p c???a kh??ch

        } else {

            return redirect()->back()->with('message', 'Your email is not right');
        }
    } //h???t postInputEmail


    public function getTable()
    {
        $products = DB::table('products')->paginate(100);
        // $products = Product::all()->paginate(4);
        return view('admin.table')->with(['products' => $products, 'sumSold' => count(BillDetail::all())]);
        // return view('admin.table', compact('products'));
    }
    public function showAddAdmin()
    {
        return view('admin.addForm');
    }
    public function AddAdmin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'id_type' => 'required',
            'unit_price' => 'required',
            'promotion_price' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'new' => 'required',

        ], [
            'name.required' => 'B???n ch??a nh???p t??n',
            // 'id_type.required' => 'B???n ch??a nh???p loa??i',
            'unit_price.required' => 'B???n ch??a nh???p gia??',
            'promotion_price.required' => 'B???n ch??a nh???p gia?? khuy????n ma??i',
            'description.required' => 'B???n ch??a nh???p m?? t???',
            'unit.required' => 'B???n ch??a nh???p unit',
            'new.required' => 'B???n ch??a nh???p new',

        ]);
        $product = new Product();
        $name = '';
        if ($request->hasfile('image')) {
            $this->validate($request, [
                'image' => 'mimes:jpg,png,gif,jpeg|max: 2048'
            ], [
                'image.mimes' => 'Ch??? ch???p nh???n file h??nh ???nh',
                'image.max' => 'Ch??? ch???p nh???n h??nh ???nh d?????i 2Mb'
            ]);
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('source/image/product'); //project\public\images, public_path(): tr??? v??? ???????ng d???n t???i th?? m???c public
            $file->move($destinationPath, $name); //l??u h??nh ???nh v??o th?? m???c public/images
        }

        $product->name = $request->name;
        $product->id_type = $request->id_type;
        $product->unit_price = $request->unit_price;
        $product->promotion_price = $request->promotion_price;
        $product->description = $request->description;
        $product->unit = $request->unit;
        $product->new = $request->new;
        $product->image = $name;
        $product->save();
        return redirect()->back()->with('alert', '??a?? ????ng ki?? tha??nh c??ng!');
    }
    public function showEditAdmin($id)
    {
        $product = Product::find($id);
        return view('admin.editForm', compact('product'));
    }
    public function EditAdmin(Request $request, $id)
    {
        $product = Product::find($id);
        $image = request('image');
        if ($image) {
            $product->name = $request->name;
            $product->id_type = $request->id_type;
            $product->unit_price = $request->unit_price;
            $product->promotion_price = $request->promotion_price;
            $product->description = $request->description;
            $product->unit = $request->unit;
            $product->new = $request->new;
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extention;
            $file->move('source/image/product', $fileName);
            $product->image = $fileName;
        } else {
            $product->name = $request->name;
            $product->id_type = $request->id_type;
            $product->unit_price = $request->unit_price;
            $product->promotion_price = $request->promotion_price;
            $product->description = $request->description;
            $product->unit = $request->unit;
            $product->new = $request->new;
        }


        $product->save();
        return redirect()->back()->with('alert', '??a?? ????ng ki?? tha??nh c??ng!');
    }
    public function delete($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('admin')->with('alert', 'Xo??a tha??nh c??ng !!');;
    }


    // ----------- SEND EMAIL -----------

    // $message = [
    //     'type' => 'Email th??ng b??o ?????t h??ng th??nh c??ng',
    //     'thanks' => 'C???m ??n ' . $req->name . ' ???? ?????t h??ng.',
    //     'cart' => $cart,
    //     'content' => '????n h??ng s??? t???i tay b???n s???m nh???t c?? th???.',
    // ];
    // SendEmail::dispatch($message, $req->email)->delay(now()->addMinute(1));
}

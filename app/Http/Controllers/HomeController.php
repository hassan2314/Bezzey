<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Oder;
use Session;
use Stripe;
class HomeController extends Controller
{
    //
    public function index(){
        $product = product::paginate(9);
        return view('home.userpage', compact('product'));
    }
    public function redirect(){
        $usertype=Auth::user()->usertype;
        if($usertype=='1'){
            $totalProduct=product::all()->count();
            return view('admin.home', compact('totalProduct'));
        }
        else{
            $product = product::paginate(9);
            return view('home.userpage', compact('product'));
        }
    }
    public function product_detail($id){
        $pro=product::find($id);
        return view ('home.product_detail', compact('pro'));
    }
   public function add_cart($id, Request $req){
    if(Auth::id())
    {
        $user= Auth::user();
        $pro=product::find($id);
        $cart= new cart;
        $cart->name=$user->name;
        $cart->email=$user->email;
        $cart->phone=$user->phone;
        $cart->user_id=$user->id;
        $cart->address=$user->address;
        $cart->product_title=$pro->title;
        $cart->quantity=$req->quantity;
        if($pro->discount_price!=null){

            $cart->price=$pro->discount_price*$req->quantity;
        }
        else{
            $cart->price=$pro->price*$req->quantity;
        }
        $cart->image=$pro->image;
        $cart->product_id=$pro->id;

        $cart->save();
        return redirect()->back();
    }
    else{
       
        return redirect ('login');
    }

   }
   public function show_cart(){
    if(Auth::id())
    {
        $id= Auth::user()->id;
        $product= cart::where('user_id','=',$id)->get();
    return view ('home.show_cart',compact('product'));
    }
    else{

        return redirect ('login');
    }
   }
   public function delete_cart($id){
    $data = cart::find($id);
    $data->delete();
    return redirect()->back()->with('message','Product Deleted Successfully ');

}
public function cash_order()
{
    $user_id = Auth::user()->id;
    $data = cart::where('user_id', '=', $user_id)->get();

    foreach ($data as $item) {
        $order = new Oder();

        $order->name = $item->name;
        $order->email = $item->email;
        $order->phone = $item->phone;
        $order->user_id = $item->user_id;
        $order->address = $item->address;
        $order->product_title = $item->product_title;
        $order->quantity = $item->quantity;
        $order->price = $item->price;
        $order->image = $item->image;
        $order->product_id = $item->product_id;
        $order->payment_status = "On Delivery";
        $order->delivery_status = "Processing";

        $order->save();

        // Delete the cart item after saving the order
        $cart = cart::find($item->id);
        $cart->delete();
    }

    return redirect()->back()->with('message', 'Order Confirmed');
}

    public function stripe($totalPrice){
        return view ('home.stripe',compact('totalPrice'));
    }
    public function stripePost(Request $request,$totalPrice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalPrice* 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks For Payment" 
        ]);
        $user_id= Auth::user()->id;
        $data= cart::where('user_id','=',$user_id)->get();
       
         $oder= new oder;
       
         foreach($data as $data){
            $oder->name=$data->name;
         $oder->email=$data->email;
         $oder->phone=$data->phone;
         $oder->user_id=$data->id;
         $oder->address=$data->address;
         $oder->product_title=$data->product_title;
         $oder->quantity=$data->quantity;
         $oder->price=$data->price;
         $oder->image=$data->image;
         $oder->product_id=$data->id;
         $oder->payment_status="Paid";
         $oder->delivery_status="Processing";

        $oder->save();
        $cart=cart::find($data->id);
        $cart->delete();
    
        }
        Session::flash('success', 'Payment successful!');
              
        return back();
    }
}

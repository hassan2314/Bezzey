<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Catagory;
use App\Models\Product;
use App\Models\Oder;
use App\Notifications\Email;
use Notification;
use PDF;


class AdminController extends Controller
{
    //
    public function view_catagory(){
        if(Auth::id() && (Auth::User()->usertype == 1)) {

            $data= catagory::all();
            return view ('admin.catagory', compact('data'));
        }
        else{
            return redirect('login');
        }
    }
    public function add_catagory(Request $req){
        if(Auth::id() && (Auth::User()->usertype == 1))
       {
         $data= new catagory;
        $data->catagory_name=$req->name;
        $data->save();
        // return view ('admin.catagory');
        return redirect()->back()->with('message','Catagory Added Successfully ');
    }
    else{
        return redirect('login');
    }
    }
    public function delete_catagory($id){
        $data=catagory::find($id);
        $data->delete();
        return redirect()->back()->with('message','Catagory Deleted Successfully ');
    }
    public function view_product(){
        if(Auth::id() && (Auth::User()->usertype == 1))
       { 
        $catagory= catagory::all();
       return view('admin.product', compact('catagory'));}
    
    else{
        return redirect('login');
    }
}
    public function add_product(Request $req){
        if(Auth::id() && (Auth::User()->usertype == 1))

        {$data= new product;
        $data->title=$req->title;
        $data->discription=$req->dis;
        $data->price=$req->price;
        $data->discount_price=$req->dis_price;
        $data->quantity=$req->qu;
        $data->catagory=$req->catagory;

        // $image=$req->image;
        // $imagename=time().'.'.$image->getClientOrignalExtension();
        // $req->image->move('product',$imagename);
        // $data->image=$imagename;
        $image = $req->image;
        $extension = $image->getClientOriginalExtension();
        $imagename = time() . '.' . $extension;
        $req->image->move('product', $imagename);
        $data->image = $imagename;

        $data->save();
        return redirect()->back()->with('message','Product Added Successfuly');
    }
    else{
        return redirect('login');
    }
    }
    public function show_product(){
        if(Auth::id() && (Auth::User()->usertype == 1))
      {  $product= product::all();
        return view ('admin.show_product',compact('product'));}
        else{
            return redirect('login');
        }
    }
    public function delete_product($id){
        $data = product::find($id);
        $data->delete();
        return redirect()->back()->with('message','Product Deleted Successfully ');

    }
    public function edit_product($id){
        if(Auth::id() && (Auth::User()->usertype == 1))
       { $data = product::find($id);
        $catagory= catagory::all();
        return view('admin.edit_product', compact('data','catagory'));}
        else{
            return redirect('login');
        }
    }
    public function update_product(Request $req, $id){
        if(Auth::id() && (Auth::User()->usertype == 1))

       { $pro = product::find($id);
        $pro->title=$req->title;
        $pro->discription=$req->dis;
        $pro->price=$req->price;
        $pro->discount_price=$req->dis_price;
        $pro->quantity=$req->qu;
        $pro->catagory=$req->catagory;

        $image = $req->image;
        if($image){

            $extension = $image->getClientOriginalExtension();
            $imagename = time() . '.' . $extension;
            $req->image->move('product', $imagename);
            $pro->image = $imagename;
        }

        $pro->save();
        $product= product::all();
        return view('admin.show_product',compact('product'))->with('message','Product Updated Successfuly');
        // return redirect()->back()->back()('admin.show_product',compact('product'))->with('message','Product Updated Successfuly');
        }
        else{
            return redirect('login');
        }
    }
    public function order(){
        if(Auth::id() && (Auth::User()->usertype == 1))
        {
        $order= oder::all();
        return view('admin.order', compact('order'));}
        else{
            return redirect('login');
        }
    }
    public function deliverd($id){
        if(Auth::id() && (Auth::User()->usertype == 1))

       { $order= oder::find($id);
        $order->delivery_status="Deliverd";
        $order->save();
        return redirect()->back();
       // return view('admin.order', compact('order'));
       }
       else{
        return redirect('login');
    }
    }
    public function print($id){
        if(Auth::id() && (Auth::User()->usertype == 1)){

            $order=oder::find($id);
            $pdf=\Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pdf',compact('order'));
            return $pdf->download('order_details.pdf');
        }
        else{
            return redirect('login');
        }
    }
    public function send_email($id){
        if(Auth::id() && (Auth::User()->usertype == 1))
{
        $order=oder::find($id);
        return view("admin.email_info", compact('order'));
        }
        else{
            return redirect('login');
        }
    }
    public function send_user_email($id, Request $req){
        if(Auth::id() && (Auth::User()->usertype == 1))

        {$order=oder::find($id);
        $details =[
            "greeting"=>$req->greeting,
            "firstline"=>$req->firstline,
            "body"=>$req->body,
            "button"=>$req->button,
            "url"=>$req->url,
            "lastline"=>$req->lastline,

        ];
        Notification::send($order,new Email($details));
        return redirect()->back();}
        else{
            return redirect('login');
        }
        }

    public function searchdata(Request $req){
        if(Auth::id() && (Auth::User()->usertype == 1))
       { 
        $searchText=$req->search;
        $order=oder::where('name','LIKE',"%$searchText%")->orWhere('phone','LIKE',"%$searchText%")->orWhere('product_title','LIKE',"%$searchText%")->orWhere('product_id','LIKE',"%$searchText%")->orWhere('delivery_status','LIKE',"%$searchText%")->orWhere('email','LIKE',"%$searchText%")->get();
        return view('admin.order', compact('order'));
    }
    else{
        return redirect('login');
    }
    }
  
}
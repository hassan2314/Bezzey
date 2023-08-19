<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      
      <title>Bezzey.pk</title>
     
    
   </head>
   <body>
     
   <h1>PRODUCT DETAILS</h1> <br>
    User Name<h3>{{$order->name}}</h3>
    User Email <h3>{{$order->email}}</h3>
    User Phone<h3>{{$order->phone}}</h3>
    Address<h3>{{$order->address}}</h3>
    User ID<h3>{{ $order->user_id}}</h3>
    Product Name<h3>{{$order->product_title}}</h3>
    Product ID<h3>{{$order->product_id}}</h3>
    Product Price<h3>{{$order->price}}</h3>
    Product Quantity<h3>{{$order->quantity}}</h3>
    Product Status<h3>{{$order->delivery_status}}</h3>
    Payment Status<h3>{{$order->payment_status}}</h3>

    <img src="product/{{$order->image}}"  width="450px">
   </body>
</html>
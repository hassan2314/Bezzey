<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <base href="/public">
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Bezzey.pk</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />
      <style>
       
       .div_center{
           margin: 40px auto;
           width: 40vw;
           text-align: center;
          
           /* border: 3px solid green; */
       }
       table{
        width: 50vw;
       }
       .h2_font{
           font-size: 40px;
           padding-bottom:40px;
       }
      td,th{
       border: 2px solid black;
       /* color: white; */
      }
      .image_size{
       width: 150px;
       height: 150px;
      }
      thead{
       background-color:skyblue;
      }
      th{
       padding:10px
      }
      td{
       padding:5px
      }
      /* .dis{
       width: 200px;
      } */
      .alert {
       position: relative;
   }

   .alert .close {
       position: absolute;
       top: 0;
       right: 0;
       font-size: 35px;
   }
   .tp{
        font-size: 20px;
        padding: 40px;
   }
   /* .main-panel {
    background-color: black;
   } */
       </style>
   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
         <div class="main-panel">
            <div class="content-wrapper">   
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true" id="left">&times;</span>
                        </button>
                    </div>
                    @endif
         <div class="div_center">
                    <h1 class="h2_font">Cart</h1>
                    <table>
                        <thead>
                            <th>Title</th>
                           
                            <th>Price</th>
                            
                            <th>Quantity</th>
                           
                            <th>Image</th>
                            <th>Action</th>
                            
                        </thead>
                        <tbody>
                        <?php
                            $totalPrice=0
                             ?>
                            @foreach($product as $pro)
                           
                            <tr>
                                <td>{{$pro->product_title}}</td>
                               
                                <td>{{$pro->price}}</td>
                               
                                <td>{{$pro->quantity}}</td>
                               
                                <td><img class="image_size" src="/product/{{$pro->image}}" ></td>
                                <td><a onclick ="return confirm('Are you sure to delete')" href="{{url('/delete_cart',$pro->id)}}" class="btn btn-danger">Delete</td>
                                <!-- <td><a  href="{{url('/edit_product',$pro->id)}}" class="btn btn-primary">Edit</td> -->
                                
                            </tr>
                            <?php
                            $totalPrice=$totalPrice+$pro->price;
                             ?>
                            @endforeach
                        </tbody>

                    </table>
                <div class="tp">
                    Total Price : {{$totalPrice}}
                </div>
                <div>
                    <h1 style="padding-bottom: 20px; font-size: 25px; ">Procceed to Oder</h1>
                    <a href="{{url('cash_order')}}" class="btn btn-danger">Cash on Delivery</a>
                    <a href="{{url('stripe',$totalPrice)}}" class="btn btn-danger">Pay Using Card</a>
                </div>

    
        </div>
        </div>
        </div>
        </div>

      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>
      <script>
    document.addEventListener('DOMContentLoaded', function() {
        var closeButton = document.querySelector('.alert .close');
        var alertBox = document.querySelector('.alert');

        closeButton.addEventListener('click', function() {
            alertBox.style.display = 'none';
        });
    });
    </script>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>
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
         form div,h6{
            margin: 10px;
         }
      </style>
   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
      
      <div class="col-sm-6 col-md-4 col-lg-4" style="margin: auto; width: 50vw; padding: 30px;">
                  
                     <div class="img-box">
                        <img src="/product/{{$pro->image}}" alt="" style=" width: 250px; height : 250px; padding: 30px;">
                     </div>
                     <div class="detail-box">
                        <h5>
                       
                        {{$pro->title}}
                        </h5>
                        @if($pro->discount_price!=null)
                        <h6 style=" color: blue;">
                           Discount Price :
                           ${{$pro->discount_price}}
                        </h6>
                         <h6 style="text-decoration: line-through; color: red;">
                         Price :
                           ${{$pro->price}}
                        </h6>
                        @else
                         <h6 style=" color: blue;">
                         Price <br>
                           ${{$pro->price}}
                        </h6>
                        @endif
                        <h6>
                          Product Catagory : {{$pro->catagory}}
                       </h6>
                        
                        <h6>
                        Product Discription : {{$pro->discription}}
                       </h6>

                        <h6>
                        Product Quantity : {{$pro->quantity}}
                       </h6>
                       <form action="{{url('add_cart',$pro->id)}}" method="Post">
                              @csrf
                              <div class="row">
                                 <div class="col-md-4">
                                       <input type="number" name="quantity" value="1" min="1" max="{{$pro->quantity}}" style="width: 70px; color: black; border-radius: 20px;">
                                 </div>
                                 <div class="col-md-4">
                                       <input type="submit" class="btn btn-primary" value="Add to Cart" style="border-radius: 20px;">
                                 </div>
                              </div>
                           </form>
                      
                       </div>
                    </div>
                 </div>
         <!-- comment and reply section -->
      @include('home.comment')
      <!-- end comment and reply section -->
      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>
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
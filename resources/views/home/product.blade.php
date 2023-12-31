<section class="product_section layout_padding">
         <div class="container">
         @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }} <b><a href="{{url('show_cart')}}">Cart</a></b>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true" id="left">&times;</span>
                        </button>
                    </div>
            @endif
            <div class="heading_container heading_center">
               <h2>
                  Our <span>Products</span>
               </h2>
            </div>
            
            <div style="margin:auto; padding-bottom: 30px;padding-top:20px; width:35%">
                            <form method="get" action="{{url('product_search')}}">
                                @csrf
                            <input type="text" name="search" placeholder="Search Here" style="color: black; border-radius:20px;">
                            <input type="submit" value="Search" class="btn btn-outline-primary" style=" border-radius:20px;">
                            </form>
                        </div>
            <div class="row">
               @foreach($product as $pro)
               <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="box">
                     <div class="option_container">
                        <div class="options">
                           <a href="{{url('product_detail',$pro->id)}}" class="option1">
                          Product Detail
                           </a>
                           <form action="{{url('add_cart',$pro->id)}}" method="Post">
                              @csrf
                              <div class="row">
                                 <div class="col-md-4">
                                       <input type="number" name="quantity" value="1" min="1" max="{{$pro->quantity}}" style="width: 70px; color: black; border-radius: 20px;">
                                 </div>
                                 <div class="col-md-4">
                                       <input type="submit" value="Add to Cart" style="border-radius: 20px;">
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="img-box">
                        <img src="/product/{{$pro->image}}" alt="">
                     </div>
                     <div class="detail-box">
                        <h5>
                       
                        {{$pro->title}}
                        </h5>
                        @if($pro->discount_price!=null)
                        <h6 style=" color: blue;">
                           Discount Price <br>
                           ${{$pro->discount_price}}
                        </h6>
                         <h6 style="text-decoration: line-through; color: red;">
                         Price <br>
                           ${{$pro->price}}
                        </h6>
                        @else
                         <h6 style=" color: blue;">
                         Price <br>
                           ${{$pro->price}}
                        </h6>
                        @endif
                       
                     </div>
                  </div>
               </div>
              @endforeach
              <span style="padding-top: 20px;">
               {!!$product->withQueryString()->links('pagination::bootstrap-5')!!}
            </span>
         </div>
      </section>
      document.addEventListener('DOMContentLoaded', function() {
        var closeButton = document.querySelector('.alert .close');
        var alertBox = document.querySelector('.alert');

        closeButton.addEventListener('click', function() {
            alertBox.style.display = 'none';
        });
    });
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
       body {
  overflow-x: auto;
}

       .div_center{
           margin: 40px auto;
           width: 70vw;
           text-align: center;
          
           /* border: 3px solid green; */
       }
       .h2_font{
           font-size: 30px;
           padding-bottom:40px;
       }
      table,td,th{
       border: 2px solid orange;
      }
      .image_size{
       width: 500px;
       /* height: 100px; */
      }
      thead{
       background-color: orange;
      }
      th{
       padding:5px
      }
      td{
       padding:5px
      }
      .dis{
       width: 200px;
      }
      .alert {
       position: relative;
   }

   .alert .close {
       position: absolute;
       top: 0;
       right: 0;
       font-size: 35px;
   }
       </style>
  </head>
  <body>
     <div class="container-scroller">  
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->

        <!-- partial:partials/_navbar.html -->
        @include('admin.navbar')
        <!-- partial -->
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
                        <h1 class="h2_font">All Orders</h1>

                        <div style="margin: auto; padding-bottom: 30px;">
                            <form method="get" action="{{url('search')}}">
                                @csrf
                            <input type="text" name="search" placeholder="Search Name" style="color: black;">
                            <input type="submit" value="Search" class="btn btn-outline-primary">
                            </form>
                        </div>
                        <table>
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            
                            <th>Product Title</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Payment Status</th>
                            <th>Delivery Status</th>
                            <th>Image</th>
                            <th>Deliverd</th>
                            <th>Print PDF</th>
                            <th>Send Email</th>
                            
                        </thead>
                        <tbody>
                            @forelse($order as $pro)
                            <tr>
                                <td>{{$pro->name}}</td>
                                <td>{{$pro->email}}</td>
                                <td>{{$pro->address}}</td>
                                <td>{{$pro->phone}}</td>
                               
                                <td>{{$pro->product_title}}</td>
                                <td>{{$pro->price}}</td>
                                <td>{{$pro->quantity}}</td>
                                <td>{{$pro->payment_status}}</td>
                                <td>{{$pro->delivery_status}}</td>
                                <td><img class="image_size" src="/product/{{$pro->image}}" ></td>
                                <!-- <td><a onclick ="return confirm('Are you sure to delete')" href="{{url('/delete_product',$pro->id)}}" class="btn btn-danger">Delete</td> -->
                                @if($pro->delivery_status=="Processing")
                                <td><a  onclick ="return confirm('Are you sure to deliverd')"  href="{{url('/deliverd',$pro->id)}}" class="btn btn-primary">Deliverd</td> 
                                @else
                                <td> <b>Deliverd</b> </td>
                                @endif
                                <td><a  href="{{url('/print',$pro->id)}}" class="btn btn-secondary">Print</td> 
                                <td><a  href="{{url('/send_email',$pro->id)}}" class="btn btn-info">Send Email</td> 
                            </tr>
                            @empty
                            <div >
                                <td colspan="14">No Data Found</td>
                            </div>
                            @endforelse
                        </tbody>

                    </table>
                  
                </div>
            </div>
        </div>
        
        <!-- container-scroller -->
        <!-- plugins:js -->
        @include('admin.script')
        <!-- End custom js for this page -->
  </body>
</html>
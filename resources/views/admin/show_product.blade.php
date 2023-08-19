<!DOCTYPE html>
<html lang="en">
  <head>
  <base href="/public">
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
       
        .div_center{
            margin: 40px auto;
            width: 70vw;
            text-align: center;
           
            /* border: 3px solid green; */
        }
        .h2_font{
            font-size: 40px;
            padding-bottom:40px;
        }
       td,th{
        border: 2px solid green;
       }
       /* .image_size{
        width: 300px;
        height: 200px;
       } */
       thead{
        background-color:skyblue;
       }
       th{
        padding:20px
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
                    <h1 class="h2_font">Products</h1>
                    <table>
                        <thead>
                            <th>Title</th>
                            <th>Discription</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                            <th>Quantity</th>
                            <th>Catagory</th>
                            <th>Image</th>
                            <th>Delete</th>
                            <th>Edit</th>
                        </thead>
                        <tbody>
                            @foreach($product as $pro)
                            <tr>
                                <td>{{$pro->title}}</td>
                                <td class="dis">{{$pro->discription}}</td>
                                <td>{{$pro->price}}</td>
                                <td>{{$pro->discount_price}}</td>
                                <td>{{$pro->quantity}}</td>
                                <td>{{$pro->catagory}}</td>
                                <td><img class="image_size" src="/product/{{$pro->image}}" ></td>
                                <td><a onclick ="return confirm('Are you sure to delete')" href="{{url('/delete_product',$pro->id)}}" class="btn btn-danger">Delete</td>
                                <td><a  href="{{url('/edit_product',$pro->id)}}" class="btn btn-primary">Edit</td>
                                
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                  
                </div>
            </div>
        </div>
    <!-- container-scroller -->
  
    @include('admin.script')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var closeButton = document.querySelector('.alert .close');
        var alertBox = document.querySelector('.alert');

        closeButton.addEventListener('click', function() {
            alertBox.style.display = 'none';
        });
    });
</script>
    <!-- End custom js for this page -->
  </body>
</html>
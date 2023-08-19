<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
        label{
            color:white;
            display: inline-block;
            width: 200px
        }
        .div_center{
            text-align:center;
            padding-top:40px;
        }
        .h2_font{
            font-size: 40px;
            padding-bottom:40px;
        }
        input[type="text"],input[type="number"],.font_color{
            color: black;
            padding-bottom: 10px;
        }
        .font_color{
            color: black;
            margin-bottom: 40px;
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
                    <h1 class="h2_font">Add Product</h1>
                    <form method="POST" action="{{url('/add_product')}}" enctype="multipart/form-data">
                      @csrf  
                        <div class="container">
                            <div class="mb-3">
                                <label >Title</label>
                                <input type="text" name="title"required>
                            </div>
                            <div class="mb-3">
                                <label >Discription</label>
                                <input type="text"  name="dis"  required>
                                
                            </div>
                            <div class="mb-3">
                                <label >Price</label>
                                <input type="number"name="price" required>
                            </div>
                            <div class="mb-3">
                                <label >Discount Price</label>
                                <input type="number"name="dis_price" >
                            </div>
                            <div class="mb-3">
                                <label >Quantity</label>
                                <input type="number" name="qu"
                                required>
                            </div>
                            <div class="mb-3">
                                <label >Catagory</label>
                                <select name="catagory" class="font_color">
                                    <option value="" selected >Select Catagory</option>
                                    @foreach($catagory as $cat)
                                    <option value="{{$cat->catagory_name}}">{{$cat->catagory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Image</label>
                                <input type="file" name="image" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var closeButton = document.querySelector('.alert .close');
        var alertBox = document.querySelector('.alert');

        closeButton.addEventListener('click', function() {
            alertBox.style.display = 'none';
        });
    });
</script>
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>
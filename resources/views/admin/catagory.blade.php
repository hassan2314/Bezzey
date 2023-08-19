<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
        .div_center{
            text-align:center;
            padding-top:40px;
        }
        .h2_font{
            font-size: 40px;
            padding-bottom:40px;
        }
        #ic{
            color:black;
        }
        .center{
          width: 50%;
          margin: 30px auto;
          text-align:center;
          border: 3px solid green;
        }
        td{
          border: 1px solid white;
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
                <h2 class="h2_font">Add Catagory</h2>
                <form action="{{url('/add_catagory')}}" method="POST">
                  @csrf
                <input type="text" name="name" id="ic" placeholder="Write Catagory Name">
                <input type="submit" name="submit"class="btn btn-primary" value="Add Catagory">
                </form>
            </div>
            <table class="center">
    <tr>
        <td>Catagory Name</td>
        <td>Action</td>
    </tr>
    @foreach($data as $d)
    <tr>
        <td> {{$d->catagory_name}}</td>
        <td><a onclick="return confirm('Are you sure to delete')" href="{{url('delete_catagory',$d->id)}}" class="btn btn-danger">Delete</td>
    </tr>
    @endforeach
</table>
          </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- Include the Bootstrap JavaScript library -->
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
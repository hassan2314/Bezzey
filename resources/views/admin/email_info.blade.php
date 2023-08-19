<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
         label{
            color: white;
            display: inline-block;
            width: 150px;
            padding-right: 30px;
            font-size: 15px;
            font-weight: bold;
            }
            input[type="text"]{
                color:black;
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
                <h1  style="padding-top: 20px; font-size: 25px; text-align: center; ">Send Email to {{$order->email}}</h1> <br>
                <form action="{{url('send_user_email',$order->id)}}" method="post">
                    <div style="padding-left: 35%; padding-top: 35px;">
                    <label>Email Greeting</label>
                        <input name="greeting" type="text">
                    </div>

                    <div style="padding-left: 35%; padding-top: 35px;">
                    <label>Email FirtLine</label>
                        <input name="firstline"type="text">
                    </div>

                    <div style="padding-left: 35%; padding-top: 35px;">
                    <label>Email Body</label>
                        <input name="body" type="text">
                    </div>

                    <div style="padding-left: 35%; padding-top: 35px;">
                    <label>Email Button</label>
                        <input name="button" type="text">
                    </div>

                    <div style="padding-left: 35%; padding-top: 35px;">
                    <label>Email url</label>
                        <input name="url" type="text">
                    </div>

                    <div style="padding-left: 35%; padding-top: 35px;">
                    <label>Email Lastline</label>
                        <input name="lastline" type="text">
                    </div>

                    <div style="padding-left: 35%; padding-top: 35px;">
                        <input type="submit" value="Send Email" class="btn btn-primary">
                    </div>

                </form>
        
                    <!-- <img src="product/{{$order->image}}"  width="450px"> --> 
    </div>
        </div>


    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>
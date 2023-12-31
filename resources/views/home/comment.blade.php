<div style="text-align:center; padding-bottom: 30px; ">
         <h1 style="font-size:30px; text-align:center; padding-top: 20px; padding-bottom: 20px; ">
            Comments
         </h1>
         <form action="{{url('add_comment',$pro->id)}}" method="post">
            @csrf
            <textarea name="comment" id=""style="height:150px; width:600px;" placeholder="Comment Something"></textarea>
            <br>
            <input type="submit" class="btn btn-primary" value="Comment">
         </form>
      </div>
      <div style="padding-left:7%; padding-bottom:10px">
      <h1 style="font-size:20px;  padding-top: 10px; padding-bottom: 20px; ">
            All Comments
         </h1>
</div>
         @foreach($comment as $com)
         <div style="padding-left:10%; padding-bottom:10px;  ">
         <div style="display:flex;">
            <b style="padding-right:7px">{{$com->name}} :  </b>
            <p>{{$com->comment}}</p>

         </div>
            <a href="javascript::void(0);" style="color:blue;" onclick="reply(this)" data-Commentid="{{$com->id}}">Reply</a>
            @foreach($reply as $rep)
            @if($com->id==$rep->comment_id)
               <div style="padding-Left:3%; padding-bottom:10px; ">
               <div style="display:flex;">
                  <b  style="padding-right:7px">{{$rep->name}} :</b>
                  <p>{{$rep->reply}}</p>
               </div>
                  <a href="javascript::void(0);" style="color:blue;" onclick="reply(this)" data-Commentid="{{$com->id}}">Reply</a>
               </div>
            @endif
            @endforeach
</div>
   
          
         @endforeach
         
        
         <div style="display: none" class="replyDiv">
         <form action="{{url('add_reply')}}" method="post">
            @csrf
            <input type="text" id="commentId" name="commentId" hidden>
            <textarea name="reply" id=""style="height:100px; width:400px;" placeholder="Reply Here"></textarea>
               <br>
               <a href="javascript::void(0);" class="btn" onclick="reply_close(this)">Close</a>
               <button type="submit"  class="btn btn-primary" style="background-color: blue;">Reply</button>
         </form>
         </div>
         <script  type="text/javascript">
         function reply(caller){
            document.getElementById("commentId").value=$(caller).attr('data-Commentid');
            $('.replyDiv').insertAfter($(caller));
            $('.replyDiv').show();
         }
         function reply_close(caller){
          
            $('.replyDiv').hide();
         }
         document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
      </script>
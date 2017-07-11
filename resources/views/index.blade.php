

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Ajax CRUD</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

  <!-- Styles -->


  <link  rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  



</head>



<body>
  <div class="container">
    <div class="row">

      <div class="col-md-6 col-md-offset-3">
        <div class="well well-sm">
          <form class="form-horizontal" action="" method="post">
            <fieldset>
              <legend class="text-center">Ajax Crud</legend>
              {{ csrf_field() }}
              <!-- Name input-->
              <div class="form-group">
                <label class="col-md-3 control-label" for="name">Name</label>
                <div class="col-md-9">
                  <input id="name" name="name" type="text" placeholder="Your name" class="form-control">

                  <input type="text" class="form-control" name="Id" id="Id">
                </div>
              </div>        

              <!-- Form actions -->
              <div class="form-group">
                <div class="col-md-12 text-right">
                  <button id="add" type="submit" class="btn btn-primary btn-lg">Submit</button>

                  <button id="update" type="submit"  class="btn btn-primary btn-lg" style="display:none;">Update</button>
                </div>
              </div>
            </fieldset>
          </form>

          {{ csrf_field() }}
          <div class="table-responsive text-center">
            <table class="table table-borderless" id="table">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              @foreach($data as $item)
              <tr class="item{{$item->id}}">
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td> <button id="edit" type="submit" class="edit-modal btn btn-info" 
                 data-id="{{$item->id}}" data-name="{{$item->name}} ">
                 <span class="glyphicon glyphicon-edit"></span> Edit
               </button>
               <button id="delete" class="delete-modal btn btn-danger"
               data-id="{{$item->id}}" data-name="{{$item->name}}">
               <span class="glyphicon glyphicon-trash"></span> Delete
             </button></td>
           </tr>
           @endforeach
         </table>
       </div>


     </div>
   </div>
 </div>
</div>

{{-- popup --}}

{{--end popup --}}

</body>
</html>

<script
src="https://code.jquery.com/jquery-3.2.1.min.js"
integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
crossorigin="anonymous"></script>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>


<script type="text/javascript">

  $(document).ready(function() {

    $("#add").click(function() {

      $.ajax({
        post: 'post',
        url : 'ajax.store',
        data: {
          '_token': $('input[name=_token]').val(),
          'name':$('#name').val()
        },
        success: function(data) {
          if ((data.errors)){
            $('.error').removeClass('hidden');
            $('.error').text(data.errors.name);
          }
          else {
            $('.error').addClass('hidden');
            $('#table').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
          }
        },

      });
      $('#name').val('');
    });


    $("#edit").click(function() {

      $('#update').css('display','block');
      $('#name').val($(this).data('name'));
      $('#Id').val($(this).data('id'));
    });
    
    $("#update").click(function() {

      $.ajax({
        type: 'post',
        url: 'ajax.update',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': $("#Id").val(),
          'name': $('#name').val()
        },
        success: function(data) {
          $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
          alert ('Completed');
        }
      });
    });


    $("#delete").click(function() {
     $.ajax({
      type: 'post',
      url: '/delete',
      data: {
        '_token': $('input[name=_token]').val(),
        'id': $("#Id").val()
      },
      success: function(data) {
        $('.item' + $('#Id').text()).remove();
      }
    });
   });

  });


</script>
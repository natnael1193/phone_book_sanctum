{{-- @extends('layouts.admin')
@section('content')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="container">
  <h4>Add New Company Category</h4>
 
  <form method="POST" action="{{ route('company_category.store') }}">
    @csrf
  <div class="form-group row">

    <table class="table">
    <thead>
      <tr>
        <th>Company Category</th>

        <th><a href="javascritp:;" class="btn btn-info addRow" >Add + </a></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="text" name="name[ ]" id="name" class="form-control"></td>
        <td><a href="javascritp:;" class="btn btn-danger deleteRow" >Delete - </a></td>
    </tr>

    </tbody>
  </table>
  <button type="submit" class="btn btn-success">Submit</button>
</div>
</form>
</div>


<script>
    $('thead').on('click', '.addRow', function(){
        var tr = '<tr>' + 
            '<td><input type="text" name="name[ ]" id="name" class="form-control"></td>'+ 
  '<td><a href="javascritp:;" class="btn btn-danger deleteRow" >Delete - </a></td>'+ 
    '</tr>';
$('tbody').append(tr);

    });

    $('tbody').on('click', '.deleteRow', function(){
        $(this).parent().parent().remove();
    })
</script>


@endsection --}}


@extends('layouts.admin')
@section('content')

<div class="row" style="display: flex; justify-content: center; align-items: center">
  <button class="btn btn-info" data-toggle="modal" data-target="#defaultModalPrimary">Add Company Category</button>
  <br>
  <table class="table table-light">
      <thead class="thead-light">
          <tr>
              <th>Category Name</th>
              <th></th>
              <th></th>
              <th colspan="">Actions</th>
          </tr>
      </thead>
      <tbody>
          @foreach($post as $posts)
          <tr>
          <td>{{$posts->name}}</td>
          <td></td>
          <td></td>
          {{-- <td><button class="btn btn-info" data-toggle="modal" data-target="#defaultModalPrimary{{$posts->id}}">Edit</button></td> --}}
          </tr>
          @endforeach
      </tbody>
      <tfoot>
          <tr>
              <th>#</th>
          </tr>
      </tfoot>
  </table>
</div> 
</div>



<div class="card">
<div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
      <h5 class="modal-title">Add Company Category</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
  </div>
  <div class="modal-body m-3">
      
<form method="POST" action="{{route('company_category.store')}}">
          @csrf
      <div class="row">
          <div class="form-group col-xl-12">
       <div class="form-group">
           <label for="my-select">Company Category</label>
           <input type="text" name="name" class="form-control" >
       </div>
          </div>
      </div>
      <button type="submit" class="btn btn-success">Submit</button>
  </form>
  </div>
</div>
</div>
</div>
</div>
@endsection
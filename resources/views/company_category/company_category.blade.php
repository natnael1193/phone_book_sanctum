@extends('layouts.admin')
@section('content')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="container">
  <h4>Add New Company Category</h4>
  {{-- <p>The .table class adds basic styling (light padding and horizontal dividers) to a table:</p>             --}}
  <form method="POST" action="{{ route('company_category.store') }}">
    @csrf
  <div class="form-group row">

    <table class="table">
    <thead>
      <tr>
        <th>Company Category</th>
        {{-- <th>Lastname</th> --}}
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


@endsection

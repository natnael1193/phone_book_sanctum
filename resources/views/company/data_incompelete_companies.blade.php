@extends('layouts.admin')
@section('content')


<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Company Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th colspan="3">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($post as $posts)
        <tr>
            <td>{{ $posts->company_name }}</td>
            <td>{{ $posts->company_email }}</td>
            <td>{{ $posts->phone_number }}</td>
            <td><div class="btn-list d-flex ">
                {{-- <form method="POST" action="{{ route('company.called', $posts->id) }}">
                    @csrf
                    @if( $posts->called == NULL)
                    <input type="hidden" name="user_id" >
                    <input type="hidden" name="verification" >
                    <button class="btn btn-info mr-2" type="submit">Never Called</button>
                       @else
                       <input type="hidden" name="user_id" >
                       <input type="hidden" name="verification" >
                      <button class="btn btn-warning mr-2" type="submit">Called</button>
     @endif
                     </form> --}}
                     {{-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#defaultModalPrimary{{$posts->id}}">
                        Add Category
                     </button> --}}
                     @if( $posts->called == NULL) 
       <button type="button" class="btn btn-info mr-2" data-toggle="modal" data-target="#defaultModalPrimary{{$posts->id}}">Never Called</button>

@elseif($posts->called == 1)
       <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#defaultModalPrimary{{$posts->id}}">No Answer</button>
@else
       <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#defaultModalPrimary{{$posts->id}}">Don't give information</button>
@endif
<a href="{{ route('company.edit', $posts->id) }}"><button class="btn btn-primary mr-2" >Edit</button></a>
                {{-- <form method="POST" action="">
                    @csrf
                    @method('PATCH')
                @if($posts->verification == null || $posts->verification == 0)
                <input type="hidden" value="1" name="verification">
                <button class="btn btn-info mr-2 "  type="submit">Verify</button>
                @else
                <input type="hidden" value="null" name="verification">
                <button class="btn btn-warning mr-2"  type="submit">Cancel verification</button>
                @endif
                </form> --}}
        
     
                <form method="POST" action="{{ route('company.destroy', $posts->id) }}">
                @csrf
                @method('DELETE')
              <a href=""><button class="btn btn-danger " >Delete</button></a>
              </form>
              </div>
              <td>

        </tr>

          
           
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
        </tr>
    </tfoot>
</table>

@foreach($post as $posts)
<div class="card">
    <div class="modal fade" id="defaultModalPrimary{{$posts->id}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Cateogry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
                </div>
                <div class="modal-body m-3">
                    
            <form method="POST" action="{{ route('company.called', $posts->id)  }}">
                        @csrf
                    <div class="row">
                        <input type="hidden" name="user_id" >
                        <input type="hidden" name="verification" >
                        <div class="form-group col-xl-12">
                     <div class="form-group">
                         <label for="my-select">Company Calls  {{$posts->id}}</label>
                         <select id="my-select" class="form-control" name="called" >
                             <option value=''>Never Called</option>
                             <option value="1">No Answer</option>
                             <option value="2"><h5>Answer (Did Not Send Information)</h5></option>
                         </select>
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
    @endforeach

@endsection
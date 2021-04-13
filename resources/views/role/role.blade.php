@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Roles</div>

                <div class="card-body">
<form method="post" action="{{ route('role.store') }}">
    @csrf
    <div class="form-group">
        <label for="my-select">Role</label>
      <input class="form-control" type="text" name="name">
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('content')

                
                <div class="card col-xl-9 col-lg-9 col-md-9">
                    {{-- <div class="row col-xl-9 col-lg-9 col-md-9"> --}}
            <form method="POST" action="{{ route('user.update_user', $user->id) }}">
                        @csrf
                        <input hidden value="{{$user->role}}">
                    <div class="row">
                        <div class="form-group col-xl-12">
                            {{-- <label>Role</label> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xl-12">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$user->name}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xl-12">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xl-12">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
</div>
</div>
@endsection
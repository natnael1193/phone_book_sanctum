@extends('layouts.admin')
@section('content')

{{-- <main class="content"> --}}
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Tables</h1>

        <div class="row">
            <div class="col-12 col-xl-10">
                <div class="card">
                    <div class="card-header">           
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#defaultModalPrimary">
                           Add User
                        </button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%;">Name</th>
                                <th style="width:25%">Email</th>
  
                                <th class="d-none d-md-table-cell" style="width:25%">Role</th>
                                <th style="width:25%">Posts</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user as $users)
                            <tr>
                                 <td><a href="/admin/{{ $users->id }}">{{ $users->name }}</a></td>
                                <td>{{ $users->email }}</td>
                             <td class="d-none d-md-table-cell">{{App\Role::findOrFail($users->role)->name }}</td>
                                <td>@if($users->role == 4){{ DB::table('companies')->where('user_id', $users->id)->count() }}@elseif($users->role  == 5){{ DB::table('blogs')->where('user_id', $users->id)->count() }}@else 0 @endif</td>
                                <td class="table-action">
                                    <a href="#"><i class="align-middle" data-feather="edit-2"></i></a>
                                    <a href="#"><i class="align-middle" data-feather="trash"></i></a>
                                </td>
                            </tr>
  @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- </main> --}}
<div class="card">
    
        
        <!-- BEGIN primary modal -->
    
        <div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Default modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
                    </div>
                    <div class="modal-body m-3">
                        
                <form method="POST" action="{{ route('user.register') }}">
                            @csrf
                        <div class="row">
                            <div class="form-group col-xl-12">
                                {{-- <label>Role</label> --}}
                                <div class="form-group">
                                    <label for="my-select">Role</label>
                                    <select id="my-select" class="form-control" name="role">
                                        @foreach($role as $roles)
                                        <option value="{{ $roles->id }}">{{ $roles->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                    </div>
    </div>
</div>
</div>

@endsection
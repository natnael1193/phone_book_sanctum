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
                        Add Bank
                    </button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:30%;">Bank Name</th>
                            <th style="width:30%;">Account Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banks as $bank)
                        <tr>
                            <td style="color: black">{{ $bank->name }}</td>
                            <td style="color: black">{{ $bank->account_no }}</td>
                            <td class="d-flex"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#defaultModalEdit{{$bank->id}}">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('bank.destroy', $bank->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger ml-3" type="submit">Delete</button>
                                </form>
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

                    <form method="POST" action="{{ route('bank.store') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label>Bank Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group col-xl-12">
                                <label>Bank Name Amharic</label>
                                <input type="text" class="form-control" name="name_am">
                            </div>
                            <div class="form-group col-xl-12">
                                <label>Account Number</label>
                                <input type="text" class="form-control" name="account_no">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@foreach($category as $categories)
<div class="card">
    <div class="modal fade" id="defaultModalEdit{{$categories->id}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Default modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <form method="POST" action="{{ route('bank.update', $categories->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label>Category Name</label>
                                <input type="text" class="form-control" name="name" value="{{$categories->name}}">
                            </div>
                            <div class="form-group col-xl-12">
                                <label>Category Name (Amharic)</label>
                                <input type="text" class="form-control" name="name_am" value="{{$categories->name_am}}">
                            </div>
                            <div class="form-group col-xl-12">
                                <label>Account Number</label>
                                <input type="text" class="form-control" name="account_no" value="{{$categories->account_no}}">
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
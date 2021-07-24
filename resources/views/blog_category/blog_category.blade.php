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
                            Add Category
                        </button>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width:40%;">Name</th>
                             <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($post as $posts)
                            <tr>
                                <td style="color: black">{{ $posts->name }}</td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#defaultModalEdit{{$posts->id}}">
                                       Edit
                                    </button></td>
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

                        <form method="POST" action="{{ route('blog_category.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-xl-12">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group col-xl-12">
                                    <label>Category Name (Amharic)</label>
                                    <input type="text" class="form-control" name="name_am">
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

                        <form method="POST" action="{{ route('blog_category.update', $categories->id) }}">
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

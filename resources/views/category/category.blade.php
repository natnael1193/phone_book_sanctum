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
                                <th style="width:40%;">Amharic Name</th>
                                {{-- <th class="d-none d-md-table-cell" style="width:25%">Role</th> --}}
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <ul> --}}
                                @foreach ($categories as $category)
                                <tr>
                                    <td>
{{--                                @if($category->id == 1)--}}
{{--                                <h4></h4>--}}
{{--                                @else--}}
                                    <li><a href="{{route('category.edit', $category->id)}}">{{ $category->name }}</a></li>
{{--                                    @endif--}}
                                    <ul>
                                    @foreach ($category->childrenCategories as $childCategory)
                                        @include('category.child_category', ['child_category' => $childCategory])
                                    @endforeach
                                    {{-- </ul> --}}

                            </td>
                            {{-- <td>{{ $category->category_id }}</td> --}}
                                @endforeach
                            {{-- </ul> --}}
                        </tr>
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
                        <h5 class="modal-title">Add Cateogry</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
                    </div>
                    <div class="modal-body m-3">

                <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <div class="form-group col-xl-12">
                                <label for="my-select">Category</label>
                                <select id="my-select" class="form-control"   name="category_id">
                                    {{-- <option>Select Category</option> --}}
                                    @foreach($sub_category as $sub_categories)
                                    <option value="{{ $sub_categories->id }}">{{ $sub_categories->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-xl-12">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group col-xl-12">
                                <label>Amharic Name</label>
                                <input type="text" class="form-control" name="name_am">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                    </div>
    </div>
</div>
</div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
@endsection

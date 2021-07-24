@extends('layouts.admin')
@section('content')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
	<main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto ml-auto text-right mt-n1">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                            <li class="breadcrumb-item"><a href="{{route('blog.index')}}">Blog</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Blog</li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Edit Blog</li> --}}
                        </ol>
                    </nav>
                </div>
            </div>

            <h1 class="h3 mb-3">Add New  Blog</h1>

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input hidden  name="user_id">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="image" imageOnly>

{{--                                            <input type="file" class="filepond" id="image">--}}
                                        </div>
                                </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="my-select">Blog Category</label>
                                            <select id="my-select" class="form-control" name="category_id">
                                                <option value=null>Select Blog Category</option>
                                                @foreach(App\BlogCategroy::all()->sortBy('name') as $subscribers)
                                                    <option value="{{$subscribers->id}}">{{$subscribers->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" placeholder="Title" name="title" >
                                        </div>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Title (Amharic)</label>
                                            <input type="text" class="form-control" placeholder="Title" name="title_am" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                     <textarea class="form-control" id="summary-ckeditor" placeholder="description" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Description (Amharic)</label>
                                            <textarea class="form-control" id="summary-ckeditor" placeholder="description" name="description_am"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        // Get a reference to the file input element
        const inputElement = document.querySelector('input[id="image"]');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement);
        FilePond.setOptions({
            server: {
                url: '/blog_image',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    </script
    @endsection

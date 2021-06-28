@extends('layouts.admin')
@section('content')
	<main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto ml-auto text-right mt-n1">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                            <li class="breadcrumb-item"><a href="{{route('tender.index')}}">Tender</a></li>
                            {{-- <li class="breadcrumb-item"><a href="{{route('tender.create')}}">Add Tender</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Edit Tender</li>
                        </ol>
                    </nav>
                </div>
            </div>
            {{-- <h1 class="h3 mb-3">Add New  Company</h1> --}}

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('tender.update', $post->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input hidden value="{{ $post->user_id }}"name="user_id">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Opening Date</label>
                                            <input type="date" class="form-control" placeholder="Opening Date" name="opening_date" value="{{$post->opening_date}}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Closing Date</label>
                                            <input type="date" class="form-control" placeholder="Closing Date" name="closing_date" value="{{$post->closing_date}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
<div class="form-group">
    <label for="my-select">Select Company</label>
    <select id="my-select" class="form-control"  name="company_id">
        <option value="{{$post->company_id}}">Select Company</option>
        @foreach($company as $companies)
        <option value={{$companies->id}}>{{$companies->company_name}}</option>
        @endforeach
    </select>
</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" value="{{ $post->image }}" name="image" imageOnly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="my-select">Select Category</label>
                                        <select id="my-select" class="form-control" name="category_id">
                                            {{--                                            <option value=null>Select Category</option>--}}
                                            @foreach(App\Category::all() ->sortBy('name') as $categories)
                                                @if($categories->id == 1)
                                                    <option value="{{ $post->category_id }}">Select Category</option>
                                                @else
                                                    <option value={{$categories->id}} required>{{$categories->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Price</label>
                                            <input type="text" class="form-control" placeholder="Price" name="price" value="{{$post->price}}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Bond</label>
                                            <input type="text" class="form-control" placeholder="Bond" name="bond" value="{{$post->bond}}">
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" placeholder="Title" value="{{ $post->title }}" name="title" imageOnly>
                                        </div>
                                        </div>
                                    </div>

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                     <textarea class="form-control" id="summary-ckeditor" placeholder="description" name="description">{{ $post->description }}</textarea>
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
    @endsection

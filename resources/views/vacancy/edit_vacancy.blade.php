@extends('layouts.admin')
@section('content')
	<main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto ml-auto text-right mt-n1">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                            <li class="breadcrumb-item"><a href="{{route('vacancy.index')}}">Vacancy</a></li>
                            {{-- <li class="breadcrumb-item"><a href="{{route('vacancy.create')}}">Add Vacancy</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Edit Vacancy</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <h1 class="h3 mb-3">Edit Vacancy</h1>

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('vacancy.update', $post->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input hidden value="{{ $post->user_id }}" name="user_id">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Due Date</label>
                                            <input type="date" name="due_date" placeholder="Due Date" class="form-control" value="{{$post->due_date}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Company</label>
                                            <select id="my-select" class="form-control" name="company_id" required>
                                                <option value="{{$post->company_id}}">Select Company</option>
                                                @foreach(App\Company::all()->sortBy('name') as $companies)
                                                <option value="{{ $companies->id }}">{{ $companies->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Category</label>
                                            <select id="my-select" class="form-control" name="category_id" required>
                                                <option value="{{$post->category_id}}">Select Category</option>
                                                @foreach($category as $categories)
                                                <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Job Type</label>
                                            <select id="my-select" class="form-control" name="job_type" >
                                                <option value="{{$post->job_type}}">Select Job Type</option>
                                                {{-- @foreach($company as $companies) --}}
                                                <option value="1">Full Time</option>
                                                <option value="2">Part Time</option>
                                                <option value="3">Remotely</option>
                                                {{-- @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Location</label>
                                            <select id="my-select" class="form-control" name="location">
                                                <option value="{{$post->location}}">Select Location</option>
                                                @foreach(App\Location::all() as $locations)
                                                <option value="{{ $locations->id }}">{{ $locations->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" value="{{ $post->image }}" name="image" imageOnly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Company</label>
                                            <input type="text" class="form-control" placeholder="Title" value="{{ $post->company }}" name="company" >
                                        </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" placeholder="Title" value="{{ $post->title }}" name="title" >
                                        </div>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Title (Amharic)</label>
                                            <input type="text" class="form-control" placeholder="Title" value="{{ $post->title_am}}" name="title_am" >
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

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Description (Amharic)</label>
                                            <textarea class="form-control" id="summary-ckeditor1" placeholder="description" name="description_am">{{ $post->description_am }}</textarea>
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

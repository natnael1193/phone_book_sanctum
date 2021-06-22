@extends('layouts.admin')
@section('content')
	<main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="row col-xl-8 col-lg-8 col-md-8 col-sm-12" role="alert">
                    @if(Session::has('message'))
                    <p class="alert alert-info">{{ Session::get('message') }}</p>
                    @endif

                    </div>
                <div class="col-auto ml-auto text-right mt-n1">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                            <li class="breadcrumb-item"><a href="{{route('vacancy.index')}}">Vacancy</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Vacancy</li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Edit Blog</li> --}}
                        </ol>
                    </nav>
                </div>
            </div>
            <h1 class="h3 mb-3">Add New  Vacancy</h1>

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('vacancy.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input hidden  name="user_id">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Due Date</label>
                                            <input type="date" name="due_date" placeholder="Due Date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Company</label>
                                            <select id="my-select" class="form-control" name="company_id" required>
                                                <option>Select Company</option>
                                                @foreach($company as $companies)
                                                <option value="{{ $companies->id }}">{{ $companies->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Category</label>
                                            <select id="my-select" class="form-control" name="category_id" required>
{{--                                                <option>Select Category</option>--}}
                                                @foreach($category as $categories)
                                                    @if($categories->id == 1)
                                                        <option value=null>Select Category</option>
                                                    @else
                                                        <option value={{$categories->id}} required>{{$categories->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Job Type</label>
                                            <select id="my-select" class="form-control" name="job_type" required>
                                                <option>Select Job Type</option>
                                                {{-- @foreach($company as $companies) --}}
                                                <option value="1">Full Time</option>
                                                <option value="2">Part Time</option>
                                                <option value="3">Contractual</option>
                                                {{-- @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Location</label>
                                            <select id="my-select" class="form-control" name="location" required>
                                                <option>Select Location</option>
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
                                            <input type="file" class="form-control" placeholder="Email" name="image" imageOnly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Company</label>
                                            <input type="text" class="form-control" placeholder="Company" name="company" >
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
                                            <label class="form-label">Description</label>
                                     <textarea class="form-control" id="summary-ckeditor" placeholder="description" name="description"></textarea>
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

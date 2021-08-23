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
                    <div class="row">
                        <div class="row col-xl-8 col-lg-8 col-md-8 col-sm-12">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#defaultModalPrimary">
                        Add Company
                    </button>
                        </div>
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
                                                <option value="">Select Company</option>
                                                @foreach($company->sortBy('company_name')  as $companies)
                                                <option value="{{ $companies->id }}">{{ $companies->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Category</label>
                                            <select id="my-select" class="form-control" name="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach($category as $categories)
                                                        <option value={{$categories->id}} required>{{$categories->name}}</option>
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
                                                <option value="">Select Job Type</option>
                                                @foreach(App\JobType::all()->sortBy('name') as $job_types)
                                                <option value="{{ $job_types->id }}">{{ $job_types->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label for="my-select">Location</label>
                                            <select id="my-select" class="form-control" name="location" required>
                                                <option value="">Select Location</option>
                                                @foreach(App\Location::all()->sortBy('name')  as $locations)
                                                <option value="{{ $locations->id }}">{{ $locations->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" placeholder="Phone"
                                              name="phone">
                                        </div>
                                    </div>
                                  
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label class="form-label">Min Salary</label>
                                            <input type="number" class="form-control" placeholder="Min Salary"
                                                 name="min_salary">
                                        </div>
                                    </div>
                         
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sl-12">
                                        <div class="form-group">
                                            <label class="form-label">Max Salary</label>
                                            <input type="number" class="form-control" placeholder="Max Salary"
                                               name="max_salary">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="image" imageOnly>
                                        </div>
                                    </div>
{{-- 
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Company</label>
                                            <input type="text" class="form-control" placeholder="Company" name="company" required>
                                        </div>
                                        </div>
                                    </div> --}}

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" placeholder="Title" name="title" required>
                                        </div>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Title (Amharic)</label>
                                            <input type="text" class="form-control" placeholder="Title" name="title_am" required>
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
                                            <textarea class="form-control" id="summary-ckeditor1" placeholder="description" name="description_am"></textarea>
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
    
                            <form method="POST" action="{{ route('add_company') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-xl-12">
                                        {{-- <label>Role</label> --}}
                                        <input hidden name="user_id" value="{{auth()->user()->id}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Company Category</label>
                                            <select id="my-select" class="form-control" name="category_id">                                                           >
                                                  <option value=null>Select Category</option>
                                                @foreach(App\Category::all()->sortBy('name') as $posts)
                                                        <option
                                                            value="{{ $posts->id }}">{{ $posts->name }}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Location</label>
                                            <select id="my-select" class="form-control" name="location_id"
                                                    >
                                                <option value="">Select Location</option>
                                                @foreach(App\Location::all()->sortBy('name')  as $locations)
                                                    <option
                                                        value="{{ $locations->id }}">{{ $locations->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Company Status</label>
                                            <select id="my-select" class="form-control" name="company_category"
                                                    >
                                                <option value="">Select Company Status</option>
                                                @foreach(App\CompanyCategory::all()->sortBy('name')  as $company_categories)
                                                    <option
                                                        value="{{ $company_categories->id }}">{{ $company_categories->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Company Verification</label>
                                            <select id="my-select" class="form-control" name="verification"
                                                    >
                                                <option value="">Select Category</option>
                                                <option value="">Not Verified</option>
                                                <option value="1">Verified</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-xl-12">
                                        <label>Company Name</label>
                                        <input type="text" class="form-control" name="company_name" placeholder="company name">
    
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xl-12">
                                        <label>Company Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               placeholder="company email" name="company_email" autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xl-12">
                                        <label>Phone Number</label>
                                        <input type="number"
                                               class="form-control" 
                                               name="phone_number" placeholder="phone number"
                                               autocomplete="phone_number">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" placeholder="Address"
                                                   name="address">
                                            {{-- <select id="my-select" class="form-control" name="company_name" >
                                                <option value="">Select Company</option>
                                                @foreach($all as $items)
                                                <option value="{{$items->id}}">{{$items->company_name}}</option>
                                                @endforeach
                                            </select> --}}
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Specific Address</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Specific Address" name="specific_address">
                                        </div>
                                        {{-- <div class="form-group">
                                            <label class="form-label">Email address</label>
                                            <input type="email" class="form-control" placeholder="Email" name="email" >
                                        </div> --}}
                                    </div>
                                </div>
 
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    
    </main>
    @endsection

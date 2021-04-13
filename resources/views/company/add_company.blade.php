@extends('layouts.admin')
@section('content')
	<main class="content">
        <div class="container-fluid p-0">

            <h1 class="h3 mb-3">Add New  Company</h1>

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input hidden value="" name="user_id">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="company_logo_path" imageOnly>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Company Category</label>
                                            <select id="my-select" class="form-control" name="category_id" required>
                                                <option>Select Category</option>
                                                @foreach($post as $posts)
                                                <option value="{{ $posts->id }}">{{ $posts->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" name="company_name" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Email address</label>
                                            <input type="email" class="form-control" placeholder="Email" name="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                        <label class="form-label">Phone 1</label>
                                        <input type="text" class="form-control" placeholder="Phone 1" name="phone_number" required>
                                    </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                    <label class="form-label">Phone 2</label>
                                    <input type="text" class="form-control" placeholder="Phone 2" name="phone_number_2">
                                </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Website </label>
                                            <input type="text" class="form-control" placeholder="Website" name="website">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Fax</label>
                                            <input type="text" class="form-control" placeholder="Fax" name="fax">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Location  Image Path</label>
                                            <input type="file" class="form-control" placeholder="Location  Image Path" name="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Company Image</label>
                                            <input type="file" class="form-control" placeholder="Location  Image Path" name="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Category</label>
                                            <select id="my-select" class="form-control" name="company_category" required>
                                                <option>Select Category</option>
                                                @foreach($company_category as $company_categories)
                                                <option value="{{ $company_categories->id }}">{{ $company_categories->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Company Verification</label>
                                            <select id="my-select" class="form-control" name="verification" required>
                                                <option>Select Category</option>
                                                <option value="0">Not Verified</option>  
                                                <option value="1">Verified</option>                                            
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                     <textarea class="form-control" placeholder="description" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Services</label>
                                     <textarea class="form-control" placeholder="service" name="description"></textarea>
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
@extends('layouts.admin')
@section('content')
	<main class="content">
        <div class="container-fluid p-0">

            <h1 class="h3 mb-3">Add Your Company</h1>

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('subscriber.store_company') }}" enctype="multipart/form-data">
                                @csrf
                                <input hidden value="" name="user_id">
                                <input hidden value="1" name="company_category">
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
                                            <label class="form-label">ስም</label>
                                            <input type="text" class="form-control" placeholder="Name" name="company_name_am" required>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label class="form-label">Email address</label>
                                            <input type="email" class="form-control" placeholder="Email" name="email" required>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="Email" name="email" required>
                                        </div>
                                    </div>
                                    {{-- <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">ስም</label>
                                            <input type="text" class="form-control" placeholder="Name" name="company_name_am" required>
                                        </div>
                                    </div> --}}
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
                                            <label class="form-label">ገለጻ</label>
                                     <textarea class="form-control" placeholder="Amharic Description" name="description_am"></textarea>
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
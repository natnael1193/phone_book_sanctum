@extends('layouts.admin')
@section('content')
	<main class="content">
        <div class="container-fluid p-0">

            <h1 class="h3 mb-3">Add New  Company</h1>
{{-- <p>{{ $user->id }}</p> --}}
            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input hidden  name="user_id">
                                <input hidden  name="company_id" value="{{ $user->id }}">
                                <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="image1" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Image1</label>
                                            <input type="file" class="form-control" placeholder="Email" name="image2" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="image3" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="image4" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="image5" accept="image/*">
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
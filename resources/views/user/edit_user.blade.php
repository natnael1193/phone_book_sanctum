@extends('layouts.admin')
@section('content')
	<main class="content">
        <div class="container-fluid p-0">

            <h1 class="h3 mb-3">Edit User</h1>

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input hidden value="" name="user_id">
                                <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="image" imageOnly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" placeholder="Email" name="title" imageOnly>
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
                    
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endsection
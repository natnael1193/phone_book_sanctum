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
                            <li class="breadcrumb-item"><a href="{{route('tender.index')}}">Tender</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Tender</li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Edit Blog</li> --}}
                        </ol>
                    </nav>
                </div>
            </div>
            <h1 class="h3 mb-3">Add New Tender</h1>

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('tender.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input hidden  name="user_id">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Opening Date</label>
                                            <input type="date" class="form-control" placeholder="Opening Date" name="opening_date" >
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Closing Date</label>
                                            <input type="date" class="form-control" placeholder="Closing Date" name="closing_date" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
<div class="form-group">
    <label for="my-select">Select Company</label>
    <select id="my-select" class="form-control" name="company_id">
        <option value=null>Company</option>
        @foreach($company as $companies)
        <option value={{$companies->id}}>{{$companies->company_name}}</option>
        @endforeach
    </select>
</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email"  name="image" imageOnly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Price</label>
                                            <input type="text" class="form-control" placeholder="Price" name="price" >
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Bond</label>
                                            <input type="text" class="form-control" placeholder="Bond" name="bond" >
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
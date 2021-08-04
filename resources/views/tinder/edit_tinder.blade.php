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
            <div class="col-12 col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('tender.update', $post->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input hidden value="{{ $post->user_id }}" name="user_id">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Opening Date</label>
                                        <input type="date" class="form-control" placeholder="Opening Date" name="opening_date" value="{{$post->opening_date}}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Closing Date</label>
                                        <input type="date" class="form-control" placeholder="Closing Date" name="closing_date" value="{{$post->closing_date}}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Closing time</label>
                                        <input type="datetime" class="form-control" placeholder="Closing Date" name="closing_time" value="{{$post->closing_time}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="my-select">Select Company</label>
                                        <select id="my-select" class="form-control" name="company_id">
                                            <option value="{{$post->company_id}}">Select Company</option>
                                            @foreach($company as $companies)
                                            <option value="{{$companies->id}}" required>{{$companies->company_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control" placeholder="Email" value="{{ $post->image }}" name="image" imageOnly>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="my-select">Select Location</label>
                                        <select id="my-select" class="form-control" name="location">
                                            @if(count($locations) > 0)
                                                <option value="{{$post->location}}">{{$post->location}}</option>
                                                @foreach($locations as $companies)
                                                    <option value="{{$companies->id}}" required>{{$companies->name}}</option>
                                                @endforeach
                                            @else
                                                <option value=null>No Location Found</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="my-select">Select Category</label>
                                    <select id="my-select" class="form-control" name="tender_sub_category_id">
                                        @if(App\TenderCategory::all()->count() > 0)
                                            @foreach(App\TenderCategory::all() ->sortBy('name') as $categories)
                                                <optgroup label="{{$categories->name}}">
                                                    <option value="{{ $post->tender_sub_category_id }}">{{ $data = App\TenderSubCategory::find($post->tender_sub_category_id)->name }}</option>
                                                    @if($categories->categories->count() > 0)
                                                        @foreach($categories->categories as $category)
                                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option>No Sub Categories Found</option>
                                                    @endif
                                                </optgroup>
                                            @endforeach  
                                        @else
                                        <option value="">No Categories Found</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="my-select">Select Tender Type</label>
                                    <select id="my-select" class="form-control" name="type">
                                        <option value="{{ $post->type }}" required>{{ $post->type }}</option>
                                        <option value="free" required>Free</option>
                                        <option value="premium" required>Premium</option>
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
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Reference</label>
                                        <select id="my-select" class="form-control" name="reference">
                                            <option value="{{ $post->reference}}">{{ $post->reference}}</option>
                                            <option value="hulum.et">hulum.et</option>
                                            <option value="the_reporter">The Reporter</option>
                                            <option value="Addis Zemen">Addis Zemen</option>
                                            <option value="Ethiopian Herald">Ethiopian Herald</option>
                                            <option value="Reporter">Reporter</option>
                                            <option value="The Daily Monitor">The Daily Monitor</option>
                                            <option value="Fortune">Fortune</option>
                                            <option value="Be'kur">Be'kur</option>
                                            <option value="Capital">Capital</option>
                                            <option value="Ethiotelecom">Ethiotelecom</option>
                                            <option value="Addis Lessan">Addis Lessan</option>
                                            <option value="Yedebub Negat">Yedebub Negat</option>
                                            <option value="Addis Admas">Addis Admas</option>
                                            <option value="Kallacha Oromiyaa">Kallacha Oromiyaa</option>
                                            <option value="Mekalih Tigray">Mekalih Tigray</option>
                                            <option value="Melekite Dire">Melekite Dire</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Deference Publish Date</label>
                                        <input type="date" class="form-control" placeholder="Bond" value="{{$post->reference_date}}" name="reference_date">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" placeholder="Title" value="{{ $post->title }}" name="title">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Title (Amharic)</label>
                                        <input type="text" class="form-control" placeholder="Title" value="{{ $post->title_am }}" name="title_am">
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
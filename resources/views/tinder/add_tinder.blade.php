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
            <div class="col-12 col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('tender.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input hidden name="user_id">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Opening Date</label>
                                        <input type="date" class="form-control" placeholder="Opening Date" name="opening_date">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Closing Date</label>
                                        <input type="date" class="form-control" placeholder="Closing Date" name="closing_date">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Closing time</label>
                                        <input type="datetime" class="form-control" placeholder="Closing Date" name="closing_time">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="mb-3">
                              <label for="" class="form-label"></label>
                              <input type="text|password|email|number|submit|date|datetime|datetime-local|month|color|range|search|tel|time|url|week" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
                              <small id="helpId" class="text-muted">Help text</small>
                            </div> -->
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="my-select">Select Company</label>
                                        <select id="my-select" class="form-control" name="company_id">
                                            @if(count($company) > 0)
                                                <option value=null>Company</option>
                                                @foreach($company as $companies)
                                                <option value={{$companies->id}}>{{$companies->company_name}}</option>
                                                @endforeach
                                            @else
                                                <option value=null>No Companies Found</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control" placeholder="Email" name="image" imageOnly>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="my-select">Select Location</label>
                                        <select id="my-select" class="form-control" name="location">
                                            @if(count($locations) > 0)
                                                @foreach($locations as $companies)
                                                    <option value={{$companies->id}}>{{$companies->name}}</option>
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
                                    <select id="my-select" class="form-control" name="category_id">
                                        @if(App\TenderCategory::all()->count() > 0)
                                            <option value="">Select Category</option>
                                            @foreach(App\TenderCategory::all() ->sortBy('name') as $categories)
                                            <option value={{$categories->id}} required>{{$categories->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Categories Found</option>
                                        @endif
                                    </select>
                                </div>
                                <br>
                                <div class="col-6">
                                    <label for="my-select">Select Tender Type</label>
                                    <select id="my-select" class="form-control" name="type">
                                        <option value="free" required>Free</option>
                                        <option value="premium" required>Premium</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Price</label>
                                        <input type="text" class="form-control" placeholder="Price" name="price">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Bond</label>
                                        <input type="text" class="form-control" placeholder="Bond" name="bond">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Reference</label>
                                        <select id="my-select" class="form-control" name="reference">
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
                                        <input type="date" class="form-control" placeholder="Bond" name="reference_date">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" placeholder="Title" name="title">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Title (Amharic)</label>
                                        <input type="text" class="form-control" placeholder="Title" name="title_am">
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
</main>
@endsection
@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
                            <li class="breadcrumb-item"><a href="{{route('company.index')}}">Company</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Company</li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Analytics</li> --}}
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#defaultModalPrimary">
                    Add New Company Owner
                </button>
                @if(Session::has('alert'))
                    <div class="row">
                        <br>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>Great! </strong>{{ Session::get('alert') }}
                        </div>
                        @else
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{-- <strong>User not registerd</strong> --}}
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                @enderror
                                @error('email')
                                <input type="hidden" class="form-control @error('email') is-invalid @enderror"
                                       placeholder="email" name="email" autocomplete="email">
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                @enderror
                                @error('company_email')
                                <input type="hidden" class="form-control  @error('company_email') is-invalid @enderror"
                                       name="company_email" placeholder="company_email" autocomplete="company_email">
                                <span class="invalid-feedback" role="alert">
                                                <strong>The Company Email has been taken</strong>
                                            </span>
                                @enderror
                                @error('password')
                                <input type="hidden" class="form-control @error('password') is-invalid @enderror"
                                       name="password" placeholder="********"  autocomplete="new-password">
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        @endif
                        <br/>
                    </div>

                    <br><br>
                    <h1 class="h3 mb-3">Add New Company</h1>


                    <div class="row">
                        <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{ route('company.store') }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input hidden name="user_id" value="{{auth()->user()->id}}">

                                        <hr>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Company Logo</label>
                                                    <input type="file" class="form-control" placeholder="Email"
                                                           name="company_logo_path" imageOnly>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="my-select">Add Company Owner</label>
                                                    <select id="my-select" class="form-control" name="subscriber_id">
                                                        <option value=''>Select Company Owner</option>
                                                        @foreach(App\Subscriber::all()->sortBy('name') as $subscribers)
                                                            <option
                                                                value="{{$subscribers->id}}">{{$subscribers->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="my-select">Company Category</label>
                                                    <select id="my-select" class="form-control" name="category_id"
                                                            >

                                                        @foreach($post as $posts)
                                                            @if($posts->id == 1)
                                                                <option value=null>Select Category</option>
                                                            @else
                                                                <option
                                                                    value="{{ $posts->id }}">{{ $posts->name }}</option>
                                                            @endif
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
                                                        @foreach($location as $locations)
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
                                                        <option value="">Select Category</option>
                                                        @foreach($company_category as $company_categories)
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
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Company Name</label>
                                                    <input type="text" class="form-control" placeholder="Name"
                                                           name="company_name" >
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
                                                    <label class="form-label">ስም</label>
                                                    <input type="text" class="form-control" placeholder="Name"
                                                           name="company_name_am" >
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label class="form-label">Email address</label>
                                                    <input type="email" class="form-control" placeholder="Email" name="email" >
                                                </div> --}}
                                            </div>
                                        </div>
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
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" placeholder="Email"
                                                           name="company_email" >
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Website </label>
                                                    <input type="text" class="form-control" placeholder="Website"
                                                           name="website">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Phone 1</label>
                                                    <input type="text" class="form-control" placeholder="Phone 1"
                                                           name="phone_number" >
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Phone 2</label>
                                                    <input type="text" class="form-control" placeholder="Phone 2"
                                                           name="phone_number_2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Tin Number </label>
                                                    <input type="text" class="form-control" placeholder="Tin Number"
                                                           name="tin_number">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Fax</label>
                                                    <input type="text" class="form-control" placeholder="Fax"
                                                           name="fax">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <label>Social Media Links</label>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Facebook </label>
                                                    <input type="text" class="form-control"
                                                           placeholder="www.facebook.com/...." name="facebbok">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Twitter</label>
                                                    <input type="text" class="form-control"
                                                           placeholder="www.twitter.com/..." name="twitter">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Telegram</label>
                                                    <input type="text" class="form-control" placeholder="telegram"
                                                           name="telegram">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label">Location Image Path</label>
                                                    <input type="file" class="form-control"
                                                           placeholder="Location  Image Path" name="">
                                                </div>
                                            </div>
                                        </div>

                                        <hr style="color: blue">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control" id="summary-ckeditor"
                                                              placeholder="description" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label">ገለጻ</label>
                                                    <textarea class="form-control" id="summary-ckeditor1"
                                                              placeholder="Amharic Description"
                                                              name="description_am"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h4>Available Hours</h4>
                                            <div class="row" style="marigin-top: 5%">
                                                <hr>

                                                <div class="col-xl-2 col-lg-2 col-md-2">
                                                    <label class="form-label w-100">Days</label>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    <label>Opening Hour</label>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    <label>Closing Hour</label>
                                                </div>
                                                <br>
                                                <div class="col-xl-2 col-lg-2 col-md-2">
                                                    <label class="form-label w-100">Monday</label>
                                                    {{-- <input type="hidden" name="day" value="Monday"> --}}
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Opening Hour</label> --}}
                                                    <input class="form-control" type="time" value="08:00"
                                                           name="monday_open">
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Closing Hour</label> --}}
                                                    <input class="form-control" type="time" value="17:00"
                                                           name="monday_closed">
                                                    <br>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2">
                                                    <label class="form-label w-100">Tuesday</label>
                                                    {{-- <input type="hidden" name="day" value="Tuesday"> --}}
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Opening Hour</label> --}}
                                                    <input class="form-control" type="time" name="tuesday_open"
                                                           value="08:00">
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Closing Hour</label> --}}
                                                    <input class="form-control" type="time" name="tuesday_closed"
                                                           value="17:00">
                                                    <br>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2">
                                                    <label class="form-label w-100">Wednesday</label>
                                                    {{-- <input type="hidden" name="day" value="Wednesday"> --}}
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Opening Hour</label> --}}
                                                    <input class="form-control" type="time" name="wednesday_open"
                                                           value="08:00">
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Closing Hour</label> --}}
                                                    <input class="form-control" type="time" name="wednesday_closed"
                                                           value="17:00">
                                                    <br>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2">
                                                    <label class="form-label w-100">Thursday</label>
                                                    {{-- <input type="hidden" name="day" value="Thursday"> --}}
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Opening Hour</label> --}}
                                                    <input class="form-control" type="time" name="thursday_open"
                                                           value="08:00">
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Closing Hour</label> --}}
                                                    <input class="form-control" type="time" name="thursday_closed"
                                                           value="17:00">
                                                    <br>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2">
                                                    <label class="form-label w-100">Friday</label>

                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Opening Hour</label> --}}
                                                    <input class="form-control" type="time" name="friday_open"
                                                           value="08:00">
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Closing Hour</label> --}}
                                                    <input class="form-control" type="time" name="friday_closed"
                                                           value="17:00">
                                                    <br>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2">
                                                    <label class="form-label w-100">Saturday</label>
                                                    {{-- <input type="hidden" name="day" value="Saturday"> --}}
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Opening Hour</label> --}}
                                                    <input class="form-control" type="time" name="saturday_open"
                                                           value="08:00">
                                                    <br>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5">
                                                    {{-- <label>Closing Hour</label> --}}
                                                    <input class="form-control" type="time" name="saturday_closed"
                                                           value="17:00">
                                                    <br>
                                                </div>
                                            </div>
                                            <br>
                                            <hr>
                                            <div class="row  col-xl-12 col-lg-12 col-md-12">
                                                <div class="form-group  col-xl-12 col-lg-12 col-md-12">
                                                    <table class="table" style="width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Services</th>
                                                            <th><a href="javascritp:;" class="btn btn-info addRow">Add
                                                                    + </a></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>

                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group col-lg-8 col-md-8">
                                                <label for="my-input">Images</label>
                                                <input id="image" class="form-control-file" type="file" name="image[]"
                                                       multiple>
                                                <input id="user_id" class="form-control-file" type="hidden"
                                                       name="user_id[]" value="{{auth()->user()->id}}">
                                                <input type="hidden" name="company_id[]" id="company_id"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group col-lg-12 col-md-12">
                                                <h4>Add Map</h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">City</label>
                                                            <input type="text" class="form-control" placeholder="City"
                                                                   name="city">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Latitude</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Latitude" name="lat">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Longitude</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Longitude" name="lng">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Iframe</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Iframe" name="iframe">
                                                        </div>
                                                    </div>
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
        </div>
    </main>


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

                        <form method="POST" action="{{ route('subscriber.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-xl-12">
                                    {{-- <label>Role</label> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-12">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="name">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           placeholder="email" name="email" autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-12">
                                    <label>Company Email</label>
                                    <input type="email"
                                           class="form-control @error('company_email') is-invalid @enderror"
                                           name="company_email" placeholder="company_email"
                                           autocomplete="company_email">
                                    @error('company_email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>The Company Email has been taken</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-12">
                                    <label>Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password" placeholder="********"  autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-12">
                                    <label>Password Confirmation</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                           placeholder="********" name="password_confirmation"
                                           autocomplete="new-password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@section('scripts')
    <script>
        const image = document.querySelector('input[id="image"]');

        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageResize,
            FilePondPluginImageEdit,
            FilePondPluginImageExifOrientation,
            FilePondPluginImageCrop,
            FilePondPluginImageTransform,
        );
        const pond1 = FilePond.create(
            document.querySelector('input[id="image"]'),
            {
                imagePreviewHeight: 200,
                imageResizeTargetWidth: 800,
                imageResizeTargetHeight: 500,
            }
        );

        FilePond.setOptions({
            server: {
                url: '/upload/images',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    </script>


    <script>
        $('thead').on('click', '.addRow', function () {
            var tr = '<tr>' +
                '<td><input type="text" name="name[ ]" id="name" class="form-control"></td>' +
                '<input type="file" name="image[]" id="image" class="form-control">' +
                '<td><input type="hidden" name="user_id[]" id="user_id" class="form-control"></td>' +
                '<td><input type="hidden" name="company_id[]" id="company_id" class="form-control"></td>' +
                '<td><a href="javascritp:;" class="btn btn-danger deleteRow" >Delete - </a></td>' +
                '</tr>';
            $('tbody').append(tr);

        });
        $('tbody').on('click', '.deleteRow', function () {
            $(this).parent().parent().remove();
        })

    </script>
@endsection
@endsection

@extends('layouts.admin')
@section('content')


	<main class="content">
        <div class="container-fluid p-0">
            <div class="row">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#defaultModalPrimary">
                Add Company Owner
             </button>
             @if(Session::has('alert'))
             <div class="row">
                 <br>
             <div class="alert alert-success alert-dismissible" role="alert">
                                                     <strong>Great!  </strong>{{ Session::get('alert') }}
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
                                                <input type="hidden" class="form-control @error('email') is-invalid @enderror"  placeholder="email"  name="email" autocomplete="email">                                
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            @error('company_email')
                                            <input type="hidden" class="form-control  @error('company_email') is-invalid @enderror" name="company_email" placeholder="company_email" autocomplete="company_email">
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The Company Email has been taken</strong>
                                            </span>
                                        @enderror
                                        @error('password')
                                        <input type="hidden" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="********" required autocomplete="new-password">
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                                </div>
                                           
             @endif
             <br/>
            </div>

            <br><br>
            <h1 class="h3 mb-3">Add New  Company</h1>
         

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input hidden value="" name="user_id">
                                <hr>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="company_logo_path" imageOnly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Company Category</label>
                                            <select id="my-select" class="form-control" name="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach($post as $posts)
                                                <option value="{{ $posts->id }}">{{ $posts->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Loation</label>
                                            <select id="my-select" class="form-control" name="location_id" required>
                                                <option value="">Select Location</option>
                                                @foreach($location as $locations)
                                                <option value="{{ $locations->id }}">{{ $locations->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" class="form-control" placeholder="Name" name="company_name" required>
                                            {{-- <select id="my-select" class="form-control" name="company_name" required>
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
                                            <input type="email" class="form-control" placeholder="Email" name="company_email" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Website </label>
                                            <input type="text" class="form-control" placeholder="Website" name="website">
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
                                            <label class="form-label">Tin Number </label>
                                            <input type="text" class="form-control" placeholder="Tin Number" name="tin_number">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Fax</label>
                                            <input type="text" class="form-control" placeholder="Fax" name="fax">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                        <label>Social Media Links</label>
                                <div class="row">
                                                                <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Facebook </label>
                                            <input type="text" class="form-control" placeholder="www.facebook.com/...." name="facebbok">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Twitter</label>
                                            <input type="text" class="form-control" placeholder="www.twitter.com/..." name="twitter">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Telegram</label>
                                            <input type="text" class="form-control" placeholder="telegram" name="telegram">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Location  Image Path</label>
                                            <input type="file" class="form-control" placeholder="Location  Image Path" name="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Category</label>
                                            <select id="my-select" class="form-control" name="company_category" required>
                                                <option value="">Select Category</option>
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
                                                <option value="">Select Category</option>
                                                <option value=NULL>Not Verified</option>  
                                                <option value="1">Verified</option>                                            
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr style="color: blue">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                     <textarea class="form-control" id="summary-ckeditor"  placeholder="description" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">ገለጻ</label>
                                     <textarea class="form-control" id="summary-ckeditor1"  placeholder="Amharic Description" name="description_am"></textarea>
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
                                           <input type="hidden" name="day" value="Monday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="monday_open">
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="monday_closed">
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Tuesday</label>
                                           <input type="hidden" name="day" value="Tuesday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="tuesday_open">
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="tuesday_closed">
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Wednesday</label>
                                           <input type="hidden" name="day" value="Wednesday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="wednesday_open">
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="wednesday_closed">
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Thursday</label>
                                           <input type="hidden" name="day" value="Thursday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="thursday_open">
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="thursday_closed">
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Friday</label>
                                           <input type="hidden" name="day" value="Friday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="friday_open">
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="friday_closed">
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Saturday</label>
                                           <input type="hidden" name="day" value="Saturday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="saturday_open">
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="saturday_closed">
                                           <br>
                                        </div>
                                    </div>
                                    <br>
                                <hr>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
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
                                <input type="email" class="form-control @error('email') is-invalid @enderror"  placeholder="email"  name="email" autocomplete="email">                                
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
                                <input type="email" class="form-control @error('company_email') is-invalid @enderror" name="company_email" placeholder="company_email" autocomplete="company_email">
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
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="********" required autocomplete="new-password">
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
                                <input id="password-confirm" type="password" class="form-control" placeholder="********" name="password_confirmation" required autocomplete="new-password">    
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                    </div>
    </div>
</div>
</div>
</div>



    @endsection
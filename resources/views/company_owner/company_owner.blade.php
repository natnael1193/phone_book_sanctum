
@extends('layouts.subscriber')
@section('content')
<div class="container">
<p>{{ auth()->user('subscriber')->id }}</p>
@if($subscriber == NULL)
<h1>User Dashboard</h1>
<br>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#defaultModalPrimary">
    Add Your Company
 </button>

 @else
 {{-- @if(App\Company::where('email',auth()->user('subscriber')->email, '=', Request::get('email'))->exists()) --}}
 <h1>Company Owner Dashboard</h1>
<br>
 @if(App\Company::where('company_category', 2)->first())
 
 {{-- @else --}}
 <div class="container-fluid p-0">
 
     <h1 class="h3 mb-3">Profile</h1>
     {{-- {{ $post->email }}
     {{ $id->email}} --}}
     <div class="row">
         <div class="col-md-4 col-xl-3">
             <div class="card mb-3">
                 <div class="card-header">
                     <h5 class="card-title mb-0">Profile Details</h5>
                 </div>
                 <div class="card-body text-center">
                     <p>{{ $post->id }}</p>
                     {{-- <img src="img/avatars/avatar-4.jpg" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128" height="128" /> --}}
                     <h3>{{ $post->company_name }}</h3>

                     <div class="text-muted mb-2">Lead Developer</div>
 
                     {{-- <div>
                         <a class="btn btn-primary btn-sm" href="#">Follow</a>
                         <a class="btn btn-primary btn-sm" href="#"><span data-feather="message-square"></span> Message</a>
                     </div> --}}
                 </div>
                 <hr class="my-0" />
                 <div class="card-body">
                     <h5 class="h6 card-title">About</h5>
                     <ul class="list-unstyled mb-0">
                         {{-- <li class="mb-1"><span data-feather="home" class="feather-sm mr-1"></span> Address San Francisco, SA</li>
 
                         <li class="mb-1"><span data-feather="briefcase" class="feather-sm mr-1"></span> Works at GitHub</li> --}}
                         <li class="mb-1"><span data-feather="map-pin" class="feather-sm mr-1"></span> Location: {{ $post->location_path_image }}</li>
                         <li class="mb-1"><span class="fas fa-globe fa-fw mr-1"></span> {{ $post->website }}</li>
                         <li class="mb-1"><i class="align-middle mr-2" data-feather="mail"></i> <span class="align-middle"></span> {{ $post->email }}</li>
                         <li class="mb-1"><span class="fas fa-phone fa-fw mr-1"></span> {{ $post->phone_number }}</li>
                         <li class="mb-1"><span class="fas fa-phone fa-fw mr-1"></span>{{ $post->phone_number_2 }}</li>
 
                     </ul>
                 </div>
                 {{-- <hr class="my-0" />
                 <div class="card-body">
                     <h5 class="h6 card-title">Elsewhere</h5>
                     <ul class="list-unstyled mb-0">
                         <li class="mb-1"><span class="fas fa-globe fa-fw mr-1"></span> <a href="#">{{ $post->wedsite }}</a></li>
                     </ul>
                 </div> --}}
             </div>
         </div>
 
         <div class="col-md-8 col-xl-9">
             <div class="card">
                 <div class="card-body h-100">
                     <h3>Description</h3>             
                     <div class="media">
                         {{-- <img src="img/avatars/avatar-5.jpg" width="36" height="36" class="rounded-circle mr-2" alt="Vanessa Tucker"> --}}
                         <div class="media-body">
                             {{-- <small class="float-right text-navy">5m ago</small> --}}
                          <p>{!! Illuminate\Support\Str::of($post->description)->words(10) !!}</p><br />
                             <small class="text-muted">Today 7:51 pm</small><br />
 
                         </div>
                     </div>
 
                     <hr />
                     <h3>Services</h3>                     
                     <div class="media">
                         {{-- <img src="img/avatars/avatar-5.jpg" width="36" height="36" class="rounded-circle mr-2" alt="Vanessa Tucker"> --}}
                         <div class="media-body">
                             {{-- <small class="float-right text-navy">5m ago</small> --}}
                             <p>{{ $post->service }}</p><br />
                 
                             <small class="text-muted">Today 7:51 pm</small><br />
 
                         </div>
                     </div>
 
              
 
                     <hr />
                     <a href="subscriber/edit" class="btn btn-primary btn-block">Edit</a>
                 </div>
             </div>
          
         </div>
         @else
 <div class="col-md-8 col-xl-7">
     <div class="card">
         <div class="card-body h-100">
             {{-- <h3> </h3>         --}}
             <div class="alert alert-primary alert-dismissible" role="alert">
             <div class="alert-message">
                 <p>{{ $post->company_name }}</p>
                                                 <strong>Hello there! </strong>Please subscribe to premium package
                                             </div>     
             </div>
             <hr />
             <h3>Contact  us</h3>                     
             <div class="media">
                 {{-- <img src="img/avatars/avatar-5.jpg" width="36" height="36" class="rounded-circle mr-2" alt="Vanessa Tucker"> --}}
                 <div class="media-body">
                     {{-- <small class="float-right text-navy">5m ago</small> --}}
                     <p>Phone: </p>
                     <p>Email: </p>
                 </div>
             </div>
             <hr />
             {{-- <a href="subscriber/edit" class="btn btn-primary btn-block">Edit</a> --}}
         </div>
     </div>
  
 </div>
     </div>
   
 
 {{-- @endif --}}
 @endif
 {{-- @else
 <div class="col-md-8 col-xl-7">
     <div class="card">
         <div class="card-body h-100">
             <h3> </h3>        
             <div class="alert alert-danger alert-dismissible" role="alert">
             <div class="alert-message">
                 <p></p>
                                                 <strong>Hello there! </strong>No Company is found on this company email
                                             </div>     
             </div>
             <hr />
             <h3>Contact  us</h3>                     
             <div class="media">
                 <img src="img/avatars/avatar-5.jpg" width="36" height="36" class="rounded-circle mr-2" alt="Vanessa Tucker">
                 <div class="media-body">
                     <small class="float-right text-navy">5m ago</small>
                     <p>Phone: </p>
                     <p>Email: </p>
                 </div>
             </div>
             <hr />
             <a href="{{ route('subscriber.new_company') }}"><p style="text-align: center">Register your company </p></a>
             <a href="subscriber/edit" class="btn btn-primary btn-block">Edit</a>
         </div>
     </div>
  
 </div>
 @endif --}}

@endif











 <div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Your Company</h5>
                <p>{{ auth()->user('subscriber')->id }}</p>
                <br>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
            </div>
            <div class="modal-body m-3">
                
        <form method="POST" action="{{ route('company.register') }}">
                    @csrf
                    <input type="hidden" name="subscriber_id" value="{{ auth()->user('subscriber')->id }}">
                <div class="row">
        
                </div>
                <div class="row">
                    <div class="form-group col-xl-12">
                        <label>Company Name</label>
                        <input type="text" class="form-control" name="company_name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xl-12">
                        <label>Company Email</label>
                        <input type="email" class="form-control" name="company_email" required>
                    </div>
                </div>
  
                <div class="row">
                    <div class="form-group col-xl-12">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
            </div>
</div>
</div>
</div>
</div>
</div>
@endsection
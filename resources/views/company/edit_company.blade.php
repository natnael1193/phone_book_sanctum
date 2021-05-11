@extends('layouts.admin')
@section('content')
	<main class="content">
        <div class="container-fluid p-0">

            <h1 class="h3 mb-3">Edit  Company</h1>

            <div class="row">
                <div class="col-12 col-xl-10 col-lg-10 col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-10">
                                    <h1 style="">{{ $post->company_name }}</h1>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2">
                                    @if($post->verification == 1)
                                    <div class="alert alert-primary alert-outline-coloured alert-dismissible col-xl-3 col-lg-3 col-md-" >
                                        {{-- <div class="alert-icon"> --}}
                                            <i class="align-middle" data-feather="check-square" style="color: blue"></i> 
                                        </div>
                                    {{-- </div> --}}
                                    @else
                                    @endif
                                </div>
                            </div>                          
                        </div>
                        
                        <div class="card-body">
                            <form method="POST" action="{{ route('company.update', $post->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="user_id">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Openig Hour</label>
                                            <input type="time" class="form-control" placeholder="" name="opening_hour" value="{{ $post->opening_hour }}" >
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Closing Hour</label>
                                            <input type="time" class="form-control" placeholder="" name="closing_hour" value="{{ $post->closing_hour }}"  >
                                        </div>
                                     </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Email" name="company_logo_path" value="{{ $post->company_logo_path }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Category</label>
                                            <select id="my-select" class="form-control" name="categroy_id" value="{{ $post->categroy_id }}">
                                                <option>Select Category</option>
                                                @foreach($category as $categories)
                                                <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" name="company_name" value="{{ $post->company_name }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">ስም</label>
                                            <input type="text" class="form-control" placeholder="Amharic Name" name="company_name_am" value="{{ $post->name_am }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Email address</label>
                                            <input type="email" class="form-control" placeholder="Email" name="company_email" value="{{ $post->company_email }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Website </label>
                                            <input type="text" class="form-control" placeholder="Website" name="website" value="{{ $post->website }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                        <label class="form-label">Phone 1</label>
                                        <input type="text" class="form-control" placeholder="Phone 1" name="phone_number" value="{{ $post->phone_number }}">
                                    </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                    <label class="form-label">Phone 2</label>
                                    <input type="text" class="form-control" placeholder="Phone 2" name="phone_number_2" value="{{ $post->phone_number_2 }}">
                                </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Tin Number </label>
                                            <input type="text" class="form-control" placeholder="Website" name="tin_number" value="{{ $post->tin_number }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Fax</label>
                                            <input type="text" class="form-control" placeholder="Fax" name="fax" value="{{ $post->fax }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <label>Social Media Links</label>
                        <div class="row">
                                                        <div class="col-xl-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Facebook </label>
                                    <input type="text" class="form-control" placeholder="www.facebook.com/...." name="facebook" value={{ $post->facebook }}>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" class="form-control" placeholder="www.twitter.com/..." name="twitter" value="{{ $post->twitter }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Telegram</label>
                                    <input type="text" class="form-control" placeholder="telegram" name="telegram" value="{{ $post->telegram }}">
                                </div>
                            </div>
                        </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Location  Image Path</label>
                                            <input type="file" class="form-control" placeholder="Location  Image Path" name="location_image_path" value="{{ $post->loaction_value_path }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Company  Image </label>
                                            <input type="file" class="form-control" placeholder="Location  Image Path" name="imgae" value="{{ $post->image }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Company Category</label>
                                            <select id="my-select" class="form-control" name="company_category" >
                                                <option value="{{ $post->company_category }}">Select Category</option>
                                                @foreach($company_category as $company_categories)
                                                <option value="{{ $company_categories->id }}">{{ $company_categories->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Company Verfication</label>
                                            <select id="my-select" class="form-control" name="verification" value="{{ $post->verfication }}">
                                                <option value="{{ $post->verification }}">{{ $post->verification }}</option>
                                                <option value="">Not Verified</option>
                                                <option value="1">Verified</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            {{-- <div class="row">
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox m-0">
      <input type="checkbox" class="custom-control-input" @if($post->company_category != 1 )value="1"@else value="2"@endif>
      <span class="custom-control-label">Check me out</span>
    </label>
                                </div>
                            </div> --}}
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                     <textarea name="description" id="summary-ckeditor"  class="form-control" placeholder="description" >{{ $post->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">ገለጻ</label>
                                     <textarea name="description_am" id="summary-ckeditor1"  class="form-control" placeholder="Amharic Description" >{{ $post->description_am }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Services</label>
                                     <textarea name="service" id="summary-ckeditor2"  class="form-control" placeholder="service" >{{ $post->service }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">አገልግሎት</label>
                                     <textarea name="service_am" id="summary-ckeditor3"  class="form-control" placeholder="service" >{{ $post->service_am }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endsection
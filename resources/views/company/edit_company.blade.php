
@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto ml-auto text-right mt-n1">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                            <li class="breadcrumb-item"><a href="{{route('company.index')}}">Company</a></li>
                            {{-- <li class="breadcrumb-item"><a href="{{route('company.create')}}">Add Company</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Edit Company</li>
                        </ol>
                    </nav>
                </div>
            </div>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-xm-12">
        <h1 class="h3 mb-3">Edit  Company</h1>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-xm-12">
        <div class="row" style="display: flex; justify-content: center; align-items: center">
   {{-- <a href=""><button type="submit" class="btn btn-info">Edit Services</button></a> --}}
        </div>
    </div>
</div>


            <div class="row">
                <div class="col-12 col-xl-12 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-10">
                                    <h1 style="">{{ $post->company_name }} ({{ $post->id }})</h1>
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
                            <form method="POST" action="{{ route('company.update', $post->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="user_id">
                                <hr>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" placeholder="Image" name="company_logo_path" value="{{ $post->company_logo_path }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Add Company Owner</label>
                                            <select id="my-select" class="form-control" name="subscriber_id">
                                                <option value="{{$post->subscriber_id}}">Select Company Owner</option>
                                                @foreach(App\Subscriber::all()->sortBy('name') as $subscribers)
                                                <option value="{{$subscribers->id}}">{{$subscribers->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Category</label>
                                            <select id="my-select" class="form-control" name="categroy_id" value="{{ $post->categroy_id }}">
                                                <option value="{{ $post->categroy_id }}">Select Category</option>
                                                @foreach($category as $categories)
                                                <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="my-select">Location</label>
                                            <select id="my-select" class="form-control" name="location_id" value="{{ $post->location_id }}">
                                                <option value="{{ $post->location_id }}">Select Location</option>
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
                                            <input type="text" class="form-control" placeholder="Name" name="company_name" value="{{ $post->company_name }}">
                                                {{-- <select id="my-select" class="form-control" name="company_name" value="{{$post->id}}">
                                                    <option value="{{$post->id}}">{{$post->company_name}}</option>
                                                    @foreach($all as $items)
                                                    <option value="{{$items->id}}">{{$items->company_name}}</option>
                                                    @endforeach
                                                </select> --}}
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
                                                <option value="{{ $post->verification }}">Select Category</option>
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
                                           <input type="hidden"  value="Monday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                        <input class="form-control" type="time" name="monday_open" @if($available_hour != NULL) value="{{$available_hour->monday_open}}" @else value="" @endif>
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="monday_closed" @if($available_hour != NULL) value="{{$available_hour->monday_closed}}" @else value="" @endif >
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Tuesday</label>
                                           <input type="hidden"  value="Tuesday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="tuesday_open" @if($available_hour != NULL)value="{{$available_hour->tuesday_open}}" @else value="" @endif>
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="tuesday_closed" @if($available_hour != NULL)value="{{$available_hour->tuesday_closed}}" @else value="" @endif>
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Wednesday</label>
                                           <input type="hidden"  value="Wednesday" >
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="wednesday_open" @if($available_hour != NULL)value="{{$available_hour->wednesday_open}}" @else value="" @endif>
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="wednesday_closed" @if($available_hour != NULL)value="{{$available_hour->wednesday_closed}}" @else value="" @endif>
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Thursday</label>
                                           <input type="hidden"  value="Thursday" >
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="thursday_open" @if($available_hour != NULL)value="{{$available_hour->thursday_open}}" @else value="" @endif>
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="thursday_closed" @if($available_hour != NULL)value="{{$available_hour->thursday_closed}}" @else value="" @endif>
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Friday</label>
                                           <input type="hidden"  value="Friday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="friday_open" @if($available_hour != NULL)value="{{$available_hour->friday_open}}" @else value="" @endif>
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="friday_closed" @if($available_hour != NULL)value="{{$available_hour->friday_closed}}" @else value="" @endif>
                                           <br>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <label class="form-label w-100">Saturday</label>
                                           <input type="hidden"  value="Saturday">
                                           <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Opening Hour</label> --}}
                                          <input class="form-control" type="time" name="saturday_open" @if($available_hour != NULL)value="{{$available_hour->saturday_open}}" @else value="" @endif>
                                          <br>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5">
                                            {{-- <label>Closing Hour</label> --}}
                                           <input class="form-control" type="time" name="saturday_closed" @if($available_hour != NULL)value="{{$available_hour->saturday_closed}}" @else value="" @endif>
                                           <br>
                                        </div>
                                    </div>
                                    <div class="row  col-xl-12 col-lg-12 col-md-12">
                                        <div class="form-group  col-xl-12 col-lg-12 col-md-12">
                                            <table class="table" style="width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>Services</th>
                                                    <th><a href="javascritp:;" class="btn btn-info addRow" >Add + </a></th>
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
                                        <input id="image" class="form-control-file" type="file" name="image[]" multiple>
                                        <input id="user_id" class="form-control-file" type="hidden" name="user_id[]" value="{{auth()->user()->id}}">
                                        <input type="hidden" name="company_id[]" id="company_id" class="form-control" >
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
             <div class="row" style="display: flex; justify-content: center; align-items: center">
                <h2>Services</h2>
                <table class="table table-light">
                    <thead class="thead-light">
                        <tr>
                            <th>Service Name</th>
                            <th></th>
                            <th></th>
                            <th colspan="">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service as $services)
                        <tr>
                        <td>{{$services->name}}</td>
                        <td></td>
                        <td></td>
                        <td><button class="btn btn-info" data-toggle="modal" data-target="#defaultModalPrimary{{$services->id}}">Edit</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </main>

    @foreach($service as $services)
<div class="card">
    <div class="modal fade" id="defaultModalPrimary{{$services->id}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
                </div>
                <div class="modal-body m-3">

            <form method="POST" action="{{route('service.update', $services->id)}}'">
                        @csrf
                        @method('PATCH')
                    <div class="row">
                        <div class="form-group col-xl-12">
                     <div class="form-group">
                         <label for="my-select">Service</label>
                         <input type="text" name="name" class="form-control" value="{{$services->name}}">
                     </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
                </div>
    </div>
    </div>
    </div>
    </div>
    @endforeach

    <div class="container-fluid">
        <br />
        {{--      <h3 align="center">Image Upload in Laravel using Dropzone</h3>--}}
        <br />

        <div class="panel panel-default">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Uploaded Image</h3>
                    <hr>
                </div>
                <br />

                <div class="panel-body" id="">
                    <div class="row">
                        @foreach ($images as $image)
                            <div class="col-md-2" style="margin-bottom:16px;" align="center">
                                <img src="/storage/{{$image->image}}" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                                <form action="{{route('dropzone.delete', $image->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link" >Remove</button>
                                </form>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


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
    $('thead').on('click', '.addRow', function(){
        var tr = '<tr>' +
            '<td><input type="text" name="name[ ]" id="name" class="form-control"></td>'+
            '<input type="file" name="image[]" id="image" class="form-control">'+
            '<td><input type="hidden" name="user_id[]" id="user_id" class="form-control"></td>'+
            '<td><input type="hidden" name="company_id[]" id="company_id" class="form-control"></td>'+
            '<td><a href="javascritp:;" class="btn btn-danger deleteRow" >Delete - </a></td>'+
            '</tr>';
        $('tbody').append(tr);

    });
    $('tbody').on('click', '.deleteRow', function(){
        $(this).parent().parent().remove();
    })

    load_images();

    function load_images()
    {
        $.ajax({
            url:"{{ route('dropzone.fetch', $company->id) }}",
            success:function(data)
            {
                $('#uploaded_image').html(data);
            }
        })
    }



</script>


      @endsection





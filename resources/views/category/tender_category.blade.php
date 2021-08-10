@extends('layouts.admin')
@section('content')


    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet"/>
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
          rel="stylesheet">
    <link
        href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css"
        rel="stylesheet"/>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>

    <main class="content">
        <div class="container-fluid p-0">
            <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12" role="alert">
                @if(Session::has('message'))
                    <p class="alert alert-danger">{{ Session::get('message') }}</p>
                @endif
            </div>

            {{--            <h1 class="h3 mb-3">Student</h1>--}}

            <div class="row">
                <div class="col-12 col-lg-6">
                    <!-- BEGIN primary modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#defaultModalPrimary">
                        Add New Category
                    </button>
                    <div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('tender_category.store') }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body m-3">
                                        <div class="for-group">
                                            <label>Tender Category Image</label>
                                            <input type="file" name="image" class="form-control"
                                                   placeholder="category name">
                                        </div>
                                        <br>
                                        <div class="for-group">

                                            <label>Tender Category Name</label>
                                            <input type="text" name="name" class="form-control"
                                                   placeholder="category name">
                                        </div>
                                        <br>
                                        <div class="for-group">

                                            <label>Tender Category Name (Amharic)</label>
                                            <input type="text" name="name_am" class="form-control"
                                                   placeholder="category name">
                                        </div>
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>

        <div class="row">
            <br>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{$post->count()}} @if($post->count() == 0) No Category @elseif($post->count() == 1)
                                Category @else Categories @endif</h4>
                        {{--                    <h5 class="card-title">Always responsive</h5>--}}
                        {{--                    <h6 class="card-subtitle text-muted">Across every breakpoint, use <code>.table-responsive</code> for horizontally scrolling tables.</h6>--}}
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th scope="col">Tender Category Image</th>
                                <th scope="col">Tender Category Name</th>
                                <th scope="col">Tender Category Name (Amharic Name)</th>
                                <th scope="col" colspan="3">Actions</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($post as $posts)
                                <tr>
                                    <td><img src="/storage/{{$posts->image}}" style="width: 100px; height: 100px"/></td>
                                    <td>{{$posts->name}}</td>
                                    <td>{{$posts->name_am}}</td>
                                    <td>
                                        <div class="row">
                                            <button class="btn btn-primary mr-2" data-toggle="modal"
                                                    data-target="#defaultModalEdit{{ $posts->id }}">Edit
                                            </button>
                                            <form method="POST" action="">@csrf @method('DELETE')
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                        
                                    </td>
                                </tr>


                            @endforeach

                            @foreach($category as $categories)
                                <div class="modal fade" id="defaultModalEdit{{$categories->id}}" tabindex="-1"
                                     role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Tender Category</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body m-3">
                                                <form action="{{ route('tender_category.update', $categories->id)}}"
                                                      method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body m-3">
                                                        <div class="for-group">
                                                            <label>Tender Category Image</label>
                                                            <input type="file" name="image" class="form-control"
                                                                   value="{{$categories->image}}"
                                                                   placeholder="category Image">
                                                        </div>
                                                        <br>
                                                        <div class="for-group">

                                                            <label>Tender Category Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                   value="{{$categories->name}}"
                                                                   placeholder="category name">
                                                        </div>
                                                        <br>
                                                        <div class="for-group">

                                                            <label>Tender Category Name (Amharic)</label>
                                                            <input type="text" name="name_am" class="form-control"
                                                                   value="{{$categories->name_am}}"
                                                                   placeholder="category name">
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Save changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </main>

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
        const image = document.querySelector('input[id="update_image"]');

        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageResize,
            FilePondPluginImageEdit,
            FilePondPluginImageExifOrientation,
            FilePondPluginImageCrop,
            FilePondPluginImageTransform,
        );
        const pond1 = FilePond.create(
            document.querySelector('input[id="update_image"]'),
            {
                imagePreviewHeight: 200,
                imageResizeTargetWidth: 800,
                imageResizeTargetHeight: 500,
            }
        );

        FilePond.setOptions({
            server: {
                url: '/update/images',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    </script>




@endsection

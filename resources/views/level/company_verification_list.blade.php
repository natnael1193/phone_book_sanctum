@extends('layouts.admin')
@section('content')

    <main class="content">
        <div class="container-fluid p-0">
            <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12" role="alert">
                @if (Session::has('message'))
                    <p class="alert alert-danger">{{ Session::get('message') }}</p>
                @endif
            </div>

            {{-- <h1 class="h3 mb-3">Student</h1> --}}

            <div class="row">
                <div class="col-12 col-lg-6">
                    <!-- BEGIN primary modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#defaultModalPrimary">
                        Add New 
                    </button>
                    <div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('company_verification_list.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body m-3">
                                        <div class="for-group">
                                            <label>Verification List</label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Verification List">
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
                        <h4>{{ $post->count() }} @if ($post->count() == 0) No list
                            @elseif($post->count() == 1)
                            list @else lists @endif
                        </h4>
                        {{-- <h5 class="card-title">Always responsive</h5> --}}
                        {{-- <h6 class="card-subtitle text-muted">Across every breakpoint, use <code>.table-responsive</code> for horizontally scrolling tables.</h6> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Verification List Name</th>
                                    <th scope="col" colspan="3">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($post as $posts)
                                    <tr>
                                        <td>{{ $posts->name }}</td>
                                        <td>
                                            <div class="row">
                                                <button type="button" class="btn btn-primary mr-2" data-toggle="modal"
                                                    data-target="#defaultModalEdit{{ $posts->id }}">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{route('company_verification_list.delete', $posts->id)}}">@csrf @method('DELETE')
                                                    <button class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>


                                @endforeach
                                {{-- <div class="modal fade" id="defaultModalEdit" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Vacancy Category</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                </div> --}}

                                @foreach ($level as $levels)
                                    <div class="modal fade" id="defaultModalEdit{{ $levels->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Vacancy Category</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body m-3">
                                                    <form action="{{ route('company_verification_list.update', $levels->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body m-3">
                                                            <div class="for-group">
                                                                <label>Verification List</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    value="{{ $levels->name }}"
                                                                    placeholder="category name">
                                                            </div>
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

@endsection

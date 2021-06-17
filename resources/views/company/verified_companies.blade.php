@extends('layouts.admin')
@section('content')
    <p>{{$count->count()}} Companies</p>
    <div class="row col-xl-8 col-lg-8 col-md-8 col-sm-12" role="alert">
        @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif

    </div>
    <table class="table table-light">
        <thead class="thead-light">
        <tr>
            <th>Company Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th colspan="3">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($post as $posts)
            <tr>
                <td>{{ $posts->company_name }}</td>
                <td>{{ $posts->company_email }}</td>
                <td>{{ $posts->phone_number }}</td>
                <td><div class="btn-list d-flex ">

                        <a href="{{ route('company.edit', $posts->id) }}"><button class="btn btn-primary mr-2" >Edit</button></a>
                        <form method="POST" action="{{ route('company.destroy', $posts->id) }}">
                            @csrf
                            @method('DELETE')
                            <a href=""><button class="btn btn-danger " >Delete</button></a>
                        </form>
                    </div>
                <td>

            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>{{$post->links()}}</th>
        </tr>
        </tfoot>
    </table>

@endsection

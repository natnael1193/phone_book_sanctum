@extends('layouts.admin')
@section('content')


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
                {{-- <form method="POST" action="">
                    @csrf
                    @method('PATCH')
                @if($posts->verification == null || $posts->verification == 0)
                <input type="hidden" value="1" name="verification">
                <button class="btn btn-info mr-2 "  type="submit">Verify</button>
                @else
                <input type="hidden" value="null" name="verification">
                <button class="btn btn-warning mr-2"  type="submit">Cancel verification</button>
                @endif
                </form> --}}
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
            <th>#</th>
        </tr>
    </tfoot>
</table>

@endsection
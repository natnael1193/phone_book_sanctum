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
                <form method="POST" action="{{ route('company.verified', $posts->id) }}">
                    @csrf
                    {{-- @method('PATCH') --}}
                {{-- @if($posts->verification == NULL || $posts->verification == 0) --}}
                <input type="hidden" value="{{ $posts->company_category }}" name="company_category">
                <input type="hidden" value="{{ $posts->category_id }}" name="category_id">
                <input type="hidden" value="{{ $posts->subscriber_id }}" name="subscriber_id">
                <input type="hidden" value="{{ $posts->company_name }}" name="company_name">
                <input type="hidden" value="{{ $posts->company_name_am }}" name="company_name_am">
                <input type="hidden" value="{{ $posts->phone_number }}" name="phone_number">
                <input type="hidden" value="{{ $posts->phone_number_2 }}" name="phone_number_2">
                <input type="hidden" value="{{ $posts->company_email }}" name="company_email">
                <input type="hidden" value="{{ $posts->description }}" name="description">
                <input type="hidden" value="{{ $posts->description_am }}" name="description_am">
                <input type="hidden" value="{{ $posts->fax }}" name="fax">
                <input type="hidden" value="{{ $posts->website }}" name="website">
                <input type="hidden" value="{{ $posts->company_logo_path }}" name="company_logo_path">
                <input type="hidden" value="{{ $posts->location_image_id }}" name="location_image_id">
                <input type="hidden" value="{{ $posts->tin_number }}" name="tin_number">
                <input type="hidden" value="{{ $posts->facebook }}" name="facebook">
                <input type="hidden" value="{{ $posts->telegram }}" name="telegram">
                <input type="hidden" value="{{ $posts->twitter }}" name="twitter">
                <input type="hidden" name="user_id" >
                <input type="hidden" name="verification" >
                <button class="btn btn-info mr-2 "  type="submit">Verify</button>
                {{-- @endif --}}
                </form>
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
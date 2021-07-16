@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="card center">
        <form method="POST" action="{{ route('category.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
        <div class="row col-lg-8 col-md-8">
            <div class="form-group col-xl-12">
                <div class="form-group col-xl-12">
                    <label>Image</label>
                    <input type="file" class="form-control" name="image" value="{{$post->image}}">
                </div>
                <label for="my-select">Category</label>
                <select id="my-select" class="form-control"   name="category_id" >
                    <option value="{{ $post->category_id }}">Select Category</option>
                    @foreach($sub_category as $sub_categories)
                    <option value="{{ $sub_categories->id }}">{{ $sub_categories->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-xl-12">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{$post->name}}">
            </div>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>
</div>

@endsection

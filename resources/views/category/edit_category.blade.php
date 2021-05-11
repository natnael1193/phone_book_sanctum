@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row">
        <form method="POST" action="{{ route('category.update', $post->id) }}">
            @csrf
            @method('PATCH')
        <div class="row">
            <div class="form-group col-xl-12">
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
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>
</div>

@endsection
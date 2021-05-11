@extends('layouts.admin')
@section('content')

<div class="container">
<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6">
    <div class="card flex-fill w-100">
        <div class="card-header">
            <h4>Companies</h4>
            <p>{{ App\Company::where('verification', !null)->get()->count() }}</p>
        </div>
        </div>
</div>
<div class="col-xl-6 col-lg-6 col-md-6">
    <div class="card flex-fill w-100">
        <div class="card-header">
            <h4>Blogs</h4>
            <p>{{ App\Blog::query()->get()->count() }}</p>
        </div>
        </div>
</div>
</div>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h4>Not Verified Companies</h4>
                <p>{{ App\Company::where('verification', null)->get()->count() }}</p>
            </div>
            </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h4>Premium Companies</h4>
                <p>{{ App\Company::where('company_category', 2)->get()->count() }}</p>
            </div>
            </div>
    </div>
    </div>
</div>

@endsection
@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row">
<div class="card">
    <div class="card-header">

    </div>
    <div class="card-body">
        {{ $activity->changes }}
    </div>
</div>
    </div>
</div>

@endsection
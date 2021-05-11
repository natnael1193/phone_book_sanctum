{{-- @extends('layouts.admin')
@section('content') --}}
<div class="container">
    <div class="row">

    {{ $rating }}
      <br>
      Total Rating:  {{ $sum }}
      <br>
     Average Rating: {{ $value }}
    </div>

</div>

{{-- @endsection --}}
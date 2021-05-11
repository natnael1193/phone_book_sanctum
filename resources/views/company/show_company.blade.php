@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <p>post ->{{ $post}}|</p>
        @if($post == 0 )
        @else 
        <p>comp ->{{ $y}}|</p>
        <p>company ->{{ $company}}|</p>
        @endif
       
        <br/>
        {{-- <p>{{ App\Company::query()->where('company_category',$data)->count() }}</p> --}}
        <br>
        @foreach($data as $companies)
        <p>{{ $companies->company_name }}</p>
        <br>
         <h4> {{ $companies->company_category  }} </h4>
         <br>
        @endforeach
      
    </div>

</div>

@endsection
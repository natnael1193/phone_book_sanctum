@extends('layouts.admin')
@section('content')

    <div class="container">
        <div class="row">
            <div class="card col-xl-8 col-lg-8 col-md-8">
                <div class="card-header">
                    <h4>Caused By ---> {{ $activity->causer['name']}} ( {{ $activity->description}} )</h4>
                    <p>{{$activity->subject_type}}</p>

                </div>
                {{--    <div class="card-body">--}}
                {{--        {{ $activity->subject}}--}}
                {{--    </div>--}}
                <h4>New Data</h4>
                <hr>
                <div class="card-body">
                    <img src="storage/{{$activity->properties['attributes']['company_logo_path']}}">
                    <p>Company
                        Status: @if($activity->properties['attributes']['company_category'] != null) {{App\CompanyCategory::findOrfail( $activity->properties['attributes']['company_category'])->name}} @else @endif </p>
                    <p>Company
                        Category: @if($activity->properties['attributes']['category_id'] != null) {{App\Category::findOrfail( $activity->properties['attributes']['category_id'])->name}} @else @endif</p>
                    <p>Company Name: {{ $activity->properties['attributes']['company_name']}}</p>
                    <p>Company Name Amharic: {{ $activity->properties['attributes']['company_name_am']}}</p>
                    <p>Company Email: {{ $activity->properties['attributes']['company_email']}}</p>
                    <p>Phone Number: {{ $activity->properties['attributes']['phone_number']}}</p>
                    <p>Phone Number 2: {{ $activity->properties['attributes']['phone_number_2']}}</p>
                    <p>Fax: {{ $activity->properties['attributes']['fax']}}</p>
                    <p>Tin Number: {{ $activity->properties['attributes']['tin_number']}}</p>
                    <p>Website: {{ $activity->properties['attributes']['website']}}</p>
                    <p>Telegram: {{ $activity->properties['attributes']['telegram']}}</p>
                    <p>Facebook: {{ $activity->properties['attributes']['facebook']}}</p>
                    <p>Verification: {{ $activity->properties['attributes']['verification']}}</p>
                    <p>
                        Location: @if($activity->properties['attributes']['location_id'] != null) {{App\Location::findOrfail( $activity->properties['attributes']['location_id'])->name}} @else @endif</p>
                    <p>Verification: @if($activity->properties['attributes']['verification'] == null) Not Verified @else
                            Verified @endif</p>
                    <p>Call To Company: @if($activity->properties['attributes']['called'] == null) Never
                        Called @elseif($activity->properties['attributes']['called'] == 1) No Answer @else Did't
                        Send Information   @endif</p>

                    <p>Description: {{ $activity->properties['attributes']['description']}}</p>
                    <p>Description Amharic: {{ $activity->properties['attributes']['description_am']}}</p>

                </div>
                <hr>
            </div>
            @if(!empty($activity->properties['old']))
            <div class="card col-xl-8 col-lg-8 col-md-8">
                <div class="card-header">
                    <h4>Caused By
                        ---> @if($activity->properties['old']['user_id'] != null) {{App\User::findOrfail( $activity->properties['old']['user_id'])->name}} @else @endif </h4>
                    <p>{{$activity->subject_type}}</p>
                </div>
                <br>
                <h4>Old Data</h4>
                <hr>
                <div class="card-body">
                    <img src="storage/{{$activity->properties['old']['company_logo_path']}}">
                    <p>Company
                        Status: @if($activity->properties['old']['company_category'] != null) {{App\CompanyCategory::findOrfail( $activity->properties['old']['company_category'])->name}} @else @endif </p>
                    <p>Company
                        Category: @if($activity->properties['old']['category_id'] != null) {{App\Category::findOrfail( $activity->properties['old']['category_id'])->name}} @else @endif</p>
                    <p>Company Name: {{ $activity->properties['old']['company_name']}}</p>
                    <p>Company Name Amharic: {{ $activity->properties['old']['company_name_am']}}</p>
                    <p>Company Email: {{ $activity->properties['old']['company_email']}}</p>
                    <p>Phone Number: {{ $activity->properties['old']['phone_number']}}</p>
                    <p>Phone Number 2: {{ $activity->properties['old']['phone_number_2']}}</p>
                    <p>Fax: {{ $activity->properties['old']['fax']}}</p>
                    <p>Tin Number: {{ $activity->properties['old']['tin_number']}}</p>
                    <p>Website: {{ $activity->properties['old']['website']}}</p>
                    <p>Telegram: {{ $activity->properties['old']['telegram']}}</p>
                    <p>Facebook: {{ $activity->properties['old']['facebook']}}</p>
                    <p>Verification: {{ $activity->properties['old']['verification']}}</p>
                    <p>
                        Location: @if($activity->properties['old']['location_id'] != null) {{App\Location::findOrfail( $activity->properties['old']['location_id'])->name}} @else @endif</p>
                    <p>Verification: @if($activity->properties['old']['verification'] == null) Not Verified @else
                            Verified @endif</p>
                    <p>Call To Company: @if($activity->properties['old']['called'] == null) Never
                        Called @elseif($activity->properties['old']['called'] == 1) No Answer @else Did't
                        Send Information   @endif</p>

                    <p>Description: {{ $activity->properties['old']['description']}}</p>
                    <p>Description Amharic: {{ $activity->properties['old']['description_am']}}</p>

                </div>
            </div>
                @endif
        </div>
    </div>

@endsection

@extends('layouts.admin')
@section('content')

{{-- <main class="content"> --}}
<div class="container-fluid p-0">

    <h1 class="h3 mb-3">Tables</h1>

    <div class="row">
        <div class="col-12 col-xl-10">
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:20%;">Company Name</th>
                            <th style="width:20%;">Transaction No</th>
                            <th style="width:20%;">Deposited By</th>
                            <th style="width:20%;">Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                        <tr>
                            <td style="color: black">{{ $company->company->company_name }}</td>
                            <td style="color: black">{{ $company->txn_no }}</td>
                            <td style="color: black">{{ $company->deposited_by }}</td>
                            <td style="color: black">{{ $company->date }}</td>
                            <td class="d-flex"><button type="button" class="btn @if($company->company->company_category == 1)btn-success @elseif($company->company->company_category == 2) btn-danger @else btn-primary @endif" data-toggle="modal" data-target="#defaultModalEdit{{$company->id}}">
                                    Change status
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- </main> --}}


@foreach($category as $categories)
<div class="card">
    <div class="modal fade" id="defaultModalEdit{{$categories->id}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <h4>{{$categories->company->company_name}}</h4>
                    <p>{!! $categories->company->description !!}</p>
                    <form method="POST" action="{{ route('premium.update', $categories->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label for="my-select">Add Company Owner</label>
                                <select id="my-select" class="form-control" name="company_category">
                                    @if($categories->company->company_category == 1)
                                    <option value='{{$categories->company->company_category}}'>Premium</option>
                                    <option value='2'>Expired</option>
                                    <option value='null'>Basic</option>
                                    @elseif($categories->company->company_category == 2)
                                    <option value='2'>Expired</option>
                                    <option value='null'>Basic</option>
                                    <option value='1'>Premium</option>
                                    @else
                                    <option value='null'>Basic</option>
                                    <option value='1'>Premium</option>
                                    <option value='2'>Expired</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Change</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
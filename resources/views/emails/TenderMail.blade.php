@component('mail::message')
<h1>Hulum Tender alerts for {{ Carbon\Carbon::now()->format('d/m/Y')}}</h1>
<p>
    This is a summary of tenders posted on hulum.et on {{ Carbon\Carbon::now()->format('d/m/Y')}}.
    ይህ በ hulum.et ላይ በ {{ Carbon\Carbon::now()->format('d/m/Y')}}. የተለጠፉ ጨረታዎችን የሚይሳይ ዝርዝር ነው። </p>

@if(count($tenders) > 0)
@foreach($tenders as $tender)

@component('mail::panel')
<h2>{{$tender->title}}</h2>
<p>{!! $tender->description !!} </p>

<table class="">
    <tbody>
        <tr>
            <td>Opening date |</td>
            <td class="ml-5">{{ Carbon\Carbon::parse($tender->opening_date)->format('d-m-Y G:ia ')}}</td>
        </tr>
        <tr>
            <td>Closing date" |</td>
            <td class="ml-5">{{Carbon\Carbon::parse($tender->closing_date)->format('d-m-Y G:ia ')}}</td>
        </tr>
        <tr>
            <td>Published on |</td>
            <td class="ml-5">{{$tender->reference}} ({{ Carbon\Carbon::parse($tender->reference_date)->isoFormat('MMM Do YYYY')}})</td>
        </tr>
    </tbody>
</table>
<div class="row d-flex">
    <div class="col-md-4">
        {{Carbon\Carbon::parse($tender->created_at)->diffForHumans()}}
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        @component('mail::btn', ['url' => 'hulum.et'])
        Details
        @endcomponent
    </div>
</div>


@endcomponent

@endforeach
@endif


@component('mail::button', ['url' => 'hulum.et'])
See More
@endcomponent

<p>Connect With Us:</p>
<div class="d-flex">
    <a href="#"><img slc="https://cdn3.iconfindel.com/data/icons/capsocial-round/500/facebook-512.png" alt="" style="height: 30px;">Facebook</a>
    <a href="#"><img slc="https://image.flaticonlcom/icons/png/512/124/124021.png" alt="" style="height: 30px;">tweeter</a>
    <a href="#"><img slc="https://image.flaticonlcom/icons/png/512/174/174857.png" alt="" style="height: 30px;">LinkedIn</a>
</div>
<p>You received this email because you are a premium member of hulum.et. Please do not reply to this email. Hulum values your privacy.</p>
<p>Address: Jema-a Bldg 702-4, Dembel to Meskel Flower road next to Dreamliner Hotel. Phone: +251 905 1111, Email: info@hulum.et</p>
<p class="text-center">Service Provided by Jaktech Pvt | Hulum - A Hub For All Ethiopian Businesses.</p>



@endcomponent
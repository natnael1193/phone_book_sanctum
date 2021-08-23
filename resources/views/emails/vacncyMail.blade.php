@component('mail::message')

<h1>Hulum Vacancy alerts for {{ Carbon\Carbon::now()->isoFormat('MMM Do YYYY')}}</h1>
<p>
    new vacancies have been posted today. This is a summary of open vacancies posted on hulum.et on {{ Carbon\Carbon::now()->isoFormat('MMM Do YYYY')}}.
    ይህ በ hulum.et ላይ በ {{ Carbon\Carbon::now()->isoFormat('MMM Do YYYY')}}. የተለጠፉ ክፍት የስራ ማስታወቂያዎች የሚይሳይ ዝርዝር ነው።
</p>

@if(count($vacancies) > 0)
@foreach($vacancies as $tender)

@component('mail::panel')
<h2>{{$tender->title}}</h2>
<p>{!! $tender->description !!} </p>
@endcomponent

@endforeach
@else
<p>Sorry no Vacancies for today</p>
@endif


@component('mail::button', ['url' => 'hulum.et'])
See More Vacancy
@endcomponent

<p>Connect With Us:</p>
<div class="d-flex">
    <a href="#"><img slc="https://cdn3.iconfindel.com/data/icons/capsocial-round/500/facebook-512.png" alt="" style="height: 30px;"></a>
    <a href="#"><img slc="https://image.flaticonlcom/icons/png/512/124/124021.png" alt="" style="height: 30px;"></a>
    <a href="#"><img slc="https://image.flaticonlcom/icons/png/512/174/174857.png" alt="" style="height: 30px;"></a>
</div>
<p>This email was sent to useremail@gmail.com. You received this email because you are a member of hulum.et. Please do not reply to this email. Hulum values your privacy.</p>
<p>Address: Jema-a Bldg 702-4, Dembel to Meskel Flower road next to Dreamliner Hotel. Phone: +251 905 1111, Email: info@hulum.et</p>
<p class="text-center">Service Provided by Jaktech Pvt | Hulum - A Hub For All Ethiopian Businesses.</p>



@endcomponent
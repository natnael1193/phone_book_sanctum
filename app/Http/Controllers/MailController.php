<?php

namespace App\Http\Controllers;

use App\Company;
use App\Mail\SendMail;
use App\Mail\vacancyMail;
use App\Subscriber;
use App\Tinder;
use App\User;
use App\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail() {

        $dt = Carbon::now()->toDateString();
        $date = Carbon::yesterday()->toDateString();

        $vacancies = Vacancy::where('created_at', '>=', $date)->where('created_at', '<=', $dt)->orderBy('created_at', 'desc')->get();
        $subscriber = Subscriber::orderBy('created_at', 'desc')->get();

        // foreach ($companies as $company) {
        //     Mail::to($company->company_email)->send(new TenderMail($tenders));
        // }
        // foreach ($users as $user) {
            Mail::to('yamlak.k@gmail.com')->send(new vacancyMail($vacancies));
        // }

        return 'Email Sent';
    }
}

<?php

namespace App\Http\Controllers;

use App\Company;
use App\Mail\SendMail;
use App\Tinder;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail() {
        $details = [
            'title' => 'Mail from Larave Email',
            'body' => 'This email is intended to a customer to notify the on our up coming products.'
        ];

        $users = User::all();

        $time = Carbon::today();

        $tender = Tinder::orderBy('created_at', 'desc')->get();
        $companies = Company::where('company_category','1')->orderBy('created_at', 'desc')->get();

        // foreach ($companies as $company) {
        //     Mail::to($company->company_email)->send(new TenderMail($tenders));
        // }
        // foreach ($users as $user) {
            Mail::to('yamlak.k@gmail.com')->send(new SendMail($tender));
        // }

        return 'Email Sent';
    }
}

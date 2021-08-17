<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail() {
        $details = [
            'title' => 'Mail from Larave Email',
            'body' => 'This email is intended to a customer to notify the on our up coming products.'
        ];

        // $users = User::all();

        // foreach ($users as $user) {
            Mail::to('yamlak.k@gmail.com')->send(new SendMail($details));
        // }

        return 'Email Sent';
    }
}

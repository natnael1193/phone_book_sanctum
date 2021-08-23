<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Company;
use App\Mail\SendMail;
use App\Mail\TenderMail;
use App\Mail\vacancyMail;
use App\Subscriber;
use App\Tinder;
use App\Vacancy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class vacancyNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:vacancy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email notification of Vacancy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dt = Carbon::now()->toDateString();
        $date = Carbon::yesterday()->toDateString();

        $vacancies = Vacancy::where('created_at', '>=', $date)->where('created_at', '<=', $dt)->orderBy('created_at', 'desc')->get();
        $subscriber = Subscriber::orderBy('created_at', 'desc')->get();

        // foreach ($companies as $company) {
        //     Mail::to($company->company_email)->send(new TenderMail($tenders));
        // }
            Mail::to('yamlak.k@gmail.com')->send(new vacancyMail($vacancies));


    }
}

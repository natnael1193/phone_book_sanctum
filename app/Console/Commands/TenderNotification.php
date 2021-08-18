<?php

namespace App\Console\Commands;

use App\Company;
use App\Mail\SendMail;
use App\Mail\TenderMail;
use App\Tinder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TenderNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:tender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email notification of tenders';

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
        $time = Carbon::yesterday();

        $tender = Tinder::orderBy('created_at', 'desc')->get();
        $companies = Company::where('company_category','1')->orderBy('created_at', 'desc')->get();

        // foreach ($companies as $company) {
        //     Mail::to($company->company_email)->send(new TenderMail($tenders));
        // }

        Mail::to('natnaelsolomon1193@gmail.com')->send(new TenderMail($tender));
        // Mail::to('yamlak.k@gmail.com')->send(new SendMail($tender));

    }
}

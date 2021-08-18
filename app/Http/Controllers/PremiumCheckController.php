<?php

namespace App\Http\Controllers;

use App\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PremiumCheckController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function premiumCheck($id)
    {
        $company = Company::findOrFail($id);

        if ($company->premiums != null) {
            $date = $company->premiums->date;
            $date = Carbon::parse($date); //You can use any date field you want
            $today = Carbon::now();

            $year_old  = $date->year;
            $month_old = $date->month;
            $day_old   = $date->day;

            $year  = $today->year;
            $month = $today->month;
            $day   = $today->day;

            if($year_old + 1 <= $year && $month_old >= $month){
                $company->company_category = 2;
                $company->save;
                return response()->json(['message'=>'Premium Subscription Expired']);
            }
            else{
                return response()->json(['message'=>'Premium Subscription Valid']);
            }
        }else{
            return response()->json(['message'=>'This User Has no Company Registered']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function premiumOrder($id)
    {
        $company = Company::findOrFail($id);
        $data = $company->premiums;

        if($data != null){
            return response()->json($data);
        }
        return response()->json(['message' => 'no premium requests Found']);
    }
}

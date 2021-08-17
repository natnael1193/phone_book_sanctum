<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CompanyOwner;
use App\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class CompanyOwnerLoginController extends Controller
{
    //

    public function login(Request $request)
    {

        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $subscriber = CompanyOwner::whereEmail($request->email)->first();
        if (!$subscriber || !Hash::check($request->password, $subscriber->password)) {
            return response([
                'email' => ['The provided credentials are incorrect.'],
            ], 404);
        }
        $subscriber_company = Company::where('subscriber_id',  $subscriber->id)->first();
        return ["id" => $subscriber->id, "first_name" => $subscriber->first_name, "last_name" => $subscriber->last_name, "email" => $subscriber->email, "company_id" => $subscriber_company->id,"company_name" => $subscriber_company->company_name, "company_email" => $subscriber_company->company_email,"company_phone" => $subscriber_company->phone_number,   "token" => $subscriber->createToken('API Token')->plainTextToken];
//   return  response()->json($subscriber_company);
    }
}

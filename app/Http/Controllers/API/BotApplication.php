<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BotApplication extends Controller
{
    public function application(Request $request)
    {
        // log the request
        logger()->info('Welcome to the chat bot application');
        logger()->info('Request: ', $request->all());

        // "custom_fields":{
        //     "application_first_name":"Jaka",
        //     "application_phone_number":"Hhaja",
        //     "application_loan_amount":"171",
        //     "application_surname":"Jajaja",
        //     "application_omang_number":"Jajajw",
        //     "application_physical_address":"Hahana",
        //     "application_hawkers_licence":"Babaja",
        //     "application_postal_address":"Hshah",
        //     "application_next_of_kin":"Bbush",
        //     "application_next_of_kin_omang":"Jshahw",
        //     "application_loan_purpose":"Jajaj",
        //     "Manychat: Access Channel to":null,
        //     "Date & Time Access":null
        //  }

        // DB::beginTransaction(function(){
            // validate the request
            $request->validate([
                'custom_fields.application_first_name' => 'required|string|max:255',
                'custom_fields.application_surname' => 'required|string|max:255',
                'custom_fields.application_phone_number' => 'required|string|max:255',
                'custom_fields.application_omang_number' => 'required|string|max:255',
                'custom_fields.application_physical_address' => 'required|string|max:255',
                'custom_fields.application_hawkers_licence' => 'required|string|max:255',
                'custom_fields.application_postal_address' => 'required|string|max:255',
                'custom_fields.application_next_of_kin' => 'required|string|max:255',
                'custom_fields.application_next_of_kin_omang' => 'required|string|max:255',
                'custom_fields.application_loan_purpose' => 'required|string|max:255',
                'custom_fields.application_loan_amount' => 'required|numeric|min:1',
            ], [
                'custom_fields.application_first_name.required' => 'The first name is required.',
                'custom_fields.application_surname.required' => 'The surname is required.',
                'custom_fields.application_phone_number.required' => 'The phone number is required.',
                'custom_fields.application_omang_number.required' => 'The omang number is required.',
                'custom_fields.application_physical_address.required' => 'The physical address is required.',
                'custom_fields.application_hawkers_licence.required' => 'The hawker\'s licence is required.',
                'custom_fields.application_postal_address.required' => 'The postal address is required.',
                'custom_fields.application_next_of_kin.required' => 'The next of kin is required.',
                'custom_fields.application_next_of_kin_omang.required' => 'The next of kin omang is required.',
                'custom_fields.application_loan_purpose.required' => 'The loan purpose is required.',
                'custom_fields.application_loan_amount.required' => 'The loan amount is required.',
            ]);

            logger()->info('Request validated');

            // save the request to the database
            $borrower = Borrower::updateOrCreate([
                'identification' => $request->input('custom_fields.application_omang_number'),
                 ], [
                'first_name' => $request->input('custom_fields.application_first_name'),
                'last_name' => $request->input('custom_fields.application_surname'),
                'gender' => $this->determineGender($request->input('custom_fields.application_omang_number')),
                'dob' => $request->input('custom_fields.application_dob') ?? '2005-01-01',
                'occupation' => $request->input('custom_fields.application_occupation') ?? 'N/A',
                'identification' => $request->input('custom_fields.application_omang_number'),
                'mobile' => $request->input('custom_fields.application_phone_number'),
                'email' => 'not provided',
                'address' => $request->input('custom_fields.application_physical_address'),
                'city' => $request->input('custom_fields.application_physical_address'),
                'province' => 'N/A',
                'zipcode' => 'N/A',
            ]);

            // create a loan application
            $loan = Loan::create([
                'borrower_id' => $borrower->id,
                'principal_amount' => $request->input('custom_fields.application_loan_amount'),
                'transaction_reference' => $request->input('custom_fields.application_loan_purpose'),
            ]);
        // });

        return response()->json([
            'message' => 'Your loan application has been received. We will get back to you soon.',
            'status' => 'success',
        ]);
    }

    function determineGender($digits) {
        // Check if the string length is exactly 9 digits
        if(strlen($digits) !== 9) {
            return "Invalid input";
        }

        // Check the fifth digit
        $fifthDigit = substr($digits, 4, 1);

        // Determine gender based on the fifth digit
        if($fifthDigit === '1') {
            return "Male";
        } elseif($fifthDigit === '2') {
            return "Female";
        } else {
            return "Unknown gender";
        }
    }

    function determineAge($dob) {

        // return date of 19 years ago from today
        $nineteenYearsAgo = date('Y-m-d', strtotime('-19 years'));

    }

}

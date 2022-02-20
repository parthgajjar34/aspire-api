<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanHistories;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    
    /**
     * Store a new loan.
     *
     * @param  Request  $request
     * @return Response
     */
    public function loanRegister(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'duration' => 'required',
            'amount' => 'required',
        ]);

        try {
            $loan = new Loan();
            $loan->user_id  = Auth::User()->id;
            $loan->name     = $request->input('name');
            $loan->duration = $request->input('duration');
            $loan->amount   = $request->input('amount');
            $loan->purpose  = $request->input('purpose');
            $loan->status   = 'Inprocess';
            
            $loan->save();
            //return successful response
            return response()->json(['loan' => $loan, 'message' => 'We have received your loan application, we will review and get back to you soon.'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Loan Registration Failed!'], 409);
        }
    }

    /**
     * Store a new loan.
     *
     * @param  Request  $request
     * @return Response
     */
    public function loanPayment(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'loan_id' => 'required',
            'amount_paid' => 'required',
        ]);

        try {
            $loanDetails = Loan::findOrFail($request->input('loan_id'));
            $remaining_balance = $loanDetails->amount - $request->input('amount_paid');

            if( $remaining_balance >=  $request->input('amount_paid') ) {
                $loanDetails = new LoanHistories();
                $loanDetails->loan_id     = $request->input('loan_id');
                $loanDetails->amount_paid   = $request->input('amount_paid');
                $loanDetails->paid_date  = \Carbon\Carbon::now();
                $loanDetails->remaining_balance   = $remaining_balance;
                
                $loanDetails->save();
                //return successful response
                return response()->json(['loan_details' => $loanDetails, 'message' => 'We have received your loan payment, remaining balance is: '.$remaining_balance], 201);
            } else {
                return response()->json(['message' => 'Amount is less than or equal to '. $remaining_balance], 409);
            }

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Loan payment Failed!'], 409);
        }
    }

}

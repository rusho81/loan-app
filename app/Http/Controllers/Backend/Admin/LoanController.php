<?php

namespace App\Http\Controllers\Backend\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\LoanTypes;
use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LoanController extends Controller
{
    function allLoanApplications(){
        $loan = DB::table('loan_applications')->where('status', 'not_approved')->get();
        return view('admin.loan_application.all', compact('loan'));
    }

    function allApprovedLoan() {
        $loan = DB::table('loan_applications')->where('status', 'approved')->get();
        return view('admin.loan_application.approved', compact('loan'));
    }

    function loanApplication(){
        $loan_types = LoanTypes::all();
        return view ('user.loan_application.application', compact('loan_types'));
    }

    function loanStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id); 
        $today = Carbon::now();
        $formattedDate = $today->format('Y-m-d');

        LoanApplication::insert([
            'name' => $data->name,
            'email' => $data->email,
            'amount' => $request->amount,
            'bank' => $request->bank,
            'account' => $request->account_no,
            'loan_type' => $request->loan_type,
            'installment_count' => $request->installment_counts,
            'installment_amount' => $request->installment_amount,
            'amount_payable' => $request->amount_payable,
            'date_applied' => $formattedDate,
            'status' => 'not_approved',
        ]);

        toastr()->success("Loan applied successfully!", 'Congrats');
        return redirect()->back();

    }

    function loanDetail($id){
        $loan = LoanApplication::findOrFail($id);
        return view('admin.loan_application.detail', compact('loan'));
    }

    function toggleStatus(Request $request, $id) {
        $loan = LoanApplication::findOrFail($id);
        $loan->status = ($request->has('status')) ? 'approved' : 'not_approved';
        $loan->save();

        toastr()->success('Loan status updated successfully!', 'Congrats');
        return redirect()->back();
    }

    function approvedLoan() {
        $email = auth()->user()->email;
        $loan = DB::table('loan_applications')->where('email',$email)->where('status', 'approved')->get();
        return view('user.loan_application.approved', compact('loan'));
    }
}

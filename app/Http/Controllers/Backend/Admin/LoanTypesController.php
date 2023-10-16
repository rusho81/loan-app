<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanTypes;

class LoanTypesController extends Controller
{
    function allLoanTypes(){
        $loan_type = LoanTypes::latest()->get();
        return view('admin.loan_type.all_loan_type', compact('loan_type'));
    }

    function addLoanTypes(Request $request){

        $validateData = $request->validate([
            'loanType' => 'required',
        ]);

        $loan_types = new LoanTypes();
        $loan_types->name = $validateData['loanType'];
        $loan_types->save();

        toastr()->success('Loan Type registered successfully!', 'Congrats');
        return redirect()->back();

    }
}

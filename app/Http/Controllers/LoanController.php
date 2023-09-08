<?php

namespace App\Http\Controllers;

use App\Models\LoanTypes;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    function loanApplication() {
        $loan_types = LoanTypes::all();
        return view('user.loan_application.application', compact('loan_types'));
    }
}

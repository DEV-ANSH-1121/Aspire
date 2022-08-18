<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan\Loan;
use App\Models\Loan\LoanRepayment;

class AdminController extends Controller
{
    /**
     * AdminController constructor.
     *
     * @param    User  $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Update Loan Status.
     *
     * @param    Request  $request
     * @return   mixed
     */
    public function updateLoanStatus(Request $request)
    {
        try {
            
            $data = $request->all();
            $loan = Loan::findOrFail($data['loan_id']);
            $loan->update([
                'status' => $data['status'] 
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Loan updated successfully'
        ], 200);
        
    }

    /**
     * Update Loan Status.
     *
     * @param    Request  $request
     * @return   mixed
     */
    public function getAllLoans(Request $request)
    {
        try {
            $data = $request->all();
            $loans = Loan::with('user','repayments')->paginate();
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Loan updated successfully',
            'loans' => $loans
        ], 200);
        
    }
}

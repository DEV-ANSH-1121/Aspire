<?php

namespace App\Http\Controllers\Api\Loan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan\Loan;
use App\Models\Loan\LoanRepayment;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Http\Requests\Loan\RepaymentLoanRequest;

class LoanController extends Controller
{
    /**
     * LoanController constructor.
     *
     * @param    User  $user
     */
    public function __construct(Loan $loan)
    {
        $this->model = $loan;
    }

    /**
     * Store Loan.
     *
     * @param    Request  $request
     * @return   mixed
     */
    public function storeLoan(StoreLoanRequest $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->validated();
            $user = \Auth::user();
            $data['left_term'] = $data['loan_term'];
            $loan = $user->loans()->create($data);
        } catch (\Throwable $th) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        \DB::commit();

        return response()->json([
            'status' => true,
            'loan' => $loan->load('repayments'),
            'message' => 'Loan created successfully'
        ], 200);        
    }

    /**
     * Loan Repayment.
     *
     * @param    Request  $request
     * @return   mixed
     */
    public function loanRepayment(RepaymentLoanRequest $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->validated();
            $loan = $this->model::findOrFail($data['loan_id']);

            if (!$loan->left_term || ($loan->status == Loan::getStatusIdByValue('Paid'))) {
                \DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Loan tenure is over'
                ], 403);
            }

            if (($reqAmount = $loan->loan_amount / $loan->left_term) < $data['amount_paid']) {
                \DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Please pay atleast '.$reqAmount
                ], 403);
            }

            $loan->repayments()->create($data);
            event(new LoanRepayment($loan));

        } catch (\Throwable $th) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        \DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Loan updated successfully',
            'loan' => $loan->load('repayments')
        ], 200);        
    }

    /**
     * Get Loan By Status.
     *
     * @param    Request  $request
     * @return   mixed
     */
    public function getLoansByStatus(Request $request)
    {
        try {
            $data = $request->all();
            $loans = $this->model::where('status',$data['status'])->with('user','repayments')->paginate();
            
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

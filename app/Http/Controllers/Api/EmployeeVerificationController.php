<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class EmployeeVerificationController extends Controller
{
    /**
     * Verify if employee is active.
     *
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke($code)
    {
        $employee = Employee::query()
            ->where('code', Crypt::decryptString($code))
            ->where(function ($query) {
                $query->where(function ($query) {
                        $query->whereNotNull('active_from')
                            ->where('active_from', '<=', date('Y-m-d', strtotime('now')));
                    })
                    ->where(function ($query) {
                        $query->whereNull('active_to')
                            ->orWhere('active_to', '>=', date('Y-m-d', strtotime('now')));
                    });
            })
            ->first();
    
        $employee_name = $employee->given_name.' '
            .$employee->middle_name.' '
            .$employee->family_name.' '
            .$employee->name_suffix;
        
        return response()->json($employee
            ? trim($employee_name).' is active.'
            : trim($employee_name).' is no longer active.'
        );
    }
}

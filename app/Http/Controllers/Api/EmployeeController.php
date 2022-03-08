<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $employees = Employee::all();
        
        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEmployee $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateEmployee $request)
    {
        try {
            DB::beginTransaction();
            
            $data = $request->validated();
            
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                
                if (!in_array($file->getClientMimeType(), ['image/jpeg', 'image/png'])) {
                    return response()->json('Invalid file type.', 400);
                }
                
                $data['photo'] = $request->input('code').'.'.$file->getClientOriginalExtension();
                
                if (Storage::exists('public/photos/'.$data['photo'])) {
                    Storage::delete('public/photos/'.$data['photo']);
                }
                
                Storage::put('public/photos/'.$data['photo'], $file->getContent());
            }
            
            $employee = Employee::create($data);
            
            DB::commit();
            return response()->json($employee);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e);
            return response()->json('Unable to create employee. Please try again later.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEmployee  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateEmployee $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $employee = Employee::find($id);
            
            if ($employee === null) {
                return response()->json('Employee not found.', 404);
            }
            
            $data = $request->validated();
            
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
        
                if (!in_array($file->getClientMimeType(), ['image/jpeg', 'image/png'])) {
                    return response()->json('Invalid file type.', 400);
                }
        
                $data['photo'] = $request->input('code').'.'.$file->getClientOriginalExtension();
        
                if (Storage::exists('public/photos/'.$data['photo'])) {
                    Storage::delete('public/photos/'.$data['photo']);
                }
        
                Storage::put('public/photos/'.$data['photo'], $file->getContent());
            }
            
            if ($data['code'] !== $employee->code AND $employee->photo) {
                $new_filename = str_replace($employee->code, $data['code'], $employee->photo);
                $data['photo'] = $new_filename;
                Storage::move('public/photos/'.$employee->photo, 'public/photos/'.$new_filename);
            }
            
            if ($data['photo'] === null AND $employee->photo) {
                $data['photo'] = $employee->photo;
            }
            
            $employee->fill($data)->save();
            
            DB::commit();
            return response()->json($employee);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e);
            return response()->json('Unable to update employee. Please try again later.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::find($id);
            
            if ($employee === null) {
                return response()->json('Employee not found.', 404);
            }
            
            $employee->delete();
        } catch (\Exception $e) {
            logger($e);
            return response()->json('Unable to delete employee. Please try again later.', 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor' => 'required|string|max:15',
            'nama' => 'required|string|max:150',
            'jabatan' => 'nullable|string|max:200',
            'talahir' => 'nullable|date',
            'photo' => 'nullable|file|image|max:2048',
            'created_by' => 'nullable|string|max:150',
        ]);

        $validated['created_on'] = now();
        $validated['created_by'] = Auth::user()->name ?? 'system';

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $tujuan_upload = 'photos';
            $filename = $file->getClientOriginalName();
            Storage::disk('s3')->putFileAs($tujuan_upload, $file, $filename);
            Storage::disk('s3')->setVisibility($tujuan_upload . '/' . $filename, 'public');
            $baseUrl = config('filesystems.disks.s3.url') ?? config('filesystems.disks.s3.endpoint');
            $path = $tujuan_upload . '/' . $filename;
            $validated['photo_upload_path'] = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }

        $employee = Employee::create($validated);

        // Simpan ke Redis
        Redis::set('emp_' . $employee->nomor, $employee->toJson());

        return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nomor' => 'sometimes|required|string|max:15',
            'nama' => 'sometimes|required|string|max:150',
            'jabatan' => 'nullable|string|max:200',
            'talahir' => 'nullable|date',
            'photo' => 'nullable|file|image|max:2048',
            'updated_by' => 'nullable|string|max:150',
        ]);

        $validated['updated_on'] = now();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $tujuan_upload = 'photos';
            $filename = $file->getClientOriginalName();
            Storage::disk('s3')->putFileAs($tujuan_upload, $file, $filename);
            Storage::disk('s3')->setVisibility($tujuan_upload . '/' . $filename, 'public');
            $baseUrl = config('filesystems.disks.s3.url') ?? config('filesystems.disks.s3.endpoint');
            $path = $tujuan_upload . '/' . $filename;
            $validated['photo_upload_path'] = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }

        $employee->update($validated);

        Redis::set('emp_' . $employee->nomor, $employee->toJson());

        return response()->json($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->deleted_on = now()->toDateTimeString();
        $employee->save();

        Redis::del('emp_' . $employee->nomor);

        return response()->json(['message' => 'Employee dihapus'], 204);
    }
}

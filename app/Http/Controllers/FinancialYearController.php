<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialYear;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class FinancialYearController extends Controller
{
    public function index()
    {
        $financial_years = FinancialYear::latest()->paginate(20);
        return view('admin.company.financial_year_list', compact('financial_years'));
    }

    public function create()
    {
        $route = route('admin.financial-years.store');
        return view('admin.company.financial_year_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            'financial_year' => [
                'required',
                'string',
                'max:10',
                Rule::unique('financial_years', 'financial_year')->whereNull('deleted_at')
            ],
             'description' => 'nullable|sometimes|max:1000'
        ]);
        $financial_year = new FinancialYear();
        $financial_year->financial_year = $request->financial_year;
        $financial_year->description = $request->description;
        $financial_year->created_by = Auth::id();
        $financial_year->save();
        if($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $financial_year
            ]);
        } else {
         return redirect()->route('admin.financial-years.index')->with(successMessage());
        }
    }


    public function edit($id)
    {
        $financial_year = FinancialYear::findOrFail(encrypt_decrypt($id, 'decrypt'));
        $route = route('admin.financial-years.update', $financial_year->id);
        return view('admin.company.financial_year_add_edit', compact('financial_year', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'financial_year' => [
                'required',
                'string',
                'max:50',
                Rule::unique('financial_years', 'financial_year')->whereNull('deleted_at')->ignore($id),
            ],
            'description' => 'nullable|sometimes|max:1000'
        ]);

        $financial_year = FinancialYear::findOrFail($id);
        $financial_year->financial_year = $request->financial_year;
        $financial_year->description = $request->description;
        $financial_year->created_by = Auth::id();
        $financial_year->save();
        return redirect()->route('admin.financial-years.index')->with(infoMessage());
    }


    public function destroy($id)
    {
        $financial_year = FinancialYear::findOrFail($id);
        $financial_year->update(['deleted_by' => Auth::id()]);
        $financial_year->delete();
        return redirect()->route('admin.financial-years.index')->with(deleteMessage());
    }
}

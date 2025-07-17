<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        $data = Company::query();
        $data->when(request()->get('search'),function($query) {
           $search = request()->get('search');
           $query->where('name',"LIKE","%{$search}%");
           $query->orWhere('mobile',request('search'));
        });
        $data->when(request()->get('status'),function($query) {
           $query->where('status',request()->get('status'));
        });
        $companies = $data->latest()->paginate(20);
        return view('admin.company.company_list', compact('companies'));
    }

    public function create()
    {
        $route = route('admin.companies.store');
        return view('admin.company.company_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:30',
                Rule::unique('companies', 'name')->whereNull('deleted_at')
            ],
            'email' => [
                'required',
                'string',
                'max:30',
                Rule::unique('companies', 'email')->whereNull('deleted_at')
            ],
            'mobile' => [
                'required',
                'string',
                'max:11',
                Rule::unique('companies', 'mobile')->whereNull('deleted_at')
            ],
            'phone' => [
                'nullable',
                'sometimes',
                'string',
                'max:30',
                Rule::unique('companies', 'phone')->whereNull('deleted_at')
            ],
            'contact_person_name' => 'required|max:50',
            'contact_person_mobile' => [
                'required',
                'string',
                'max:11',
                Rule::unique('companies', 'contact_person_mobile')->whereNull('deleted_at')
            ],
            'address' => 'required|max:500',
            'description' => 'nullable|sometimes|max:5000',
            'status' => 'required|in:active,inactive'
        ]);

        $company = new Company();
        $company->name = $request->name;
        $company->slug = Str::slug($request->name);
        $company->email = $request->email;
        $company->mobile = $request->mobile;
        $company->phone = $request->phone;
        $company->contact_person_name = $request->contact_person_name;
        $company->contact_person_mobile = $request->contact_person_mobile;
        $company->address = $request->address;
        $company->description = $request->description;
        $company->status = $request->status;
        $company->created_by = Auth::id();
        $company->save();
        return redirect()->route('admin.companies.index')->with(successMessage());
    }


    public function edit($id)
    {
        $company = Company::findOrFail(encrypt_decrypt($id,'decrypt'));
        $route = route('admin.companies.update', $company->id);
        return view('admin.company.company_add_edit', compact('company', 'route',));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:30',
                Rule::unique('companies', 'name')->whereNull('deleted_at')->ignore($id)
            ],
            'email' => [
                'required',
                'string',
                'max:30',
                Rule::unique('companies', 'email')->whereNull('deleted_at')->ignore($id)
            ],
            'mobile' => [
                'required',
                'string',
                'max:11',
                Rule::unique('companies', 'mobile')->whereNull('deleted_at')->ignore($id)
            ],
            'phone' => [
                'nullable',
                'sometimes',
                'string',
                'max:30',
                Rule::unique('companies', 'phone')->whereNull('deleted_at')->ignore($id)
            ],
            'contact_person_name' => 'required|max:50',
            'contact_person_mobile' => [
                'required',
                'string',
                'max:11',
                Rule::unique('companies', 'contact_person_mobile')->whereNull('deleted_at')->ignore($id)
            ],
            'address' => 'required|max:500',
            'description' => 'nullable|sometimes|max:5000',
            'status' => 'required|in:active,inactive'
        ]);
        $company = Company::findOrFail($id);
        $company->name = $request->name;
        $company->slug = Str::slug($request->name);
        $company->email = $request->email;
        $company->mobile = $request->mobile;
        $company->phone = $request->phone;
        $company->contact_person_name = $request->contact_person_name;
        $company->contact_person_mobile = $request->contact_person_mobile;
        $company->address = $request->address;
        $company->description = $request->description;
        $company->status = $request->status;
        $company->created_by = Auth::id();
        $company->save();
        return redirect()->route('admin.companies.index')->with(infoMessage());
    }

    public function updateCompanyStatus($id): \Illuminate\Http\JsonResponse
    {
        $company = Company::findOrFail($id);
        $company->status = $company->status === 'active' ? 'inactive' : 'active';
        if ($company->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Company status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update Company status.',
        ], 500);
    }

   public function destroy($id)
   {
       $company = Company::findOrFail($id);
       $company->update(['deleted_by' => Auth::id()]);
       $company->delete();
       return redirect()->route('admin.companies.index')->with(deleteMessage());
   }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function index()
    {
        $data = Organization::query();
        $data->when(request()->get('search'),function($query) {
           $search = request()->get('search');
           $query->where('name',"LIKE","%{$search}%");
           $query->orWhere('mobile',request('search'));
        });
        $data->when(request()->get('status'),function($query) {
           $query->where('status',request()->get('status'));
        });
        $organizations = $data->latest()->paginate(20);
        return view('admin.organization.organization_list', compact('organizations'));
    }

    public function create()
    {
        $route = route('admin.organizations.store');
        return view('admin.organization.organization_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('organizations', 'name')->whereNull('deleted_at')
            ],
            'email' => [
                'required',
                'string',
                'max:30',
                Rule::unique('organizations', 'email')->whereNull('deleted_at')
            ],
            'mobile' => [
                'required',
                'string',
                'max:11',
                Rule::unique('organizations', 'mobile')->whereNull('deleted_at')
            ],
            'phone' => [
                'nullable',
                'sometimes',
                'string',
                'max:30',
                Rule::unique('organizations', 'phone')->whereNull('deleted_at')
            ],
            'contact_person_name' => 'required|max:50',
            'contact_person_mobile' => [
                'required',
                'string',
                'max:11',
                Rule::unique('organizations', 'contact_person_mobile')->whereNull('deleted_at')
            ],
            'address' => 'required|max:500',
            'description' => 'nullable|sometimes|max:5000',
            'status' => 'required|in:active,inactive'
        ]);

        $organization = new Organization();
        $organization->name = $request->name;
        $organization->slug = Str::slug($request->name);
        $organization->email = $request->email;
        $organization->mobile = $request->mobile;
        $organization->phone = $request->phone;
        $organization->contact_person_name = $request->contact_person_name;
        $organization->contact_person_mobile = $request->contact_person_mobile;
        $organization->address = $request->address;
        $organization->description = $request->description;
        $organization->status = $request->status;
        $organization->created_by = Auth::id();
        $organization->save();
        return redirect()->route('admin.organizations.index')->with(successMessage());
    }


    public function edit($id)
    {
        $organization = Organization::findOrFail(encrypt_decrypt($id,'decrypt'));
        $route = route('admin.organizations.update', $organization->id);
        return view('admin.organization.organization_add_edit', compact('organization', 'route',));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('organizations', 'name')->whereNull('deleted_at')->ignore($id)
            ],
            'email' => [
                'required',
                'string',
                'max:30',
                Rule::unique('organizations', 'email')->whereNull('deleted_at')->ignore($id)
            ],
            'mobile' => [
                'required',
                'string',
                'max:11',
                Rule::unique('organizations', 'mobile')->whereNull('deleted_at')->ignore($id)
            ],
            'phone' => [
                'nullable',
                'sometimes',
                'string',
                'max:30',
                Rule::unique('organizations', 'phone')->whereNull('deleted_at')->ignore($id)
            ],
            'contact_person_name' => 'required|max:50',
            'contact_person_mobile' => [
                'required',
                'string',
                'max:11',
                Rule::unique('organizations', 'contact_person_mobile')->whereNull('deleted_at')->ignore($id)
            ],
            'address' => 'required|max:500',
            'description' => 'nullable|sometimes|max:5000',
            'status' => 'required|in:active,inactive'
        ]);
        $organization = Organization::findOrFail($id);
        $organization->name = $request->name;
        $organization->slug = Str::slug($request->name);
        $organization->email = $request->email;
        $organization->mobile = $request->mobile;
        $organization->phone = $request->phone;
        $organization->contact_person_name = $request->contact_person_name;
        $organization->contact_person_mobile = $request->contact_person_mobile;
        $organization->address = $request->address;
        $organization->description = $request->description;
        $organization->status = $request->status;
        $organization->created_by = Auth::id();
        $organization->save();
        return redirect()->route('admin.organizations.index')->with(infoMessage());
    }

    public function updateorganizationStatus($id): \Illuminate\Http\JsonResponse
    {
        $organization = Organization::findOrFail($id);
        $organization->status = $organization->status === 'active' ? 'inactive' : 'active';
        if ($organization->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'organization status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update organization status.',
        ], 500);
    }

   public function destroy($id)
   {
       $organization = Organization::findOrFail($id);
       $organization->update(['deleted_by' => Auth::id()]);
       $organization->delete();
       return redirect()->route('admin.organizations.index')->with(deleteMessage());
   }
}

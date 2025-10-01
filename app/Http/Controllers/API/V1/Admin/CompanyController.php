<?php
namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends BaseController
{
    public function index(Request $request)
    {
        $companies = Company::all();
        return $this->sendResponse($companies, 'Companies retrieved successfully.');
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return $this->sendResponse($company, 'Company retrieved successfully.');
    }

    public function store(Request $request)
    {
        //Considera los siguientes valores(`name`, `legal_name`, `rfc`, `tax_regime`, `fiscal_address`, `zip_code`, `country`, `phone`, `email`, `website`, `created_by`, `status`)
        $request->validate([
            'name' => 'required|unique:companies,name',
            'legal_name' => 'required',
            'rfc' => 'required|unique:companies,rfc',
            'tax_regime' => 'required',
            'fiscal_address' => 'required',
            'zip_code' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:companies,email',
            'website' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        $company = new Company();
        $company->name = $request->name;
        $company->legal_name = $request->legal_name;
        $company->rfc = $request->rfc;
        $company->tax_regime = $request->tax_regime;
        $company->fiscal_address = $request->fiscal_address;
        $company->zip_code = $request->zip_code;
        $company->country = $request->country;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->website = $request->website;
        $company->created_by = $request->user()->id;
        $company->status = $request->status;
        $company->save();

        return $this->sendResponse($company, 'Company created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:companies,name,'.$id,
            'legal_name' => 'required',
            'rfc' => 'required|unique:companies,rfc,'.$id,
            'tax_regime' => 'required',
            'fiscal_address' => 'required',
            'zip_code' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:companies,email,'.$id,
            'website' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

         $company = Company::findOrFail($id);

        $company->name = $request->name;
        $company->legal_name = $request->legal_name;
        $company->rfc = $request->rfc;
        $company->tax_regime = $request->tax_regime;
        $company->fiscal_address = $request->fiscal_address;
        $company->zip_code = $request->zip_code;
        $company->country = $request->country;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->website = $request->website;
        $company->status = $request->status;
        $company->save();

        return $this->sendResponse($company, 'Company updated successfully.');
    }
    

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return $this->sendResponse([], 'Company deleted successfully.');
    }
}

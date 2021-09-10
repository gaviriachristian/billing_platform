<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\BusinessInformation;
use App\Models\AdvanceReport;

class CompaniesController extends Controller
{
    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Companies"], ['name' => "Index"]];
        return view('/content/companies/index', ['breadcrumbs' => $breadcrumbs]);
    }
    
    public function data()
    {
        $companies = BusinessInformation::all('id','contact_id','business_name','last_name','first_name');
        return $companies;
    }

    public function detail($id)
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/companies/index", 'name' => "Companies"], ['name' => "Detail"]];
        $businessInformation = BusinessInformation::where('id', $id)->get();
        $company = $businessInformation[0]->attributesToArray();
        return view('/content/companies/detail', ['id' => $id, 'company' => $company, 'breadcrumbs' => $breadcrumbs]);
    }
    
    public function detailAdvanceData($id)
    {
        $advances = AdvanceReport::where('contact_id', $id)->get();
        return $advances;
    }
}

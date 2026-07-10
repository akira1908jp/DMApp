<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Document;

class DashboardController extends Controller
{
    public function index() {
        if (auth()->user()->hasRole("approveAsHq")) {
            // 部門毎に予算を合算する
            $documents = Document::all()
            ->where("status", 'approved') 
            ->groupBy("department_code")
            ->map(function($document) {
                return [ 
                'department_name' => $document[0]->department->name,
                'total_budget' => $document->sum("budget")];
            })
            ->all();
            // 実績額を部門ごとに合算して取得する
            $actuals = DB::select("
                    select
                    documents.department_code,
                    sum(tasks.actual) as total_actual
                    from
                    documents
                    inner join tasks
                    on documents.id = tasks.document_id
                    group by
                    documents.department_code  
                    order by
                    department_code          
            ");
            return view("dashboard", compact('documents', 'actuals'));
        }
        return view("dashboard");
    }
}

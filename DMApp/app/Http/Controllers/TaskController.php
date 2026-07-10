<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index($documentId) {
        $page = 15;
        $tasks = Task::where('document_id',$documentId)
        ->orderBy("created_at","desc")->simplePaginate($page);
        return view("task.index", ['tasks' => compact('tasks')]);
    }


    public function create($id) 
    {
        $document = Document::find($id);
        return view('task.create', ['document'=> compact('document')]);
    }
            

    public function store(Request $request) {
        
        $validated = $request->validate([
            'report' => 'required',
            'title'=> 'required',
            'actual' => 'required|digits_between:2,20',
            'progress_date' => 'required',
            'progress_status'=> 'required'
        ]);
        $task = new Task(); 
        $task->report = $validated['report'];
        $task->title = $validated['title'];
        $task->document_id = $request->document_id;
        $task->actual = $validated['actual'];
        $task->progress_date = $validated['progress_date'];
        $task->progress_status = $validated['progress_status'];
        $task->expenses = $request->expenses;
        if ($request->is_completed == 1) {
            $task->is_completed = $request->is_completed;
        }

        $task->save();
        // 案件IDから進捗情報を取得してindex画面をレンダリング
        return redirect()->route("task.index", $task->document_id)->with("success","進捗情報を入力しました。");
    }
    public function show($id) { 
        $tasks = Task::with('document')->findOrFail( $id );
        return view("task.show", ["tasks"=> compact("tasks")]);
    }
    public function edit($id) { 
        $tasks = Task::with("document")->findOrFail( $id );
        return view("task.edit", ["tasks"=> compact("tasks")]);
    }
    public function update(Request $request, $id) {
        $task = Task::findOrFail( $id );

        $validated = $request->validate([
            'report' => 'required',
            'title'=> 'required',
            'actual' => 'required|digits_between:2,20',
            'progress_date' => 'required',
            'progress_status'=> 'required'
        ]);
        $task->report = $validated['report'];
        $task->title = $validated['title'];
        $task->actual = $validated['actual'];
        $task->progress_date = $validated['progress_date'];
        $task->progress_status = $validated['progress_status'];
        $task->expenses = $request->expenses;
        if ($request->is_completed == 1) {
            $task->is_completed = $request->is_completed;
        }

        $task->save();

        return redirect()->route("task.index", $task->document_id)->with("success","");
    }
    public function destroy($id) {
        $task = Task::findOrFail($id);
        $task->delete();
        
        return redirect()->route("task.index", $task->document_id)
                ->with('warning','進捗情報を削除しました。');
    }
}

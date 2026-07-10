<?php
namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\States\Draft;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = null;
        $page = 15;
        if (Auth::user()->hasRole("approveAsHq")) {
            $documents = Document::with('tasks')->withSum('tasks', 'actual')
            ->whereIn('status', ['approved', 'pending_hq'])
            ->orderBy('department_code')
            ->orderby('created_at', 'desc')->paginate($page);
        } else if (Auth::user()->hasRole("approveAsAdmin")) {
            $documents = Document::with("tasks")->withSum('tasks','actual')
            ->whereNotIn('status',['draft','rejected'])
            ->where('department_code', Auth::user()->department_code)
            ->orderBy("created_at","desc")->simplePaginate($page);
        } else {
            $documents = Document::with("tasks")->withSum('tasks','actual')
            ->where('user_id', Auth::id())
            ->orderBy("created_at","desc")->simplePaginate($page);
        }
        // dd($documents);
        return view("documents.index", compact('documents'));
    }
    // 1. 新規作成画面の表示
    public function create()
    {
        return view('documents.create');
    }

    // 2. データベースへの保存処理
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'budget'=> 'required|digits_between:2,20',
        ]);

        // 保存処理
        $document = new Document();
        $document->title = $validated['title'];
        $document->description = $request->description;
        $document->department_code = Auth::user()->department_code;
        $document->budget = $validated["budget"];
        $document->user_id = Auth::id(); // ログインユーザーを申請者として紐付け
        
        // ステータスはModelのdefault configで 'draft' になりますが、
        // 明示的に指定することも可能です
        $document->status = new Draft("");

        $document->save();

        return redirect()->route('documents.index', $document)
            ->with('success', '案件を下書き保存しました。');
    }
    public function show($id) {
        $document = Document::findOrFail($id);
        return view('documents.show', compact('document'));
    }

    public function destroy($id) {
        $document = Document::find($id);

        $document->delete();

        $documents = Document::with("tasks")->where('user_id', Auth::id())
        ->orderBy("created_at","desc")->simplePaginate(15);
        return redirect()->route('documents.index', compact('documents'))->with('warning','案件を削除しました。');
    }

    public function update(Request $request, $id) {
        
        $document = Document::findOrFail($id);
    
        // バリデーション
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'budget'=> 'required|digits_between:2,20',
        ]);

        $document->title = $validated['title'];
        $document->description = $request->description;
        $document->budget = $validated["budget"];
    
        $document->save();
        
        return redirect()->route('documents.index', $document)
            ->with('success', '案件を編集しました。');

    }

}
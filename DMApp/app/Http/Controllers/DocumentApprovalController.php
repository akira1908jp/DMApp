<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use App\States\PendingAdmin;
use App\States\PendingHeadquarters;
use App\States\Approved;
use App\States\Draft;
use App\States\Rejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GeneralNotification;

class DocumentApprovalController extends Controller
{
    /**
     * 1. 申請者による「申請」アクション
     */
    public function submit(Request $request, Document $document)
    {
        // 権限チェック（作成者本人か）
        // $this->authorize('update', $document);

        // 下書き状態か確認し、管理部門待ちへ遷移
        $document->status = new PendingAdmin("");
        $document->save();

        $dpmgrs = User::where('department_code', Auth::user()->department_code)->get();
        
        foreach ($dpmgrs as $dpmgr) {    
            if ($dpmgr->hasAllRoles('approveAsAdmin')) {
                $dpmgr->notify(new GeneralNotification("案件名:{$document->title}の申請されました。"));
            }
        }
        
        return redirect()->route('documents.index', $document)
            ->with('success', '管理部門へ申請しました。');
    }

    /**
     * 2. 管理部門による「承認」アクション
     */
    public function approveAdmin(Request $request, Document $document)
    {
        // 権限チェック（Policyで定義した管理部門権限があるか）
        // $this->authorize('approveAsAdmin', $document);

        // バリデーション（コメントを必須にする場合など）
        // $request->validate(['comment' => 'nullable|string|max:200']);

        // 本部待ちへ遷移（Transitionクラスにコメントを渡す）
        $document->status = new PendingHeadquarters(""); 
        $document->save();

        $hqmgrs = User::where('department_code', '0')->get();
        foreach ($hqmgrs as $hqmgr) {
            if ($hqmgr->hasAllRoles('approveAsHq')) {
                $hqmgr->notify(new GeneralNotification("案件名:{$document->title}の申請されました。"));
            }
        }
        return redirect()->route('documents.index')
            ->with('success', '本部へ承認を回しました。');
    }

    /**
     * 3. 本部による「最終承認」アクション
     */
    public function approveHq(Request $request, Document $document)
    {
        // $this->authorize('approveAsHq', $document);

        // 最終承認状態へ遷移
        $document->status = new Approved("");
        $document->save();
        $user = User::find($document->user_id);
        $user->notify(new GeneralNotification("案件名:{$document->title}の承認が完了しました。"));
        return redirect()->route('documents.index')
            ->with('success', '最終承認が完了しました。');
    }

    /**
     * 4. 共通の「差し戻し」アクション
     */
    public function returnToDraft(Request $request, Document $document)
    {
        // 承認権限がある人なら誰でも差し戻せると定義する場合
        // $this->authorize('approve', $document);

        // $request->validate(['comment' => 'required|string']);

        // 下書き（Draft）へ戻す
        $document->status = new Draft("");
        $document->save(); 

        return redirect()->route('documents.index')
            ->with('info', '申請者へ差し戻しました。');
    }

    public function rejected(Request $request, Document $document) {

        $document->status = new Rejected("");
        $document->save(); 

        $user = User::find($document->user_id);
        $user->notify(new GeneralNotification("案件名:{$document->title}の承認が却下されました。"));

        return redirect()->route('documents.index')
            ->with('warning', '申請を却下しました');
    }

    public function edit($id) {
        $document = Document::findOrFail($id);
        return view('documents.edit', compact('document'));
    }

    public function copy($id) {
        $document = Document::findOrFail($id);
        return view('documents.store', compact('document'));   
    }

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
 
}
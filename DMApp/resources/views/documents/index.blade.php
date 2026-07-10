<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('案件一覧画面') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div
                        class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">

                        <table class="w-full text-left table-auto min-w-max">
                            <thead>
                                <tr>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">案件名</th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">担当者</th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">部門</th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">ステータス</th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">操作</th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">予算</th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">実績額</th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">消費率</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-4 border-b border-slate-200">
                                            <a href="{{ route('documents.show', $document) }}"
                                                class="text-blue-500">{{ $document->title }}</a>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">{{ $document->user->name }}</td>
                                        <td class="p-4 border-b border-slate-200">{{ $document->department->name }}</td>
                                        <td class="p-4 border-b border-slate-200">
                                            {{-- ステータスに応じたラベル表示 componentを使用--}}
                                            <x-workflow-status status="{{ $document->status }}">
                                                {{ $document->status->label() }}
                                            </x-workflow-status>

                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            {{-- 1. 申請者向けの操作（下書き時のみ） --}}
                                            @role('user')
                                            @if($document->status->is(\App\States\Rejected::class))
                                                <a href="{{ route('documents.copy', $document) }}">複製</a>
                                            @endif
                                            @if($document->status->is(\App\States\Draft::class))
                                                <a href="{{ route('documents.edit', $document) }}"
                                                    class="btn btn-secondary">編集する</a>
                                            @endif
                                            @endrole
                                        
                                            {{-- 進捗入力はユーザーのみ --}}
                                            @if ($document->status->is(\App\States\Approved::class))
                                                @role('user')
                                                <a href="{{ route('task.create', $document) }}"
                                                    class="btn btn-secondary">進捗入力</a>
                                                @endrole
                                                @if ($document->tasks()->count() > 0)
                                                    <a href="{{ route('task.index', $document) }}">進捗一覧</a>
                                                @endif
                                            @endif

                                        </td>
                                        <td class="p-4 border-b border-slate-200">{{ number_format($document->budget) }}
                                        </td>
                                        @if (!empty($document->tasks_sum_actual))
                                            <td class="p-4 border-b border-slate-200">
                                                {{ number_format($document->tasks_sum_actual) }}
                                            </td>
                                            <td class="p-4 border-b border-slate-200">
                                                {{ round(($document->tasks_sum_actual / $document->budget) * 100, 2) }}%
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="8">{{ $documents->links() }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if(session('success'))
                        <div>
                            <span class="text-blue-500">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('warning'))
                        <div>
                            <span class="text-red-500">{{ session('warning') }}</span>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
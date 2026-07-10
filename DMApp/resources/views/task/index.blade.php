<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('進捗一覧') }}
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
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            タスク名
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            実績
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            進捗日付
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            進捗率
                                        </p>
                                    </th>
                                    @role('user')
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">操作</p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500"></p>
                                    </th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($tasks as $task)
                                    @foreach ($task as $tas)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-4 border-b border-slate-200">
                                                <p class="block text-xl font-medium text-slate-800">
                                                <a class="text-blue-500" href="{{ route('task.show', $tas) }}">
                                                    {{ $tas->title }}</p>
                                                </a>                                                    
                                            </td>
                                            <td class="p-4 border-b border-slate-200">
                                                <p class="block text-xl font-medium text-slate-800">
                                                    {{ number_format($tas->actual) }}</p>
                                            </td>
                                            <td class="p-4 border-b border-slate-200">
                                                <p>{{ \Carbon\Carbon::parse($tas->progress_date)->format('Y年m月j日') }}</p>
                                            </td>
                                            <td class="p-4 border-b border-slate-200">
                                                <span>{{ $tas->progress_status }}%</span>
                                                @if ($tas->is_completed == 1)
                                                    <span class="text-green-600">完了</span>
                                                @endif
                                            @role('user')
                                            <td class="p-4 border-b border-slate-200">
                                                @if ($tas->is_completed == 0)
                                                    <a class="" href="{{ route('task.edit', $tas) }}">編集</a>
                                                @endif
                                            </td>
                                            <td class="p-4 border-b border-slate-200">
                                                <form action="{{ route('task.destroy', $tas) }}" method="post">
                                                    <button type="submit" class="bg-white text-red-700"
                                                        onclick="return confirm('進捗情報を削除しますか？')">削除</button>
                                                </form>
                                            </td>
                                            @endrole
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7">{{ $task->links() }}</td>
                            </tr>
                            </tfoot>
                        </table>
                        
                        <div class="flex justyfy-end w-full">
                            <a href="{{ route('documents.index') }}" class="font-normal text-black ">戻る</a>
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
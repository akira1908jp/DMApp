<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('進捗報告') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($tasks as $task)
                        <div>
                            <label for="name">担当者名</label><span>{{ $task->document->user->name }}</span>
                            <label for="department">部門</label><span>{{ $task->document->department->name }}</span>
                        </div>
                        <div>
                            <label for="title">
                            案件名
                            <span>{{ $task->document->title }}</span>
                            </label>
                        </div>
                        <div>
                            <label for="budget">
                            予算
                            <span>{{ number_format( $task->document->budget) }}</span>
                            </label>
                        </div>
                    <div>
                        <label for="title">タスク名
                        <span>{{ $task->title }}</span>
                        </label>
                    </div>
                    <div>
                        <label for="actual">日付
                            <span>{{ \Carbon\Carbon::parse($task->progress_date)->format('Y年m月j日') }}</span>
                        </label>
                    </div>
                    <div>
                        <label for="progress_status">進捗率
                        <span>{{ $task->progress_status }}%</span>
                        @if($task->is_completed == 1)
                            <span>完了</span>
                        @endif
                        </label>
                    </div>


                    <div>
                        <label for="actual">実績
                        <span>{{ number_format($task->actual) }}</span>
                        </label>
                    </div>                   

                    <div>
                        <x-input-label for="report" :value="__('進捗報告')" />
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        id="report" name="report" type="text" rows="6" autofocus>{{  $task->report }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="expenses" :value="__('科目')" />
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        id="expenses" name="expenses" rows="6"  autofocus>{{ $task->expenses }}</textarea>
                    </div>    
                    @endforeach     
                    <div class="flex justyfy-end w-full">
                        <a href="{{ url()->previous() }}" class="font-normal text-black ">戻る</a>
                    </div>                            
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

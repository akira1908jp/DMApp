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
                <form action="{{ route('task.update', $task->id) }}" method="POST">
                    @csrf
                    
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
                        <span>{{ number_format($task->document->budget) }}</span>
                        </label>
                    </div>
                    <div>
                    <label for="task" >{{ __('タスク名') }}
                    <span class="bg-red-600 text-white font-medium text-sm rounded-sm font-serif">必須</span>
                    </label>
                        <x-text-input id="title" name="title" type="text" class="mt-1 block" :value="$task->title" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>
                    <div>
                    <label for="progress_date" >{{ __('日付') }}
                    <span class="bg-red-600 text-white font-medium text-sm rounded-sm font-serif">必須</span>
                    </label>
                        <x-text-input id="progress_date" name="progress_date" type="date" class="mt-1 block" :value="old('progress_date', \Carbon\Carbon::parse($task->prograss_date)->format('Y-m-d'))" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('progress_date')" />
                    </div>

                    @php
                    $progressStatus = 
                    ['0'  => '0%','10'=> '10%','20'=> '20%', '30' => '30%',
                     '40' => '40%', '50' => '50%', '60' => '60%', '70' => '70%',
                     '80' => '80%', '90' => '90%', '100' => '100%'];
                    @endphp
                    <div>
                        <label for="progress_status">進捗率
                        <span class="bg-red-600 text-white font-medium text-sm rounded-sm font-serif">必須</span>
                        <select class="form-select" id="progress_status" name="progress_status">
                            @foreach ($progressStatus as $status => $val)
                                <option value="{{ $status }}" {{ $task->progress_status == $status ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                        <input type="checkbox" name="is_completed" id="is_completed" value="1">完了
                        </label>
                    </div>
                    <div>
                            <label for="actual">{{ __('実績') }}
                            <span class="bg-red-600 text-white font-medium text-sm rounded-sm font-serif">必須</span>
                            </label>
                        <x-text-input id="actual" name="actual" type="text" class="mt-1 block" :value="old('actual',$task->actual)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('actual')" />
                    </div>                   
                    <div>
                        <label for="report">{{ __('進捗報告') }}
                            <span class="bg-red-600 text-white font-medium text-sm rounded-sm font-serif">必須</span>
                        </label>
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        id="report" name="report" type="text" rows="6" value="{{ old('report') }}" required autofocus>{{ $task->report }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('report')" />
                    </div>
                    <div>
                        <x-input-label for="expenses" :value="__('科目')" />
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        id="expenses" name="expenses" type="text" rows="6" value="{{ old('expenses') }}" autofocus>{{ $task->expenses }}</textarea>
                    </div>    
                    @endforeach                                     
                    <div class="flex items-center justify-between gap-4">
                    <a href="{{ url()->previous() }}" class="font-normal text-black ">戻る</a>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

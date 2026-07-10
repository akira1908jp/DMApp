<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('申請詳細画面') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <label for="status">{{ __('申請ステータス') }}
                            <x-workflow-status status="{{ $document->status }}">
                                {{ $document->status->label() }}
                            </x-workflow-status>
                        </label>
                    </div>
                    <div>
                        <label for="name">{{ __('申請者') }}
                            <span>{{ $document->user->name }}</span>
                        </label>
                        <label for="deparment"> {{ __('部門') }}
                            <span>{{ $document->department->name }}</span>
                        </label>
                    </div>
                    <div>
                        <label for="title">{{ __('案件名') }}
                            <span class="mt-1 max-w-fit">{{ $document->title }}</span>
                        </label>
                    </div>

                    <div>
                        <label for="budget">{{ __('予算') }}
                        </label>
                        <span class="mt-1 max-w-fit">{{ number_format($document->budget) }}</span>
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('目的・概要')" />
                        <textarea
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                            id="description" name="description" rows="6" readonly
                            autofocus>{{ $document->description }}</textarea>
                    </div>

                    <div class="flex flex-row gap-5 justify-between w-full">
                        <a href="{{ url()->previous() }}" class="font-normal text-black ">戻る</a>
                        @role('user')

                        @if($document->status->is(\App\States\Rejected::class))
                            <form action="{{ route('documents.destroy', $document) }}" method="post">
                                @csrf
                                @method('delete')
                                <x-danger-button type="submit" onclick="return confirm('削除しますか？')">削除</x-danger-button>
                            </form>
                        @endif
                        @if($document->status->is(\App\States\Draft::class))
                            <form action="{{ route('documents.submit', $document) }}" method="POST" class="d-inline">
                                @csrf
                                <x-secondary-button type="submit" class="btn btn-primary">管理部門へ申請</x-secondary-button>
                            </form>
                        @endif
                        @endrole
                        {{-- 2. 管理部門向けの操作 --}}
                        @role('approveAsAdmin')
                        @if($document->status->is(\App\States\PendingAdmin::class))
                            <form action="{{ route('documents.approve-admin', $document) }}" method="POST">
                                @csrf
                                <x-secondary-button type="submit" class="btn btn-success">承認して本部へ申請
                                </x-secondary-button>
                                <x-danger-button type="submit" formaction="{{ route('documents.rejected', $document) }}">
                                    却下</x-danger-button>
                            </form>
                        @endif
                        @endrole

                        {{-- 3. 本部向けの操作 --}}
                        @role('approveAsHq')
                        @if($document->status->is(\App\States\PendingHeadquarters::class))
                            <form action="{{ route('documents.approve-hq', $document) }}" method="POST">
                                @csrf
                                <x-secondary-button type="submit" class="btn btn-danger">最終承認を完了する</x-secondary-button>
                                <x-danger-button type="submit"
                                    formaction="{{ route('documents.rejected', $document) }}">却下</x-danger-button>
                            </form>
                        @endif
                        @endrole


                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
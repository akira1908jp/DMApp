

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('申請画面') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                <form action="{{ route('documents.store') }}" method="POST">
                    @csrf

                        <div>
                            <label for="title" >{{ __('案件名') }}
                            <span class="bg-red-600 text-white font-medium text-sm rounded-sm font-serif">必須</span>
                            <label>
                            <x-text-input id="title" name="title" type="text" class="mt-1 max-w-fit w-max" :value="old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <label for="budget">{{ __('予算') }}
                            <span class="bg-red-600 text-white font-medium text-sm rounded-sm font-serif">必須</span>
                            </label>
                            <x-text-input id="budget" name="budget" type="number" min="1" class="mt-1 max-w-fit w-max" :value="old('budget')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('budget')" />
                        </div>  

                        <div>
                        <x-input-label for="description" :value="__('目的・概要')" />
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        id="description" name="description"  rows="6" value="{{ old('description') }}" autofocus></textarea>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                        <a href="{{ url()->previous() }}" class="font-normal text-black ">戻る</a>
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                        <div>
                    </div>                   
                </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>    




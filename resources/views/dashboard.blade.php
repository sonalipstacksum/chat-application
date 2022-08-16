@extends('layouts.app')
@section('content')

<div class="w-full sm:px-6 overflow-auto">
    @if (session('status'))
        <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">
        <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
            Dashboard
        </header>
        <div class="w-full p-6">
            <div class="min-w-full border rounded lg:grid lg:grid-cols-3">
                <div class="border-r border-gray-300 lg:col-span-1">
                    <!-- <div class="mx-3 my-3">
                        <div class="relative text-gray-600">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewBox="0 0 24 24" class="w-6 h-6 text-gray-300">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </span>
                            <input type="search" class="block w-full py-2 pl-10 bg-gray-100 rounded outline-none" name="search"
                                placeholder="Search" required />
                        </div>
                    </div> -->
                    <ul class="overflow-auto h-[32rem]">
                        <h2 class="my-2 mb-2 ml-2 text-lg text-gray-600">Chats</h2>
                        <input type="hidden" id="loggedIn" value="{{Auth::user()->id}}">
                        <li>
                            @foreach($users as $user)
                            @if($user->id != Auth::user()->id)
                                    <a class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer 
                                        hover:bg-gray-100 focus:outline-none user-chat" data-id="{{$user->id}}">
                                        <img class="object-cover w-10 h-10 rounded-full" src="{{asset('images/user.png')}}" alt="{{$user->name}}" />
                                        <div class="w-full pb-2">
                                            <div class="flex justify-between">
                                                <span class="block ml-2 font-semibold text-gray-600">{{$user->name}}</span>
                                                <!-- <span class="block ml-2 text-sm text-gray-600">25 minutes</span> -->
                                            </div>
                                            <!-- <span class="block ml-2 text-sm text-gray-600">bye</span> -->
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </li>
                    </ul>
                </div>
                <div class="hidden lg:col-span-2 lg:block" id="chatWindow"></div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
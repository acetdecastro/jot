@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-300">
    <div class="w-96 bg-blue-900 rounded-lg shadow-xl p-6">

        <svg class="fill-current text-blue-200 w-16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M3.9 4.2c-.5 0-.8.3-.8.8s.4.8.8.8c.5 0 .8-.4.8-.8.1-.5-.3-.8-.8-.8zM3.3 18.6c0 1.4-.2 2.1-1.5 2.1-.3 0-.7 0-.9-.1l-.3 1.1c.3.1.7.2 1.1.2 1.9 0 2.7-1.2 2.7-3.2V8.1H3.3v10.5zM9.4 17.5c1.4 0 2.3-.4 3-1.2.8-1 1.1-2.1 1.1-3.8 0-1.4-.2-2.7-1-3.5-.6-.7-1.5-1.1-2.9-1.1s-2.3.4-3 1.2c-.8 1-1.1 2.2-1.1 3.8 0 1.5.2 2.6 1 3.5.6.7 1.5 1.1 2.9 1.1zM7.5 9.7c.3-.4.9-.8 2-.8 1 0 1.6.3 1.9.7.5.6.7 1.7.7 2.9s-.2 2.4-.7 3.1c-.3.4-.9.8-2 .8-1 0-1.6-.3-1.9-.7-.5-.6-.7-1.6-.7-2.9 0-1.2.2-2.4.7-3.1zM15 14.4c0 2.1.4 3.1 2.5 3.1.6 0 1.3-.1 1.8-.2l-.1-1c-.5.1-1 .2-1.5.2-1.4 0-1.5-.6-1.5-2.1v-5h3V8.3h-3v-3l-1.2.2v2.7h-1.8v1.1H15v5.1zM6 18h17v1H6z"/>
        </svg>

        <h1 class="text-white text-3xl pt-6">Welcome Back</h1>
        <h2 class="text-blue-300">Enter your credentials below</h2>

        <form class="pt-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="relative">
                <label 
                    for="email" 
                    class="pl-3 pt-2 uppercase text-blue-500 text-xs font-bold absolute"
                >
                    {{ __('E-mail') }}
                </label>

                <div class="">
                    <input
                        id="email"
                        type="email"
                        class="pt-8 p-3 w-full rounded bg-blue-800 text-gray-100 outline-none focus:bg-blue-700 
                            @error('email') border border-red-600 @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                        placeholder="your@email.com"
                    >

                    @error('email')
                        <span class="text-xs text-red-500 pt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="relative pt-3">
                <label
                    for="password"
                    class="pl-3 pt-2 uppercase text-blue-500 text-xs font-bold absolute"
                >
                    {{ __('Password') }}
                </label>

                <input
                    id="password"
                    type="password"
                    class="pt-8 p-3 w-full rounded bg-blue-800 text-gray-100 outline-none focus:bg-blue-700 
                        @error('email') border border-red-600 @enderror"
                    name="password"
                    autocomplete="current-password"
                    placeholder="Your Password"
                >

                @error('password')
                    <span class="text-xs text-red-500 pt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="pt-2">
                <label class="text-white cursor-pointer" for="remember">
                    <input class="cursor-pointer" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Remember Me') }}
                </label>
            </div>
            
            <div class="pt-6">
                <button
                    type="submit"
                    class="bg-gray-400 uppercase text-blue-800 py-2 w-full rounded font-bold hover:bg-gray-200 focus:outline-none"
                >
                    Log In
                </button>
            </div>

            <div class="pt-6 flex justify-between text-white font-bold text-sm">
                <a class="hover:text-blue-200" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
                <a class="hover:text-blue-200" href="{{ route('register') }}">
                    Sign Up
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

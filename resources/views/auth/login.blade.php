@extends('layouts.app')

@section('title', 'Login - Movie App')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white text-center">{{ __('messages.login_title') }}</h2>
            </div>
            
            <form method="POST" action="{{ route('login') }}" class="px-6 py-8">
                @csrf
                
                <div class="mb-6">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">
                        {{ __('messages.username') }}
                    </label>
                    <input type="text" 
                           name="username" 
                           id="username" 
                           value="{{ old('username') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('username') border-red-500 @enderror"
                           required>
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                        {{ __('messages.password') }}
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror"
                           required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    {{ __('messages.login_button') }}
                </button>
                
                <div class="mt-4 text-sm text-gray-600 text-center">
                    <p>Username: <strong>aldmic</strong></p>
                    <p>Password: <strong>123abc123</strong></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
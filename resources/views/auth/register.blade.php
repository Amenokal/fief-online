@extends('layouts.auth')

@section('content')
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <!-- Name -->
        <div>
            <input id="username" class="block mt-1 w-full" type="text" name="username" placeholder='Username...' required />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <input id="email" class="block mt-1 w-full" type="email" name="email" placeholder='Email...' required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder='Mot de passe...' 
                            required />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            placeholder='Confirmer mot de passe...' 
                            required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="ml-4">
                {{ __('Register') }}
            </button>
        </div>

        <a href="./">Retour</a>
    </form>

@endsection

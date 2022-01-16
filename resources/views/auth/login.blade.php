@extends('layouts.auth')

@section('content')

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class='input-wrapper'>
            {{-- <label for="email">Email</label> --}}
            
            <input id="username"
            type="text" name="username" 
            placeholder='Username...' 
            required />

        </div>
        
        <div class='input-wrapper'>
            {{-- <label for="password" >Password</label> --}}
            
            <input id="password"
            type="password"
            name="password"
            placeholder='Mot de passe...'
            required />
            
        </div>
        
        <button type='submit'>Log In</button>
        
        <a href='/fief/public/register'>Register</a>
    </form>


@endsection
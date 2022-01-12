@extends('layouts.app')
	@section('content')
		<div class="container"  :user="{{auth()->user()}}">
	    		<chats :user="{{auth()->user()}}"></chats>
		</div>	
	@endsection

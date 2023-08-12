@extends('layouts.app')

@section("content")
    <verification-component :id_customer="{{ json_encode($id_customer) }}" :id_session="{{ json_encode($id_session) }}" />
@endsection

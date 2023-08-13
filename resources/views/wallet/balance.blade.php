@extends('layouts.app')

@section("content")
    <checkbalance-component :id_customer="{{ json_encode($id_customer) }}" />
@endsection
@extends('auth.layout')

@section('content')

<div class="container">
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <a class="btn btn-primary float-right m-2" href="{{route('email-templates.create')}}">Add Email Template</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Employee</th>
                <th scope="col">Subject</th>
                <th scope="col">Message</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $rec)
            <tr>
                <td>{{$rec->id}}</td>
                <td>{{$rec->getEmployeeName->name}}</td>
                <td>{{$rec->subject}}</td>
                <td>{{$rec->message}}</td>
                <td><img src="{{URL::asset('/image/'.$rec->image)}}" alt="profile Pic" height="50" width="50" />
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
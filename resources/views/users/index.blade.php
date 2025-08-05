@extends('layouts.app')
@section('content_title', 'Data Users')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Users</h3>

            <div class="d-flex justify-content-end mb-2">
                <x-user.form-user />
            </div>
        </div>
        <div class="card-body">
            <x-alert :errors="$errors" />
            <table id="table2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="d-flex">
                                    <x-user.form-user :id="$user->id" />
                                    <a href="{{ route('users.destroy', $user->id) }}" data-confirm-delete="true"
                                        class="btn btn-danger ml-2 mr-2">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <x-user.reset-password :id="$user->id" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Account {{ $account->ig_username }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/a/accounts') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['a/accounts', $account->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Account',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <a href="{{ url('/a/accounts/'.$account->id . '/download') }}" title="Download"><button class="btn btn-info btn-xs"><i class="fa fa-arrow-down" aria-hidden="true"></i> Download</button></a>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>IG Username</th>
                                        <th>Followers</th>
                                        <th>Followings</th>
                                        <th>Duplicates</th>
                                        <th>Without Duplicates</th>
                                        <th>Biography</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $account->ig_username }}</td>
                                        <td><b>Total: {{count($account->ffollowers)}}</b><br>  {{!! implode(",<br>",$account->ffollowers) !!}}</td>
                                        <td><b>Total: {{count($account->ffollowings)}}</b><br> {{!! implode(',<br>',$account->ffollowings) !!}}</td>
                                        <td><b>Total: {{count($account->duplicates)}}</b><br> {{!! implode(',<br>',$account->duplicates) !!}}</td>
                                        <td><b>Total: {{count($account->withoutduplicates)}}</b><br> {{!! implode(',<br>',$account->withoutduplicates) !!}}</td>
                                        <td>
                                            {{$account->bio}}
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

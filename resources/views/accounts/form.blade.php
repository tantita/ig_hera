<style type="text/css">
    input.account{
        margin-bottom: 10px;
    }
</style>
<div class="form-group {{ $errors->has('ig_username') ? 'has-error' : ''}}">
    {!! Form::label('ig_username', 'IG Username(s)', ['class' => 'col-md-4 control-label']) !!}
    {{--
    <div class="col-md-6">
        {!! Form::text('ig_username', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('ig_username', '<p class="help-block">:message</p>') !!}
    </div>
    --}}

    <div class="col-sm-6">

        <div class="col-sm-9">
            <div id="ig_usernames">
                <div><input class="account" type="text" required name="ig_usernames[]"/> &nbsp;   <a href="#" class="remove_field">Remove</a></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div>
                <button class="btn btn-info" id="btnAdd"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
        </div>
        
        
    </div>
</div>
{{--
<div class="form-group {{ $errors->has('followers') ? 'has-error' : ''}}">
    {!! Form::label('followers', 'Followers', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('followers', null, ['class' => 'form-control']) !!}
        {!! $errors->first('followers', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('followings') ? 'has-error' : ''}}">
    {!! Form::label('followings', 'Followings', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('followings', null, ['class' => 'form-control']) !!}
        {!! $errors->first('followings', '<p class="help-block">:message</p>') !!}
    </div>
</div>
--}}

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Go!', ['class' => 'btn btn-primary']) !!}
    </div>
</div>


@section('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $("#ig_usernames"); //Fields wrapper
        var add_button      = $("#btnAdd"); //Add button ID
        
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div><input class="account" type="text" required name="ig_usernames[]"/> &nbsp;   <a href="#" class="remove_field">Remove</a></div>'); //add input box
                $('.account').last().focus()
            }
        });
        
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
            $('.account').last().focus()
        })
    });
</script>

@endsection

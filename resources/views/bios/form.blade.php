<div class="form-group {{ $errors->has('ig_username') ? 'has-error' : ''}}">
    {!! Form::label('ig_username', 'Ig Username', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('ig_username', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('ig_username', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('bio') ? 'has-error' : ''}}">
    {!! Form::label('bio', 'Bio', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('bio', null, ['class' => 'form-control']) !!}
        {!! $errors->first('bio', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

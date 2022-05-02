@extends('layouts.app')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a New Thread</div>

                    <div class="panel-body">
                        <form method="POST" action="/threads">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('channel_id') ? ' has-error' : '' }}">
                                <label class="control-label" for="channel_id">
                                    Channel:{{ $errors->has('channel_id') ? ' required field.' : ''}}
                                </label>
                                <select class="form-control" id="channel_id" name="channel_id" required>
                                    <option value="">Select...</option>

                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label class="control-label" for="title">
                                    Title: {{ $errors->has('title') ? ' required field.' : ''}}
                                </label>

                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Bob Dylan" value="{{ old('title') }}" required>
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label class="control-label" for="body">
                                    Body:{{ $errors->has('body') ? ' required field.' : ''}}
                                </label>
                                <wysiwyg name="body"></wysiwyg>
                            </div>

                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                            @if (count($errors))
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{ $error }}</div>
                                @endforeach
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

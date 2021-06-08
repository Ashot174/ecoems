<div class="container bootstrap snippet" id="content_password">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-th"></span>
                        Change password
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 separator social-login-box"> <br>
                            <img alt="" class="img-thumbnail" src="{{ asset('logo/111.jpg') }}">
                        </div>

                        <div style="margin-top:80px;" class="col-xs-6 col-sm-6 col-md-6 login-box">
                            <form action="{{ route('password.change') }}" method="POST">
                                @csrf

                                @foreach ($errors->all() as $error)
                                    <p class="text-danger">{{ $error }}</p>
                                @endforeach

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                        <input class="form-control" id="current_password" name="current_password" type="password" placeholder="Current Password" autocomplete="current-password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-log-in"></span></div>
                                        <input class="form-control" id="new_password" name="new_password" type="password" placeholder="New Password" autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-log-in"></span></div>
                                        <input class="form-control" id="new_confirm_password" name="new_password_confirmation" type="password" placeholder="New Confirm Password" autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
{{--                                            <button class="btn icon-btn-save btn-success" type="submit">--}}
{{--                                                <span class="btn-save-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>save</button>--}}
                                            <input type="submit" value="Change password" >
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="wrapper">
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-4 loginform mt-4">
                <form action="{{ route('login') }}" method="post" class="profile_form" enctype="multipart/form-data" id="registrationForm" novalidate="novalidate">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user_email">Email/Username</label>
                                <input type="text" name="email" id="email" class="form-control required form_input @error('email') is-invalid @enderror" placeholder="Email" value="" aria-required="true" spellcheck="true" aria-invalid="false">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 passwdd">
                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input type="password" name="password" id="user_password" class="form-control required form_input @error('password') is-invalid @enderror" required="required" placeholder="Password" value="" aria-required="true" spellcheck="true" aria-invalid="false">                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" name="bttnsubmit" class="btn animatedbutton subbutton hvr-sweep-to-top loginform">Log In</button>                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <h5><a href="{{ route('password.request') }}" class="redilink">Forgotten password ?</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="EmailMain" style="max-width: 800px;font-family: 'Arial';margin: 0 auto;background-color:#75b74a;margin-bottom:30px;">
    <div style="border-radius:0px; padding-bottom:20px; padding-top:20px; text-align:center;"><a href="{{route('index')}}" target="_new"><img alt="sitelogo" class="img-responsive" src="{{asset($logo)}}" style="margin:10px auto;max-width:66%;" /> </a></div>

    <div class="EmailMainInner" style="padding: 45px 120px;background-color: #e8e8e8; max-width: 815px; margin: 0 auto;">
        <div class="EmailContent" style="">
            <div class="EmailTable" style="padding: 10px; text-align:center;line-height: 1.8;background-color:#fff; margin-top:20px;">
                <table cellpadding="0" cellspacing="0" style="width:100%;border:none;">
                    <tbody>
                    <tr>
                        <td>
                            <div>
                                <div style="color: #000;font-size:16px;color:#000;text-align:left;"><strong>Dear {{$user->name}},</strong></div>

                                <div style="font-size:14px;color:#000;margin-top:15px;text-align:left;">Administrator has added you&nbsp;&nbsp;successfully. Please access your account by using below mentioned login details via below link:</div>

                                <div style="font-size:14px;color:#000;margin-top:15px;text-align:left;">Login - <strong>{{$user->email}}</strong></div>

                                <div style="font-size:14px;color:#000;margin-top:15px;text-align:left;">Password - <strong>{{$password}}</strong></div>
                            </div>

                            <p></p>

                            <div class="EmailBottom" style="text-align: center;margin-top:30px;color: #ffffff;"><a href="{{route('index')}}" style="background-color: #75b74a;color: #fff; padding:12px 15px;font-size: 16px;letter-spacing:0.6px; text-decoration:none;">Click Here</a></div>

                            <p></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

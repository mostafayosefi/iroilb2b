<!doctype html>
<html lang="en">
<head>
    <style>
        .all {
            width: 100%;
            text-align: center;
            font-family: Tahoma;
        }

        .box {
            width: 50%;
            padding: 50px;
            margin: auto;
            background: #495464;
            color: #BBBFCA;
            text-align: center;
            border-radius: 20px;
        }
    </style>
</head>
<body>
<div class="all">
    <div class="box">
        @if($lang=='fa')
            @if($action=='company')
                <h2 dir="rtl">
                    شرکت شما تایید شد.
                </h2>
                <br>
                <a style="color:#BBBFCA;" href="{{URL::to('fa/panel/company')}}">مشاهده</a>
            @elseif($action=='message')
                <h2 dir="rtl">
                    IR OIL B2B پیام جدید از
                </h2>

                <br>
                <a style="color:#BBBFCA;" href="{{URL::to('fa/panel')}}">مشاهده پیام</a>
            @elseif($action=='ticket')
                <h2 dir="rtl">
                    تیکت شما پاسخ داده شد.
                </h2>

                <br>
                <a style="color:#BBBFCA;" href="{{URL::to('fa/support')}}">مشاهده تیکت</a>
            @endif
        @else
            @if($action=='company')
                <h2 dir="rtl">
                    Your company has been confirmed.
                </h2>
                <br>
                <a style="color:#BBBFCA;" href="{{URL::to('en/panel/company')}}">View</a>
            @elseif($action=='message')
                <h2 dir="rtl">
                    New message from IR OIL B2B.
                </h2>

                <br>
                <a style="color:#BBBFCA;" href="{{URL::to('en/panel')}}">View messages</a>
            @elseif($action=='ticket')
                <h2 dir="rtl">
                    Your ticket has been answered.
                </h2>

                <br>
                <a style="color:#BBBFCA;" href="{{URL::to('en/support')}}">View ticket</a>
            @endif
        @endif
        <br>
        <br>
        <a href="{{URL::to('/')}}" style="color:#BBBFCA;">IR Oil B2B</a>
    </div>
</div>


</body>
</html>

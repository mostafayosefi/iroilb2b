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

            <h2 dir="rtl">
                کد تایید شما:
            </h2>

        @else
            <h2>
                Your verification code:
            </h2>

        @endif
        <br>
        <strong><h1>{{$code}}</h1></strong>
            <br>
            <a href="{{URL::to('/')}}" style="color:#BBBFCA;">IR Oil B2B</a>
    </div>
</div>


</body>
</html>

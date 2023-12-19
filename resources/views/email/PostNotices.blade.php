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

        <img src="{{$post['image']}}">
        <h2>
            {{$post['title']}}
        </h2>
        <br>
        <p>
            {{$post['text']}}
        </p>
        <br>
        <a style="color:#BBBFCA;" href="{{$post['link']}}">{{$lang=='fa'?'مشاهده':'view'}}</a>

        <br>
        <br>
        <a href="{{URL::to('/')}}" style="color:#BBBFCA;">IR Oil B2B</a>
    </div>
</div>


</body>
</html>

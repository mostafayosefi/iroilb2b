<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        * {
            padding: 10px 10px 0 10px;
            margin: 0;
        }
    </style>
</head>
<body>
<main>
    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            @php
                $num=0;
                foreach((array)$headers as $header){
                    $num++;
                }
            @endphp
            <th colspan="{{$num}}">
                <h1 class="mb-3 fw-bold">{{$title}}</h1>
                <h3>{{$detail->description}}</h3>
                <p>
                    {{$water}}
                </p>
            </th>
        </tr>
        <tr class="bg-secondary text-white">
            @foreach((array)$headers as $header)
                @php
                    $header = json_decode($header);
                @endphp
                <th scope="col">{{$header->title}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach((array)$body as $data)
            <tr>
                @php
                    $data = json_decode($data);
                @endphp
                @foreach($data->col as $item)
                    <td>
                        {{ $item->title }}
                        <small style="color: #aeaeae" class="text-sm d-block">{{$water}}</small>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        <tfoot class="bg-dark">
        <tr class="text-white">
            <th colspan="{{$num}}">
                www.iroilb2b.com
            </th>
        </tr>
        </tfoot>
    </table>
</main>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hospital</title>
</head>
<body>
    
    @include('partials.header')

    <div>Nurses</div>

    <table>
        <thead>
            <tr>
                @if(isset($nurses[0]))
                    @foreach($nurses[0] as $key => $value)
                        <th>{{ $key }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($nurses as $nurse)
                <tr>
                    @foreach($nurse as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
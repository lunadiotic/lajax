<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF::Product Barcode</title>
</head>
<body>
    <table width="100%">
        <tr>
            @foreach($product as $data)
                <td align="center" style="border: 1px solid #ccc;">
                    {{ $data->product }} <br>
                    <img src="data:image/png;base64, {{ DNS1D::getBarcodePNG($data->barcode, 'C39') }}" height="60" width="180" alt="">
                    <br>{{ $data->barcode }}
                </td>
                @if( $no++ % 3 == 0)
                    </tr>
                    <tr>
                @endif
            @endforeach
        </tr>
    </table>
</body>
</html>
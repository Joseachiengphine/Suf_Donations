<!DOCTYPE html>
<html lang="en">

<div style="margin-left: 7rem; margin-top: 10rem; width: 60%; padding: 1.8rem">
    <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/images/logo.png'))); ?>" width="400" style="page-break-after: always;" alt="strathmore-logo">
</div>
<div style="page-break-after: always; padding: 2rem; text-align: center">
    <h1>{{ $fileName }}</h1>
    <p>Downloaded on {{ date("d/m/Y") }}</p>
</div>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $fileName }}</title>
    <style type="text/css" media="all">
        * {
            font-family: Times New Roman, serif !important;
        }

        html{
            width:100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border-radius: 10px 10px 10px 10px;
        }

        table td,
        th {
            border-color: #000000;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            overflow: scroll;
            padding: 10px 5px;
            word-break: normal;
        }

        table th {
            font-weight: normal;
        }

    </style>
</head>
<body>
    <table>
        <tr>
            @foreach ($columns as $column)
                <th>
                    {{ $column->getLabel() }}
                </th>
            @endforeach
        </tr>
        @foreach ($rows as $row)
            <tr>
                @foreach ($columns as $column)
                    <td>
                        {{ $row[$column->getName()] }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>

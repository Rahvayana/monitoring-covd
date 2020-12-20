<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/admin-lte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin-lte/dist/css/adminlte.min.css">
</head>
<body>
    <div class="container">
        <form action="{{ route('save-contact', $contact->id) }}" method="POST">@csrf
            <table class="table">
                <tr>
                    <td>Provinsi:</td>
                    @if ($contact->provinsi)
                    <td><input type="text" class="form-control" name="provinsi" id="provinsi" value="{{$contact->provinsi??$contact->kabupaten}}"></td>
                        
                    @else
                    <td><input type="text" class="form-control" name="kabupaten" id="kabupaten" value="{{$contact->provinsi??$contact->kabupaten}}"></td>
                    @endif
                </tr>
                <tr>
                    <td>URL:</td>
                    <td><input type="text" name="url" class="form-control" id="url" value="{{$contact->url}}"></td>
                </tr>
                <tr>
                    <td>No Telp:</td>
                    <td><input type="text" class="form-control" name="no_telp" id="no_telp" value="{{$contact->no_telp}}"></td>
                </tr>
            </table>
            <button class="btn btn-success">Update</button>
        </form>
    </div>
</body>
</html>

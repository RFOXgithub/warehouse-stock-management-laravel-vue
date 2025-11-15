<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Koneksi DB</title>
</head>

<body>
    <div>
        @php
        try {
        if (DB::connection()->getPdo()) {
        echo "Successfully Connected to DB and DB Name is: " . DB::connection()->getDatabaseName();
        }
        } catch (\Exception $e) {
        echo "Connection failed: " . $e->getMessage();
        }
        @endphp
    </div>
</body>

</html>
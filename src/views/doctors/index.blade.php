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

    <div>Doctors</div>

    <form action="/controllers/doctors/index.php" method="get">
        <div>
            Filter by
            <input type="text" name="personalnumber" placeholder="Personal Number">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="position" placeholder="Position">
        </div>
        <div>
            Sort by
            <select name="sort">
                <option value="">Select field</option>
                <option value="name">Name</option>
            </select>
            <select name="direction">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
        <input type="submit" value="Submit">
    </form>
    
    @include('partials.table', ['items' => $doctors])
    
</body>
</html>
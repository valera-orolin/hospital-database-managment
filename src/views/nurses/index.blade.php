<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Hospital</title>
</head>
<body class="bg-gray-100 flex items-center justify-center">

    <div class="container mx-auto px-4">
        <div class="bg-white shadow-md rounded my-6">
            <div class="text-center py-4">
                @include('partials.header')
            </div>

            <div class="px-12 pb-10">
                <div class="text-center text-5xl mb-8 font-bold">Nurses</div>

                <form action="/controllers/nurses/index.php" method="get" class="mb-4">
                    <div>
                        Filter by
                        <input type="text" name="personalnumber" placeholder="Personal Number" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="name" placeholder="Name" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="position" placeholder="Position" class="border rounded px-3 py-2 mr-2">
                    </div>
                    <div class="mt-2">
                        Sort by
                        <select name="sort" class="border rounded px-3 py-2 mr-2">
                            <option value="">Select field</option>
                            <option value="name">Name</option>
                        </select>
                        <select name="direction" class="border rounded px-3 py-2 mr-2">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                    <input type="submit" value="Submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>

                @include('partials.table', ['items' => $nurses])
            </div>
        </div>
    </div>

</body>
</html>
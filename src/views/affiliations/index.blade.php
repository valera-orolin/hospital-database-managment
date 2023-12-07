<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Hospital</title>
</head>
<body class="bg-gray-100 flex items-center justify-center">

    <div class="container mx-auto px-4">
        <div class="bg-white shadow-md rounded my-6">
            <div class="text-center py-4">
                @include('partials.header')
            </div>

            <div class="px-12 pb-10">
                <div class="text-center text-5xl mb-8 font-bold">Affiliations</div>

                <form action="/controllers/affiliations/index.php" method="get" class="mb-4">
                    <div class="space-y-2">
                        Filter by
                        <input type="text" name="doctor" placeholder="Doctor" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="department" placeholder="Department" class="border rounded px-3 py-2 mr-2">
                        <select name="isaffiliationprimary" class="border rounded px-3 py-2 mr-2">
                            <option value="">Is Affiliation Primary</option>
                            <option value="1">True</option>
                            <option value="false">False</option>
                        </select>
                    </div>
                    <div class="mt-2 space-y-2">
                        Sort by
                        <select name="sort" class="border rounded px-3 py-2 mr-2">
                            <option value="">Select field</option>
                            <option value="doctor">Doctor</option>
                            <option value="department">Department</option>
                        </select>
                        <select name="direction" class="border rounded px-3 py-2 mr-2">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                    <input type="submit" value="Submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>

                <!-- Create form -->
                <form action="/controllers/affiliations/store.php" method="post" class="mb-4">
                    <div class="space-y-2">
                        <input type="text" name="doctor" placeholder="Doctor" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="department" placeholder="Department" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="isaffiliationprimary" placeholder="Is Affiliation Primary" class="border rounded px-3 py-2 mr-2">
                    </div>
                    <input type="submit" value="Create New" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>

                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b">
                                @if (isset($affiliations[0]))
                                    @foreach ($affiliations[0] as $key => $value)
                                        <th class="text-left p-3 px-5">{{ $key }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($affiliations as $affiliation)
                                <tr class="border-b hover:bg-orange-100">
                                    @foreach ($affiliation as $value)
                                        @if (is_array($value) && isset($value['url']) && isset($value['text']))
                                            <td class="p-3 px-5"><a href="{{ $value['url'] }}" class="text-gray-500 hover:text-gray-900 hover:underline">{{ $value['text'] }}</a></td>
                                        @else
                                            <td class="p-3 px-5">{{ $value }}</td>
                                        @endif
                                    @endforeach
                                    <td><button class="edit-button text-green-500 p-3 px-5"><i class="fas fa-edit"></i></button></td>

                                    <!-- Delete form -->
                                    <td class="text-red-500 p-3 px-5">
                                        <form id="delete-form" action="/controllers/affiliations/destroy.php" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            <input type="hidden" name="doctor" value="{{ $affiliation['doctor'] }}">
                                            <input type="hidden" name="department" value="{{ $affiliation['department'] }}">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>                                        
                                    </td>               
                                </tr>

                                <!-- Update form -->
                                <tr class="border-b hidden">
                                    <form id="edit-form" action="/controllers/affiliations/update.php" method="post">
                                        @foreach ($affiliation as $key => $value)
                                            @if (strpos($key, 'link-') === 0)
                                                <td class="p-3 px-5"></td>
                                            @elseif ($key != 'doctor' && $key != 'department')
                                                <td class="p-3 px-5">
                                                    <input type="text" name="{{ $key }}" value="{{ $value }}" class="border-none focus:outline-none focus:ring-0">
                                                </td>
                                            @else
                                                <td class="p-3 px-5">
                                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                                </td>
                                            @endif
                                        @endforeach
                                        <td class="p-3 px-5 text-blue-500 cursor-pointer">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="/../../js/script.js"></script>

</body>
</html>
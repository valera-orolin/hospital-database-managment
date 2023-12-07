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
                <div class="text-center text-5xl mb-8 font-bold">Treatments</div>

                <form action="/controllers/treatments/index.php" method="get" class="mb-4">
                    <div class="space-y-2">
                        Filter by
                        <input type="text" name="patient" placeholder="Patient" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="doctor" placeholder="Doctor" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="nurse" placeholder="Nurse" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="procedure" placeholder="Procedure" class="border rounded px-3 py-2 mr-2">
                    </div>
                    <div class="mt-2 space-y-2">
                        Sort by
                        <select name="sort" class="border rounded px-3 py-2 mr-2">
                            <option value="">Select field</option>
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Nurse</option>
                        </select>
                        <select name="direction" class="border rounded px-3 py-2 mr-2">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                    <input type="submit" value="Submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>

                <!-- Create form -->
                <form action="/controllers/treatments/store.php" method="post" class="mb-4">
                    <div class="space-y-2">
                        <input type="text" name="patient" placeholder="Patient" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="doctor" placeholder="Doctor" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="nurse" placeholder="Nurse" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="procedure" placeholder="Procedure" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="hospitalization" placeholder="Hospitalization" class="border rounded px-3 py-2 mr-2">
                        <input type="date" name="date" placeholder="Date" class="border rounded px-3 py-2 mr-2">
                    </div>
                    <input type="submit" value="Create New" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>

                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b">
                                @if (isset($treatments[0]))
                                    @foreach ($treatments[0] as $key => $value)
                                        <th class="text-left p-3 px-5">{{ $key }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($treatments as $treatment)
                                <tr class="border-b hover:bg-orange-100">
                                    @foreach ($treatment as $value)
                                        @if (is_array($value) && isset($value['url']) && isset($value['text']))
                                            <td class="p-3 px-5"><a href="{{ $value['url'] }}" class="text-gray-500 hover:text-gray-900 hover:underline">{{ $value['text'] }}</a></td>
                                        @else
                                            <td class="p-3 px-5">{{ $value }}</td>
                                        @endif
                                    @endforeach

                                    <!-- Delete form -->
                                    <td class="text-red-500 p-3 px-5">
                                        <form id="delete-form" action="/controllers/treatments/destroy.php" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            <input type="hidden" name="patient" value="{{ $treatment['patient'] }}">
                                            <input type="hidden" name="procedure" value="{{ $treatment['procedure'] }}">
                                            <input type="hidden" name="hospitalization" value="{{ $treatment['hospitalization'] }}">
                                            <input type="hidden" name="date" value="{{ $treatment['date'] }}">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>                                        
                                    </td>    
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
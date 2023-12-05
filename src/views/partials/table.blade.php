<table class="w-full text-md bg-white shadow-md rounded mb-4">
    <thead>
        <tr class="border-b">
            @if (isset($items[0]))
                @foreach ($items[0] as $key => $value)
                    <th class="text-left p-3 px-5">{{ $key }}</th>
                @endforeach
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr class="border-b hover:bg-orange-100">
                @foreach ($item as $value)
                    @if (is_array($value) && isset($value['url']) && isset($value['text']))
                        <td class="p-3 px-5"><a href="{{ $value['url'] }}" class="hover:underline">{{ $value['text'] }}</a></td>
                    @else
                        <td class="p-3 px-5">{{ $value }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

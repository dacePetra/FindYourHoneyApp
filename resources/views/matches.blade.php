<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Your Honey Match</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Delete match</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($matchedUsers as $matchedUser)
                        <tr>
                            <td>
                                <a href="/show/{{$matchedUser->id}}">
                                    {{ $matchedUser->name }} {{ $matchedUser->surname }}
                                </a>
                            </td>
                            <td>{{ $matchedUser->email }}</td>
                            <td>
                                <a href="/revert-match/{{$matchedUser->id}}">X</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

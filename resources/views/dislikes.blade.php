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
                            <th scope="col">Disliked people</th>
                            <th scope="col">Delete dislike</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dislikedUsers as $dislikedUser)
                            <tr>
                                <td>
                                    <a href="/show/{{$dislikedUser->id}}">
                                        {{ $dislikedUser->name }} {{ $dislikedUser->surname }}
                                    </a>
                                </td>
                                <td>
                                    <a href="/revert-dislike/{{$dislikedUser->id}}">X</a>
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

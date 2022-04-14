<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2 style="margin-bottom: 30px;">
                        Maximum number of photos in gallery: 4. If you want to upload new picture to your gallery,
                        delete old picture first.
                    </h2>

                    <form method="POST" action="/manage-gallery" id="deleteForm">
                        @csrf

                        @if (count($gallery)==0)
                            <p>Your gallery is empty.</p>
                        @else
                        <table class="table" style="width: 50%">
                            <thead>
                            <tr>
                                <th scope="col">Picture</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($gallery)>=1)
                                <tr>
                                    <td style="width: 80%; height: 80px;">
                                        <img src="/storage/{{$gallery[0]}}" style="width:80%">
                                    </td>
                                    <td style="width: 20%; height: 100px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$gallery[0]}}" name="path1" id="path1">
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (count($gallery)>=2)
                                <tr>
                                    <td style="width: 80%; height: 80px;">
                                        <img src="/storage/{{$gallery[1]}}" style="width:80%">
                                    </td>
                                    <td style="width: 20%; height: 100px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$gallery[1]}}" name="path2" id="path2">
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (count($gallery)>=3)
                                <tr>
                                    <td style="width: 80%; height: 80px;">
                                        <img src="/storage/{{$gallery[2]}}" style="width:80%">
                                    </td>
                                    <td style="width: 20%; height: 100px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$gallery[2]}}" name="path3" id="path3">
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (count($gallery)==4)
                                <tr>
                                    <td style="width: 80%; height: 80px;">
                                        <img src="/storage/{{$gallery[3]}}" style="width:80%">
                                    </td>
                                    <td style="width: 20%; height: 100px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$gallery[3]}}" name="path4" id="path4">
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div>
                            <button type="submit" class="btn btn-outline-dark" name="submit" value="deleteForm">Delete</button>
                        </div>
                    </form>
                    @endif

                    <br>

                    <ul class="nav nav-pills justify-content-center">
                        <li class="nav-item" style="padding-right: 10px; padding-left:10px; padding-top: 10px;">
                            <a class="nav-link active" href="/manage-gallery-upload"> Upload picture </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

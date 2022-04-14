<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    @if (count($gallery)<4)
                        <form method="POST" action="/gallery" enctype="multipart/form-data" id="uploadForm">
                            @csrf

                            <div class="mt-4">
                                <x-label for="picture" style="font-size: larger; margin-bottom: 20px;"> Select picture
                                </x-label>
                                <input type="file" class="form-control-file" name="picture" id="picture">
                            </div>
                            <br>
                            <div>
                                <button type="submit" class="btn btn-outline-dark" name="submit" value="uploadForm">
                                    Upload
                                </button>
                            </div>
                        </form>
                    @else
                        <h2 style="margin-bottom: 30px;">
                            Maximum number of photos in gallery: 4. If you want to upload new picture to your gallery,
                            delete old picture first.
                        </h2>
                        <ul class="nav nav-pills justify-content-center">
                            <li class="nav-item" style="padding-right: 10px; padding-left:10px; padding-top: 10px;">
                                <a class="nav-link active" href="/manage-gallery"> Manage gallery </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

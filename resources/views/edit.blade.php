<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                    <form method="POST" action="{{ route('update') }}" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="name">Name:</label><br>
                            <input type="text" class="form-control rounded shadow" style="width: 30%" id="name" name="name" value="{{ $user->name }}" required><br>
                        </div>

                        <div>
                            <label for="surname">Surname:</label><br>
                            <input type="text" class="form-control rounded shadow" style="width: 30%" id="surname" name="surname" value="{{ $user->surname }}" required><br>
                        </div>

                        <div >
                            <label for="picture">Upload your profile picture:</label><br>
                            <input type="file" class="form-control-file" style="margin-bottom: 20px;" name="picture" id="picture">
                        </div>

                        <div>
                            <label for="location">Location:</label><br>
                            <input type="text" class="form-control rounded shadow" style="width: 30%" id="location" name="location" value="{{ $userProfile->location }}" required><br>
                        </div>

                        <div>
                            <label for="about">About:</label><br>
                            <textarea id="about" class="form-control rounded shadow" style="width: 30%" name="about" required>{{ $userProfile->about }}</textarea><br>
                        </div>

                        <div>
                            <label for="email">E-mail:</label><br>
                            <input type="text" class="form-control rounded shadow" style="width: 30%" id="email" name="email" value="{{ $user->email }}" required><br>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-outline-dark" name="submit">Update</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

</x-app-layout>

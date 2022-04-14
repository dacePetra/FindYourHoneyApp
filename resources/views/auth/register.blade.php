<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <h1 style="font-size: xx-large; font-weight: bold; margin-top: 20px;">FIND YOUR HONEY</h1>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
            <div class="mt-4">
                <x-label for="name" :value="__('Name')"/>

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                         autofocus/>
            </div>


            <!-- Surname -->
            <div class="mt-4">
                <x-label for="surname" :value="__('Surname')"/>

                <x-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')"
                         required autofocus/>
            </div>

            <div class="mt-4">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female" checked>
                <label class="form-check-label" for="female"> Female </label>
                <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                <label class="form-check-label" for="male"> Male </label>
            </div>

            <div class="mt-4">
                <x-label for="birthday"> Birthday</x-label>
                <input type="date" name="birthday" id="birthday" required>
            </div>

            <div class="mt-4">
                <x-label for="picture"> Upload your profile picture</x-label>
                <input type="file" class="form-control-file" name="picture" id="picture">
            </div>

            <div class="mt-4">
                <x-label > Interested in </x-label>
                <input class="form-check-input" type="radio" name="interested_in" id="in_female" value="female" checked>
                <label class="form-check-label" for="in_female"> Female </label>
                <input class="form-check-input" type="radio" name="interested_in" id="in_male" value="male">
                <label class="form-check-label" for="in_male"> Male </label>
                <input class="form-check-input" type="radio" name="interested_in" id="in_both" value="both">
                <label class="form-check-label" for="in_both"> Both </label>
            </div>

            <div class="mt-4">
                <x-label for="location" :value="__('Location')"/>

                <x-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required
                         autofocus/>
            </div>

            <div class="mt-4">
                <x-label for="about" :value="__('About')"/>

                <x-input id="about" class="block mt-1 w-full" type="text" name="about" :value="old('about')" required
                         autofocus/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')"/>

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')"/>

                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="new-password"/>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')"/>

                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation" required/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

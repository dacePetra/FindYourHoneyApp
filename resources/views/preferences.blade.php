<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div style="margin-bottom: 50px;">
                        <h1 style="font-size: x-large">Update your preferences</h1>
                    </div>
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>
                    <form method="POST" action="{{ route('updatePreferences') }}" >
                        @csrf
                        <div class="slidecontainer">
                            <input type="range" min="18" max="118" value="{{$userInterests->age_from}}"
                                   class="slider" id="ageFrom" name="ageFrom" onchange="ageFrom(this.value)"><br>
                            <p>Age from: <span id="ageFromNum"></span></p>
                        </div>
                        <br>
                        <div class="slidecontainer">
                            <input type="range" min="18" max="118" value="{{$userInterests->age_to}}"
                                   class="slider" id="ageTo" name="ageTo" onchange="ageTo(this.value)"><br>
                            <p>Age to: <span id="ageToNum"></span></p>
                        </div>
                        <div>
                            <p style="margin-bottom: 10px;"> Interested in </p>
                            <input class="form-check-input" style="margin-left: 10px; margin-right: 3px;" type="radio" name="interestedIn" id="in_female" value="female">
                            <label class="form-check-label" for="in_female"> Female </label>
                            <input class="form-check-input" style="margin-left: 10px; margin-right: 3px;" type="radio" name="interestedIn" id="in_male" value="male">
                            <label class="form-check-label" for="in_male"> Male </label>
                            <input class="form-check-input" style="margin-left: 10px; margin-right: 3px;" type="radio" name="interestedIn" id="in_both" value="both" checked>
                            <label class="form-check-label" for="in_both"> Both </label>
                        </div>
                        <br>
                        <x-button >
                            {{ __('Update preferences') }}
                        </x-button>
                    </form>

                    <script>
                        var sliderFrom = document.getElementById("ageFrom");
                        var outputFrom = document.getElementById("ageFromNum");

                        outputFrom.innerHTML = sliderFrom.value;

                        sliderFrom.oninput = function () {
                            outputFrom.innerHTML = this.value;
                        }

                        function ageFrom(outputFrom) {
                            return outputFrom;
                        }

                        var sliderTo = document.getElementById("ageTo");
                        var outputTo = document.getElementById("ageToNum");

                        outputTo.innerHTML = sliderTo.value;

                        sliderTo.oninput = function () {
                            outputTo.innerHTML = this.value;
                        }

                        function ageTo(outputTo) {
                            return outputTo;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

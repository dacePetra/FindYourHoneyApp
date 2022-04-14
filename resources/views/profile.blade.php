<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: center;">
                    <img src="/storage/{{ $userProfile->picture }}" alt="profile_picture"
                         class="shadow p-3  bg-body rounded" style="height:auto; display: block; margin-left: auto;
                         margin-right: auto; width: 50%;" >
                    <br>
                    <ul>
                        <li>
                            {{ $user->name }} {{ $user->surname }}
                        </li>
                        <li>
                            {{ $userProfile->gender }}, {{ $userProfile->getAge() }}
                        </li>
                        <li>
                            birthday: {{ $userProfile->birthday }}
                        </li>
                        <li>
                            from {{ $userProfile->location }}
                        </li>
                        <li>
                            <strong>about: {{ $userProfile->about }}</strong>
                        </li>
                        <li>
                            email: {{ $user->email }}
                        </li>
                    </ul>
                    <ul class="nav nav-pills justify-content-center">
                        <li class="nav-item" style="padding-right: 10px; padding-left:10px; padding-top: 10px;">
                            <a class="nav-link active" href="/edit-profile"> Edit profile </a>
                        </li>
                    </ul>
                    <br><br>
                    <h2 style="text-align:center; font-weight: bold; font-size: large">Picture gallery</h2>
                    <br>
                    <div class="row">
                        @if (count($gallery)==0)
                            <p>Your gallery is empty.</p>
                        @endif

                        @if (count($gallery)>=1)
                            <div class="column">
                                <img src="/storage/{{$gallery[0]}}" style="width:100%"
                                     onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
                            </div>
                        @endif

                        @if (count($gallery)>=2)
                            <div class="column">
                                <img src="/storage/{{$gallery[1]}}" style="width:100%"
                                     onclick="openModal();currentSlide(2)" class="hover-shadow cursor">
                            </div>
                        @endif

                        @if (count($gallery)>=3)
                            <div class="column">
                                <img src="/storage/{{$gallery[2]}}" style="width:100%"
                                     onclick="openModal();currentSlide(3)" class="hover-shadow cursor">
                            </div>
                        @endif

                        @if (count($gallery)==4)
                            <div class="column">
                                <img src="/storage/{{$gallery[3]}}" style="width:100%"
                                     onclick="openModal();currentSlide(4)" class="hover-shadow cursor">
                            </div>
                        @endif
                    </div>
                    <br>
                    <ul class="nav nav-pills justify-content-center">
                        <li class="nav-item" style="padding-right: 10px; padding-left:10px; padding-top: 10px;">
                            <a class="nav-link active" href="/manage-gallery"> Manage gallery </a>
                        </li>
                    </ul>

                    <div id="myModal" class="modal">
                        <span class="close cursor" onclick="closeModal()">&times;</span>
                        <div class="modal-content">
                            @if (count($gallery)>=1)
                                <div class="mySlides">
                                    <div class="numbertext">1</div>
                                    <img src="/storage/{{$gallery[0]}}" style="width:100%">
                                </div>
                            @endif

                            @if (count($gallery)>=2)
                                <div class="mySlides">
                                    <div class="numbertext">2</div>
                                    <img src="/storage/{{$gallery[1]}}" style="width:100%">
                                </div>
                            @endif

                            @if (count($gallery)>=3)
                                <div class="mySlides">
                                    <div class="numbertext">3</div>
                                    <img src="/storage/{{$gallery[2]}}" style="width:100%">
                                </div>
                            @endif

                            @if (count($gallery)==4)
                                <div class="mySlides">
                                    <div class="numbertext">4</div>
                                    <img src="/storage/{{$gallery[3]}}" style="width:100%">
                                </div>
                            @endif

                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                        </div>
                    </div>

                    <script>
                        function openModal() {
                            document.getElementById("myModal").style.display = "block";
                        }

                        function closeModal() {
                            document.getElementById("myModal").style.display = "none";
                        }

                        var slideIndex = 1;
                        showSlides(slideIndex);

                        function plusSlides(n) {
                            showSlides(slideIndex += n);
                        }

                        function currentSlide(n) {
                            showSlides(slideIndex = n);
                        }

                        function showSlides(n) {
                            var i;
                            var slides = document.getElementsByClassName("mySlides");
                            var dots = document.getElementsByClassName("demo");
                            var captionText = document.getElementById("caption");
                            if (n > slides.length) {
                                slideIndex = 1
                            }
                            if (n < 1) {
                                slideIndex = slides.length
                            }
                            for (i = 0; i < slides.length; i++) {
                                slides[i].style.display = "none";
                            }
                            for (i = 0; i < dots.length; i++) {
                                dots[i].className = dots[i].className.replace(" active", "");
                            }
                            slides[slideIndex - 1].style.display = "block";
                            dots[slideIndex - 1].className += " active";
                            captionText.innerHTML = dots[slideIndex - 1].alt;
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

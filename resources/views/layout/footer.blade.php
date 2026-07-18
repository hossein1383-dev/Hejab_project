        @php
            $footer = App\Models\Footer::first();
        @endphp

        <!-- footer section -->
        <footer class="footer_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 footer-col">
                        <h4>
                            ساعت کاری
                        </h4>
                        <p>
                            {{ $footer->work_days }}
                        </p>
                        <p>
                            {{ $footer->work_hour_from }}صبح تا {{ $footer->work_hour_to }} شب
                        </p>
                    </div>

                    <div class="col-md-4 footer-col">
                        <div class="footer_detail">
                            <a href="" class="footer-logo">
                                {{ $footer->title }}
                            </a>
                            <p>
                                {{ $footer->body }}
                            </p>
                            <div class="footer_social">
                                {{-- <a href={{ $footer->telegram_link }}>
                                    <i class="bi bi-telegram"></i>
                                </a>
                                <a href={{ $footer->whatsapp_link }}>
                                    <i class="bi bi-whatsapp"></i> --}}
                                </a>
                                <a href={{ $footer->instagram_link }}>
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href={{ $footer->eitaa_link }}>
                                    <img src="{{ '/images/eitaa.svg' }}" width="24" height="24" alt="Eitaa">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 footer-col">
                        <div class="footer_contact">
                            <h4>
                                تماس با ما
                            </h4>
                            <div class="contact_link_box">
                                <a href="">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>
                                        {{ $footer->contact_address }}
                                    </span>
                                </a>
                                <a href="">
                                    <div class="d-flex justify-content-center">
                                        <i class="bi bi-telephone-fill" aria-hidden="true"></i>
                                        <p class="my-0" style="direction: ltr;">
                                            {{ $footer->contact_phone }}
                                        </p>
                                    </div>
                                </a>
                                <a href="">
                                    <i class="bi bi-envelope-fill"></i>
                                    <span>
                                        {{ $footer->contact_email }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-info">
                    <p>
                        {{ $footer->copyright }}
                    </p>
                </div>
            </div>
        </footer>
        <!-- footer section -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>



        @yield('script')
        </body>

        </html>

<script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{asset('assets/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap/bootstrap.js')}}"></script>
<!-- feather icon js-->
<script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- Sidebar jquery-->

<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<!-- Plugins JS start-->
@yield('script')
<script src="{{asset('assets/js/tooltip-init.js')}}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset('assets/js/script.js')}}"></script>
<script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/easytimer@1.1.1/src/easytimer.min.js"></script>
<script>
    // Allowed keypress numbers
    const keyPressedNumbersAllowed = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '+'];

    let count = 0;
    $(".digit").on('click', function () {
        let num = ($(this).clone().children().remove().end().text());
        if (count < 14) {
            $("#output").append('<span>' + num.trim() + '</span>');
            count++
        }
    });

    document.addEventListener('keydown', (event) => {
        let code = event.key;
        // Numbers 0-9
        if (keyPressedNumbersAllowed.includes(code)) {
            if (count < 14) {
                $("#output").append(`<span>${code}</span>`);
                count++
            }
        }

        if (code == 'Backspace') {
            $('#output span:last-child').remove();
            count--;
        }

    }, false);

    $("#emptyField").on('click', function () {
        $('#output span').remove();
        count = 0;
    });

    $('.fa-long-arrow-left').on('click', function () {
        $('#output span:last-child').remove();
        count--;
    });

    $(document).ready(function () {
        let timer = new Timer();
        let timeoutCall

        function notify(message, type, icon) {
            $.notify({
                    icon: icon,
                    message: message
                },
                {
                    type: type,
                    allow_dismiss: true,
                    newest_on_top: true,
                    mouse_over: true,
                    spacing: 10,
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    offset: {
                        x: 30,
                        y: 30
                    },
                    delay: 1000,
                    z_index: 10000,
                    animate: {
                        enter: 'animated bounce',
                        exit: 'animated bounce'
                    }
                });
        }

        $('#click2call').on('click', function (e) {
            e.preventDefault();
            let phonenumber = $('#output').text()
            console.log(phonenumber)
            $.ajax({
                url: "{{ route('click2call') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "phonenumber": phonenumber
                },
                success: function (response) {
                    notify(response['message'], response['type']);
                    clearTimeout(timeoutCall);
                    //markPresent();
                    timer.reset();
                    timer.start()
                },
                error: function () {
                    notify('Something Wrong!', 'danger');
                }
            });
        });

        $('#endCall').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('click2hang') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    notify(response['message'], response['type']);
                    localStorage.removeItem("radialAloTechKeys");
                    $(".customizer-contain").toggleClass('');
                    timer.stop();
                    localStorage.removeItem("time_stored_seconds");
                    localStorage.removeItem("leadNameRadialStore");
                    //clearTimeout(timeoutCall);
                },
                error: function (response) {
                    notify(response['message'], response['type']);
                }
            });
        });

        document.getElementById('search-value-header').addEventListener('keypress', function (event) {
            if (event.keyCode == 13) {
                let input = this.value
                $.ajax({
                    type: "POST",
                    url: '{{ route('autocomplete.fetch') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        client_search: input
                    },
                    success: function (res) {
                        let data = $.parseJSON(res);
                        $('#searchModal').modal('show');
                        $(".search-content-result").html('');
                        $('.search-content-result').append(data);
                    }
                });
                event.preventDefault();
            }
        })
        $(".customizer-contain").addClass(localStorage.getItem('radialAloTechKeys'));

        window.addEventListener('radial-status', event => {
            if (localStorage.getItem("radialAloTechKeys") === null) {
                localStorage.setItem('radialAloTechKeys', event.detail.radialStatus);
                if ($(".customizer-contain").hasClass("open")) {
                } else {
                    $(".customizer-contain").toggleClass('open');
                }
                $('#leadNameForDeal').html(event.detail.leadNameRadial)
                localStorage.setItem('leadNameRadialStore', event.detail.leadNameRadial);
                timer.start();
            }
        })

        let timeTotal = $('#call-timer'),
            timeKey = 'time_stored_seconds',
            timeStored = localStorage.getItem(timeKey);

        // Update Event
        timer.addEventListener('secondsUpdated', function (e) {
            let newValue = parseInt(localStorage.getItem(timeKey) | 0) + 1
            localStorage.setItem(timeKey, newValue);
            $(timeTotal).html(timer.getTimeValues().toString());
        });

        // Started Event
        timer.addEventListener('started', function (e) {
            $(timeTotal).html(timer.getTimeValues().toString());
        });

        // reset Event
        timer.addEventListener('reset', function (e) {
            $(timeTotal).html(timer.getTimeValues().toString());
        });

        if (timeStored) {
            timeTotal.text(timeStored);
        } else {
            localStorage.setItem(timeKey, 0);
            timeStored = 0
        }
        @if(Session::has('current_call'))
        timer.start({precision: 'seconds', startValues: {seconds: parseInt(timeStored)}});
        $('#leadNameForDeal').html(localStorage.getItem('leadNameRadialStore'))
        @endif
    })
</script>
<!-- Plugin used -->
@yield('script_after')
@include('sweetalert::alert')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>


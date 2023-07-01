<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="{{asset('/css/vcrun/style.css')}}" rel="stylesheet">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <title>Vice Chancellor Run</title>
</head>
<body>
    <!-- CONTAINER -->

    <div class="d-flex g-0 gy-0 min-vh-100 w-100">
        <div class="row p-0 m-0 gx-0 min-vw-100">
            <!-- TITLE -->
            <div class="col-lg-5 d-none d-lg-block min-vh-100 mx-0 px-0">
                <div id="title-container">
                    <img class="strathmore-image"
                        src="https://strathmore.edu/wp-content/themes/michigan/images/logo.png" alt="Logo">

                    <h2>Register to Participate</h2>
                    <br>
                    <h3>Days Left</h3>
                    <br>
                    <h2 id="daysLeft"></h2>
{{--                    <h3>Sponsors</h3>--}}
{{--                    <img height="200" src="{{ asset("images/orchard.png") }}" alt="ochard">--}}
                </div>
        </div>
            <!-- FORMS -->
            <div class="col-lg-7 min-vh-100 qbox-container mx-0 px-0">
                <div class="progress">
                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="50"
                        class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
                        style="width: 0%"></div>
                </div>
                <div id="qbox-container" class="p-0">
                    <form class="needs-validation" id="form-wrapper" method="post" name="form-wrapper" novalidate>
                        <!-- STEPS HERE -->
                        <div class="ps-0 q-box">
                            <div class="card">
                                <div class="card-header">
                                    Currency Options
                                    <select class="form-select" id="amountCurrency">
                                        @foreach($pageBo->allowedCurrencies as $currency)
                                            @if($currency->currency_code === 'KES')
                                                <option value="{{ $currency->currency_code }}">Kenya shillings (KES)</option>
                                            @elseif($currency->currency_code === 'USD')
                                                <option value="{{ $currency->currency_code }}">US dollars (USD)</option>
                                            @else
                                                <option value="{{ $currency->currency_code }}">{{ $currency->currency_code }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- participation section --}}
                                <div class="card-body">
                                    <h5 class="card-title">How would you like to participate?</h5>
                                    <div class="input-group">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col">
                                                    <input class="form-check-input question__input" id="partPhysical"
                                                           name="participation" type="radio" value="partPhysical" required>
                                                    <label class="form-check-label question__label"
                                                           for="partPhysical">Physically</label>
                                                </div>
                                                <div class="col">
                                                    <input class="form-check-input question__input" id="partVirtual"
                                                           name="participation" type="radio" value="partVirtual">
                                                    <label class="form-check-label question__label" for="partVirtual">Virtually</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--End Participation Section--}}
                                    {{--Student Section--}}
                                    <div class="input-group" style="padding-top: 10px;">
                                        <h5 class="card-title">Are you a student</h5>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col">
                                                    <input class="form-check-input question__input" name="student" id="isStudent" type="radio" value="1" required onclick="showStudentNumberForm()">
                                                    <label class="form-check-label question__label" for="isStudent">Yes</label>
                                                </div>
                                                <div class="col">
                                                    <input class="form-check-input question__input" name="student" id="isNotStudent" type="radio" value="0" onclick="hideStudentNumberForm()">
                                                    <label class="form-check-label question__label" for="isNotStudent">No</label>
                                                </div>
                                            </div>

                                            <div id="studentNumberForm" style="display: none;">
                                                <h5 class="card-title">Enter your student number</h5>
                                                <div class="input-group">
                                                <input type="text" aria-label="studentNumber" class="form-control"
                                                       placeholder="123456" id="studentNumber" >
                                                <div class="invalid-feedback">
                                                    Enter a valid Student Number
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function showStudentNumberForm() {
                                            document.getElementById("studentNumberForm").style.display = "block";
                                        }

                                        function hideStudentNumberForm() {
                                            document.getElementById("studentNumberForm").style.display = "none";
                                        }
                                    </script>

                                    {{-- Number of kilometers section --}}
                                    <div class="input-group" style="padding-top: 10px;">
                                        <h5 class="card-title">Number of Kilometers</h5>
                                        <div class="container">
                                            <div class="row">

                                                <div class="col">
                                                    <input class="form-check-input question__input" id="noKm21"
                                                           name="noKM" type="radio" value="21km">
                                                    <label class="form-check-label question__label"
                                                           for="noKm21">21 KM</label>
                                                </div>
                                                <div class="col">
                                                    <input class="form-check-input question__input" id="noKm10"
                                                           name="noKM" type="radio" value="10km" required>
                                                    <label class="form-check-label question__label"
                                                           for="noKm10">10 KM</label>
                                                </div>
                                                <div class="col">
                                                    <input class="form-check-input question__input" id="noKm5"
                                                           name="noKM" type="radio" value="5km" required>
                                                    <label class="form-check-label question__label"
                                                           for="noKm5">5 KM Run/Walk</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- Amount section --}}
                                    <small class="input-group" style="padding-top: 10px;">
                                        Amount<br>
                                        <small>- - minimum amount is KES 1,000 for students and KES 1500 for others, but you can give more!</small>
                                    </small>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><h6 id="currencyOption1"></h6></span>
                                                        </div>
                                                        <input type="number" class="form-control" placeholder="Amount"
                                                               id="amountVC" aria-label="amount"
                                                               aria-describedby="basic-addon1" />
                                                        <div class="invalid-feedback">
                                                            <p style="color: red" id="amountValueValidator"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                {{-- information section --}}
                                    <div class="container">
                                        <h5 class="card-title">Your Information</h5>
                                        <div class="input-group">
                                            <input type="text" aria-label="Name" class="form-control is-invalid" name="username"
                                                   placeholder="Name (first and last names)" id="username">
                                            <div class="invalid-feedback">
                                                Enter a valid name
                                            </div>
                                        </div>
                                        <br>
                                            <div class="card">
                                            <div class="card-header">
                                            Shirt Size
                                            </div>
                                            <div class="input-group">
                                                <select class="form-select" id="shirtSize">
                                                <option value="S">Small</option>
                                                <option value="M" selected>Medium</option>
                                                <option value="L">Large</option>
                                                <option value="XL">Extra Large</option>
                                                <option value="XXL">XXL</option>
                                            </select>
                                        </div>
                                        <br>

                                        <div class="input-group">
                                            <input type="email" aria-label="Email" class="form-control"
                                                   placeholder="Email (for communication purposes)" id="email">
                                            <div class="invalid-feedback">
                                                Enter a valid email
                                            </div>
                                            <br>
                                            <input type="text" aria-label="Phonenumber" class="form-control"
                                                   placeholder="Phonenumber (Optional)" id="phonenumber">


                                        </div>
                                        <br>

                                        Relation
                                        @foreach ($pageBo->relations as $item)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="relation" name="relation" id="{{$item->relation_name}}" value="{{$item->relation_name}}">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    {{$item->relation_name}}
                                                </label>
                                            </div>
                                        @endforeach


                                    </div>

                                    {{-- Payment Section --}}
                                    <div class="input-group" style="justify-content: center">
                                        <button class="awesome-checkout-button" type="button"></button>
                                    </div>

{{--                                    <h5 class="card-title">Minimum Registration Amount: </h5><h4 id="registrationCost1">KES {{number_format(setting(\App\Setting::REGISTRATION_AMOUNT,1000))}}</h4> --}}
                                </div>
{{--                            </div>--}}



                        <br>
                        <hr>
                        <div class="q-box__question">
                            <div class="form-check">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Click here to Learn More
                                </button>

                                <!-- Button trigger modal -->

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Participation Options</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body" style="padding: 20px;">
                                                <p style="font-size: 18px; margin-bottom: 10px;">You can register to participate in the:</p>
                                                <ol style="list-style-type: upper-roman; padding-left: 20px;">
                                                    <li style="font-size: 16px; margin-bottom: 10px; color: black;">21 Kilometers Run</li>
                                                    <li style="font-size: 16px; margin-bottom: 10px; color: black;">10 Kilometers Run</li>
                                                    <li style="font-size: 16px; margin-bottom: 10px; color: black;">5 Kilometers Run</li>
                                                </ol>
                                                <h4 style="font-size: 18px; margin-top: 20px; margin-bottom: 5px; color: black;">The Registration Costs:</h4>
                                                <h4 id="registrationCost" style="font-size: 24px; font-weight: bold; color: goldenrod;"></h4>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
    <div id="preloader-wrapper">
        <div id="preloader"></div>
        <div class="preloader-section section-left"></div>
        <div class="preloader-section section-right"></div>
    </div>




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    {{-- <script src="/js/vcrun/script.js"></script> --}}
    <script src="{{ $pageBo->expressCheckoutUrl }}"></script>
    <script>
        var currencies = @json($pageBo->allowedCurrencies->pluck('exchange_rate','currency_code'));
        var registrationAmount = {{setting(App\Models\Setting::REGISTRATION_AMOUNT,1000)}}
        $("input[name=participation][value='partPhysical']").prop("checked",true);
        $("input[name=noKM][value='21km']").prop("checked",true);
        $("input[name=relation][value='Friend']").prop("checked",true);

        if($('#amountCurrency').val()==='KES'){
                $('#amountVC').val(registrationAmount);
            }else{
                var currencyCode = $('#amountCurrency').children("option:selected").val();
                var conversion = currencies[currencyCode];
                $('#amountVC').val(parseFloat(registrationAmount)/parseFloat(conversion));
            }

        //amount validator

        function amountValidator(){
            if($('#amountCurrency').val()==='KES'){

                    if($('#amountVC').val()<registrationAmount){
                        //console.log('Less than Ksh 1000');
                        $('#amountVC').addClass("is-invalid");
                        $('#amountVC').removeClass("is-valid");
                        $('#amountValueValidator').show();
                        $('#amountValueValidator').html('Vice Chancellor\'s Run contributions must be above '+registrationAmount+' KES').addClass("error-msg");
                        return false;
                    }
                    else{
                        $('#amountVC').addClass("is-valid");
                        $('#amountVC').removeClass("is-invalid");
                        $('#amountValueValidator').hide();
                        $('#amountValueValidator').removeClass('error-msg');
                        return true;
                    }
                }else if($('#amountCurrency').val()==='USD'){
                    var currencyCode = $('#amountCurrency').children("option:selected").val();
                    var conversion = currencies[currencyCode];
                    if($('#amountVC').val()<parseFloat(registrationAmount)/parseFloat(conversion)){
                        //console.log('Less than Ksh 1000');
                        $('#amountVC').addClass("is-invalid");
                        $('#amountVC').removeClass("is-valid");
                        $('#amountValueValidator').show();
                        $('#amountValueValidator').html('Vice Chancellor\'s Run contributions must be above '+Math.ceil(parseFloat(registrationAmount)/parseFloat(conversion))+' USD').addClass("error-msg");
                        return false;
                    }
                    else{
                        $('#amountVC').addClass("is-valid");
                        $('#amountVC').removeClass("is-invalid");
                        $('#amountValueValidator').hide();
                        $('#amountValueValidator').removeClass('error-msg');
                        return true;
                    }
                }
        }

        $('#amountVC').on('change',function(){
            amountValidator();
        });
        $('#amountVC').on('keyup',function(){
            amountValidator();
        });
        $('#amountVC').mouseout(function(){
            amountValidator();
        });

        //name validator
        $('#username').on('keyup',function(){
            NameValidator();
        });
        $('#username').mouseout(function(){
            NameValidator();
        });
        function NameValidator(){
            if($('#username').val() == null || $('#username').val() ===""){
                $('#username').addClass("is-invalid");
                $('#username').removeClass("is-valid");
                return false;
            }else{
                $('#username').addClass("is-valid");
                $('#username').removeClass("is-invalid");
                return true;
            }
        }

        function proceedToPayment(){
            if(NameValidator()&&amountValidator()&&emailValidator()){
                return true;
            }
            else{
                return false;
            }
        }



        $(document).ready(function() {
            $('.js-example-basic-single').select2({theme: 'bootstrap4'});
        });
        var donorDetails = @json($pageBo->donorDetails, JSON_PRETTY_PRINT);
        var payload = {
            "method": "post",
            "headers": {
                "Content-type": "application/json; charset=UTF-8"
            },
            "body": @json($pageBo->cellulantExpressCheckoutRequestBodyPayload, JSON_PRETTY_PRINT)
        };
        Tingg.renderPayButton({
            className: 'awesome-checkout-button',
            checkoutType: 'redirect'
        });

        function pickDetails() {
            var totalAmount = getTotalAmount();
            donorDetails.firstName = $('#username').val();
            donorDetails.lastName = ''
            donorDetails.company = ''
            donorDetails.country = '';
            donorDetails.jobTitle = '';
            donorDetails.graduatingClass = '';
            donorDetails.city = '';
            donorDetails.email = $('#email').val();
            donorDetails.zipCode = '';
            donorDetails.currency = $('#amountCurrency').children("option:selected").val();
            donorDetails.salutation = '';
            donorDetails.phoneNumber = $('#phonenumber').val();
            donorDetails.merchantID = payload.body.merchantTransactionID;
            donorDetails.campaign = 'Vice Chancellor\'s Campaign' ;

            donorDetails.requestDescription = 'Vice Chancellor\'s Campaign';

            donorDetails.relation = $('input[name="relation"]:checked').val();
            saveSponsoredUsers();

            payload.body.currencyCode = $('#amountCurrency').children("option:selected").val();
            payload.body.requestAmount = totalAmount.toString();
            payload.body.customerEmail = $('#email').val();
            payload.body.MSISDN = $('#phoneNumber').val();
            payload.body.customerFirstName = $('#firstName').val();
            payload.body.customerLastName = $('#lastName').val();
            payload.body.requestDescription = 'VC Campaign'

            return true;
        }

        function saveSponsoredUsers(){
            var registrationType;
            donorDetails.donationBreakdown=[];
            var raceKms;
            var amountvalue=$('#amountVC').val()

            if($('#input[name=noKM]:checked').val()==='18km'){
                raceKms=18;
            }else{
                raceKms=5;
            }

            if($('input[name=participation]:checked').val()==='partPhysical'){
                donorDetails.raceKms=raceKms;
                donorDetails.registrationType="PHYSICAL";
                const obj={merchantId: 'REGISTRATION',amount: amountvalue};
                donorDetails.donationBreakdown.push(obj);
            }else{
                donorDetails.raceKms=raceKms
                donorDetails.registrationType="VIRTUAL";
                const obj={merchantId: 'REGISTRATION',amount: amountvalue};
                donorDetails.donationBreakdown.push(obj);
            }


            // //set Registration type
            // if($('input[name="participation"]:checked').val() == "partAny")
            // {
            //     donorDetails.registrationType=null;
            // }else
            // if($('input[name="participation"]:checked').val() == "partPhysical"){
            //     donorDetails.raceKms=parseFloat($('#numberOfKilometers option:selected').val());
            //     donorDetails.registrationType="PHYSICAL";
            //     const obj={merchantId: 'REGISTRATION',amount: null};
            //     donorDetails.donationBreakdown.push(obj);
            // }
            // else{
            //     donorDetails.raceKms=parseFloat($('#numberOfKilometers option:selected').val());
            //     donorDetails.registrationType="VIRTUAL";
            //     const obj={merchantId: 'REGISTRATION',amount: null};
            //     donorDetails.donationBreakdown.push(obj);
            // }

            // //set supported array
            // if($('#supportVc').is(":checked"))
            // {
            //     var vcAmount=parseFloat($('#sponsorVcAmountValue').val());
            //     const obj={merchantId: 'VC',amount: vcAmount};
            //     donorDetails.donationBreakdown.push(obj);
            // }
            // if($('#supportAnother').is(":checked")){
            //     //check user sponsored merchant id
            //     var sponsorAnyAmount=parseFloat($('#sponsorParticipantAmountValue').val());
            //     const obj2={merchantId: $('#vCparticipants').val(),amount: sponsorAnyAmount};
            //     donorDetails.donationBreakdown.push(obj2);
            // }
            // if($('input[name="participation"]:checked').val() == "partAny")
            // {
            //     var anyAmount=parseFloat($('#anyAmount').val());
            //     const obj3 = {merchantId: null,amount: anyAmount,};
            //     donorDetails.donationBreakdown.push(obj3);
            // }

            //GET raceKm


        }

        function getTotalAmount() {
            var currencyCode = $('#amountCurrency').children("option:selected").val();
            var conversion = currencies[currencyCode];
            var amount = $('#amountVC').val();
            return amount;
        }

        $('.awesome-checkout-button').on('click',
            function() {
            // console.log(JSON.stringify(donorDetails));
            if(proceedToPayment()){

                if (pickDetails()) {
                    console.log(JSON.stringify(donorDetails));
                    fetch("{{url('/api/saveVcRunDonationRequest')}}", {
                    //console.log(donorDetails);
                        "method": "POST",
                        "headers": {
                            "Content-type": "application/json; charset=UTF-8"
                        },
                        "body": JSON.stringify(donorDetails)
                    })
                    .then(responce => responce)
                    .then(function (data) {
                        fetch("{{url('/api/encrypt/'.$pageBo->donationCode)}}", {
                            "method": "POST",
                            "headers": {
                                "Content-type": "application/json; charset=UTF-8"
                                // "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                            },
                            "body": JSON.stringify(payload)
                        })
                        .then(response => response.json())
                        .then(function (data) {
                            Tingg.renderCheckout({
                                merchantProperties: {
                                    params: data.params,
                                    accessKey: "{{ $pageBo->accessKey }}",
                                    countryCode: "{{ $pageBo->cellulantExpressCheckoutRequestBodyPayload->countryCode }}"
                                },
                                checkoutType: "{{setting(\App\Models\Setting::CHECKOUT_TYPE, 'redirect')}}" // or ‘modal’
                            });
                        })
                        .then(function (error) {
                        });
                    })
                    .then(function () {
                        //console.log(data);
                    });
                    }
            }

            });
    </script>



    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("May 27, 2023 7:00:00").getTime();

        // Update the count down every 1 second
        var x = setInterval(function () {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("daysLeft").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("daysLeft").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>

    <script>
        let step = document.getElementsByClassName('step');
let prevBtn = document.getElementById('prev-btn');
let nextBtn = document.getElementById('next-btn');
let submitBtn = document.getElementById('submit-btn');
let form = document.getElementsByTagName('form')[0];
let preloader = document.getElementById('preloader-wrapper');
let bodyElement = document.querySelector('body');
let succcessDiv = document.getElementById('success');

form.onsubmit = () => {
    return false
}
let current_step = 0;
let stepCount = 1

const progress = (value) => {
    document.getElementsByClassName('progress-bar')[0].style.width = `${value}%`;
}
/*
nextBtn.addEventListener('click', () => {
    if(current_step==0){
        if(validateParticipation()){
            nextStep();
        }
    }else
    if(current_step==1){
        if(validateSponsorVc()){
            nextStep();
        }
    }else if(current_step==2){
        if(personalInformation()){
            nextStep();
            showTotalAmount();
        }
    }
    else if(current_step==3){
        showTotalAmount();
        console.log('here');
    }
    function nextStep(){
        current_step++;
        let previous_step = current_step - 1;
        if ((current_step > 0) && (current_step <= stepCount)) {
            prevBtn.classList.remove('d-none');
            prevBtn.classList.add('d-inline-block');
            step[current_step].classList.remove('d-none');
            step[current_step].classList.add('d-block');
            step[previous_step].classList.remove('d-block');
            step[previous_step].classList.add('d-none');
            if (current_step == stepCount) {

                nextBtn.classList.remove('d-inline-block');
                nextBtn.classList.add('d-none');
            }
        } else {
            if (current_step > stepCount) {
                //showTotalAmount();
                form.onsubmit = () => {
                    return true
                }
            }
        }
        progress((100 / stepCount) * current_step);
    }

});


prevBtn.addEventListener('click', () => {
    if (current_step > 0) {
        current_step--;
        let previous_step = current_step + 1;
        prevBtn.classList.add('d-none');
        prevBtn.classList.add('d-inline-block');
        step[current_step].classList.remove('d-none');
        step[current_step].classList.add('d-block')
        step[previous_step].classList.remove('d-block');
        step[previous_step].classList.add('d-none');
        if (current_step < stepCount) {
            //submitBtn.classList.remove('d-inline-block');
            //submitBtn.classList.add('d-none');
            nextBtn.classList.remove('d-none');
            nextBtn.classList.add('d-inline-block');
            prevBtn.classList.remove('d-none');
            prevBtn.classList.add('d-inline-block');
        }
    }

    if (current_step == 0) {
        prevBtn.classList.remove('d-inline-block');
        prevBtn.classList.add('d-none');
    }
    progress((100 / stepCount) * current_step);
});*/

function showTotalAmount(){
    amount=getTotalAmount();
    console.log(amount);
    if($('#amountCurrency').children("option:selected").val()==='KES'){
        $('#totalAmountDiv').text('Ksh '+amount);
    }
    else{
        $('#totalAmountDiv').text('$ '+amount);
    }
}

//Select default Currency
function selectDefaultCurrency()
{
    //1 usd = 115.85 ksh
    var currencyCode = $('#amountCurrency').children("option:selected").val();
    var conversion = currencies[currencyCode];
    var usdRate = currencies['USD'];
    $('#currencyOption').text(currencyCode);
    $('#currencyOption1').text(currencyCode);
    $('#currencyOption3').text(currencyCode);

    $('#registrationCost').text(currencyCode+' '+ Math.ceil(registrationAmount/parseFloat(conversion)))
    $('#registrationCost1').text(currencyCode+' '+ Math.ceil(registrationAmount/parseFloat(conversion)))
    if($('#amountCurrency').children("option:selected").val()==='KES')
    {
        //check if there are input fields with data
        var amount = parseFloat($('#anyAmount').val())
        if(!$('#anyAmount').val() ||amount>1)
        {
            $('#anyAmount').val(Math.ceil(amount*parseFloat(usdRate)));
        }

        var amount1 = parseFloat($('#sponsorVcAmountValue').val())
        if(!$('#sponsorParticipantAmountValue').val() ||amount1>1)
        {
            $('#sponsorVcAmountValue').val(Math.ceil(amount*parseFloat(usdRate)));
        }

        var amount2 = parseFloat($('#sponsorParticipantAmountValue').val())
        if(!$('#sponsorParticipantAmountValue').val() ||amount2>1)
        {
            $('#sponsorParticipantAmountValue').val(Math.ceil(amount*parseFloat(usdRate)));
        }



    }else{
        var amount = parseFloat($('#anyAmount').val())
        if(!$('#anyAmount').val() ||amount>1)
        {
            $('#anyAmount').val(Math.ceil(amount/parseFloat(usdRate)));
        }

        var amount1 = parseFloat($('#sponsorVcAmountValue').val())
        if(!$('#sponsorVcAmountValue').val() ||amount1>1)
        {
            $('#sponsorVcAmountValue').val(Math.ceil(amount1/parseFloat(usdRate)));
        }

        var amount2 = parseFloat($('#sponsorParticipantAmountValue').val())
        if(!$('#sponsorParticipantAmountValue').val() ||amount2>1)
        {
            $('#sponsorParticipantAmountValue').val(Math.ceil(amount2/parseFloat(usdRate)));
        }
    }
}


//Form validation

//START OF PART ONE ** Participation Section ** //
function validateParticipation()
{
    if ($('input[name=participation]:checked').length > 0) {
        // do something here
        $('#partPhysical').removeClass("is-invalid");
        //return true;
        //check if the value selected is the last option
        if($('input[name="participation"]:checked').val()=="partAny"){
            $('#anyParticipationAmount').show();
            var amount = parseFloat($('#anyAmount').val());
            if(!$('#anyAmount').val() ||amount  < 0){
                $('#anyAmount').addClass("is-invalid");
                $('#anyAmount').removeClass("is-valid");
                return false;
            }else{
                $('#anyAmount').removeClass("is-invalid");
                return true;
            }

        }else if($('input[name="participation"]:checked').val()==="partPhysical"){
            $('#noKilometersCard').show();
            if($('#numberOfKilometers option:selected').val()==='none'){
                $('#numberOfKilometers').addClass("is-invalid");
                return false;
            }else{
                $('#numberOfKilometers').removeClass("is-invalid");
                return true;
            }
        }else if($('input[name="participation"]:checked').val()==="partVirtual"){
            $('#noKilometersCard2').show();
            if($('#numberOfKilometers2 option:selected').val()==='none'){
                $('#numberOfKilometers2').addClass("is-invalid");
                return false;
            }else{
                $('#numberOfKilometers2').removeClass("is-invalid");
                return true;
            }
        }
    }else{
        $('#partPhysical').addClass("is-invalid");
        $('#partPhysical').removeClass("is-valid");
        return false;
    }

}

$('input[name="participation"]').on('change',function(){
    validateParticipation();
    if($('input[name="participation"]:checked').val()==="partAny"){
        $('#anyParticipationAmount').show();
    }else{
        $('#anyParticipationAmount').hide();
    }

    if($('input[name="participation"]:checked').val()==="partPhysical"){
        $('#noKilometersCard').show();
    }else{
        $('#noKilometersCard').hide();
    }

    if($('input[name="participation"]:checked').val()==="partVirtual"){
        $('#noKilometersCard2').show();
    }else{
        $('#noKilometersCard2').hide();
    }
});

//END OF PART ONE ** Participation Section ** //

//START OF PART TWO ** Sponsor VC Section ** //

function validateSponsorVc(){
    if($('#supportVc').is(":checked")){
        var amount = parseFloat($('#sponsorVcAmountValue').val());
        if(!$('#sponsorVcAmountValue').val() ||amount  < 0){
            $('#sponsorVcAmountValue').addClass("is-invalid");
            $('#sponsorVcAmountValue').removeClass("is-valid");
            return false;
        }else{
            $('#sponsorVcAmountValue').removeClass("is-invalid");
            return true;
        }
    }else if($('#supportAnother').is(":checked")){
        var amount = parseFloat($('#sponsorParticipantAmountValue').val());
        if(!$('#sponsorParticipantAmountValue').val() ||amount  < 0 ||$('#vCparticipants option:selected').val()==='none'){
            if($('#vCparticipants option:selected').val()==='none'){
                $('#vCparticipants').addClass("is-invalid");
                $('#sponsorParticipantAmountValue').addClass("is-invalid");
                return false;
            }else{
                $('#vCparticipants').removeClass("is-invalid");

                if (!$('#sponsorParticipantAmountValue').val() ||amount  < 0) {
                    $('#sponsorParticipantAmountValue').addClass("is-invalid");
                    return false;
                }
                else{
                    $('#sponsorParticipantAmountValue').addClass("is-valid");
                    return true;
                }
            }

        }else{
            $('#sponsorParticipantAmountValue').removeClass("is-invalid");
            return true;
        }
    }else{
        return true;
    }
}

$('input[name="supportVc"]').on('change',function(){
    validateSponsorVc();
    if($('#supportVc').is(":checked")){
        $('#sponsorVcAmount').show();
    }else{
        $('#sponsorVcAmount').hide();
    }
});

$('input[name="supportAnother"]').on('change',function(){
    validateSponsorVc();
    if($('#supportAnother').is(":checked")){
        $('#sponsorAnyAmount').show();
    }else{
        $('#sponsorAnyAmount').hide();
    }
});

//End OF PART TWO ** Sponsor Section ** //


//START OF PART THREE ** Sponsor Anyone Section ** //
function personalInformation(){
    if($('#firstName').val() === null | $('#firstName').val() === ""){
        firstNameValidator()
        return false;

    }
    if($('#lastName').val() === null | $('#lastName').val() === ''){
        lastNameValidator();
         return false;

    }
    if($('#email').val() === null | $('#email').val() === ''){
        emailValidator();
        return false;

    }
    if($('#phonenumber').val() === null | $('#phonenumber').val() === ''){
        return false;
    }
    return true;
}


$('#email').on('keyup',function(){
    emailValidator();
});
$('#email').mouseout(function(){
    emailValidator();
});
function emailValidator(){
    var emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if($('#email').val() === null || $('#email').val() === ""){
        $('#email').addClass("is-invalid");
        $('#email').removeClass("is-valid");
        return false
    }else{
        if($('#email').val().match(emailRegex)) {
            $('#email').addClass("is-valid");
            $('#email').removeClass("is-invalid");
            return true;
        } else {
            $('#email').addClass("is-invalid");
            $('#email').removeClass("is-valid");
            return false;
        }
    }
}


$(function() {
    selectDefaultCurrency();
    var rel =  $('#relation').children("option:selected").attr('showText');
    if(rel ==='1'){
        $('#graduationClassDiv').show();
    } else {
        $('#graduationClassDiv').hide();
    }


});

$('#amountCurrency').on('change',function(){
    selectDefaultCurrency();
});

    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    <a href="{{ url('/admin') }}" style="text-decoration: none; color: #000; padding: 10px 20px; border-radius: 5px; font-size: 14px;">Go to Admin Panel</a>
</body>
</html>

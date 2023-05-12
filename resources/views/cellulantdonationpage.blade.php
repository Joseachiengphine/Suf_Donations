<!doctype html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="public/css/selectstyle.css" />
    <link rel="stylesheet" href="/css/paymentsPage.css" />
    <title>{{ $pageBo ? $pageBo->pageTitle :''}}</title>

  </head>
  <body>

  <div class="container-fluid">
      <div id="giftSection">
          <h3 class="sectionTitle">Gift Details</h3>
          <form>
              <div class="mb-3 row">
                  <label class="col-sm-2" for="amount">Amount</label>
                  <div class="col-sm-5">
                      <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon1">Ksh</span>
                          <input type="text" class="form-control rounded" id="amount" aria-describedby="amountHelp" placeholder="1000.00">
                      </div>
                      <p style="color: red" id="amountValueValidator"></p>
                  </div>

                  <div class="col-sm-2">
                      <select class="form-select" id="amountCurrency" style="width: 300px;">
                          @foreach($pageBo->allowedCurrencies as $currency)
                              @if($currency->currency_code === 'KES')
                                  <option value="{{ $currency->currency_code }}">Kenya Shillings (KES)</option>
                              @elseif($currency->currency_code === 'USD')
                                  <option value="{{ $currency->currency_code }}">US dollars (USD)</option>
                              @else
                                  <option value="{{ $currency->currency_code }}">{{ $currency->currency_code }}</option>
                              @endif
                          @endforeach
                      </select>
                  </div>

              </div>
              <div id="campaignClassDiv" class="mb-3 row">
                  <label class="col-sm-2" for="campaign">Campaign</label>
                  <div class="col-sm-5">

                      <select class="form-select" id="campaign">
                          @foreach($pageBo->campaigns as $campaign)
                              @if ($campaign->display_narative_box == true)
                                  @if ($campaign->default_option == true)
                                      <option value="{{ $campaign->campaign_name }}" active showDescription selected showText="{{ $campaign->display_narative_box }}">{{ $campaign->campaign_name }}</option>
                                  @else
                                      <option value="{{ $campaign->campaign_name }}" active showDescription showText="{{ $campaign->display_narative_box }}">{{ $campaign->campaign_name }}</option>
                                  @endif
                              @else
                                  @if ($campaign->default_option == true)
                                      <option value="{{ $campaign->campaign_name }}" selected showText="{{ $campaign->display_narative_box }}">{{ $campaign->campaign_name }}</option>
                                  @else
                                      <option value="{{ $campaign->campaign_name }}" showText="{{ $campaign->display_narative_box }}">{{ $campaign->campaign_name }}</option>
                                  @endif
                              @endif
                          @endforeach
                      </select>

                  </div>
              </div>
              <div id="descriptionDiv" class="mb-3 row"  style="display: none">
                  <label class="col-sm-2" for="description">Description</label>
                  <div class="col-sm-10" style="border-radius: 10px;">
                      <textarea id="description" cols="30" style="width: 49%; height: 38px;"></textarea>
                  </div>
              </div>
          </form>
      </div>
  </div>

        {{--start of VCrun file--}}
                <div id="participationDiv" class="mb-3 row" style="display: none">
                    <label class="col-sm-2" for="participation">How would you like to participate?</label>
                    <div class="col-sm-5">
                        @foreach ($participation as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$item->id}}" id="participation{{$item->id}}">
                            <label class="form-check-label" for="participation{{$item->id}}">
                                {{$item->name}}
                            </label>
                          </div>
                        @endforeach
                    </div>
                </div>

            <br>
        {{--End of VCrun file--}}

  <div id="contactDetailsSection">
  <h3 class="sectionTitle">Contact Details</h3>
                    <form>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label" for="firstName">Name *</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control rounded" id="firstName" placeholder="Surname">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control rounded" id="lastName" placeholder="Other Name's">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label" for="phoneNumber">Phone Number *</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control rounded" id="phoneNumber" aria-describedby="emailHelp" placeholder="+254000000000">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label" for="email">Email address *</label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control rounded" id="email" aria-describedby="emailHelp" placeholder="jdoe@company.org">
                            </div>
                        </div>

                        <div class="mb-3 row" style="display: none">
                            <label class="col-sm-2 col-form-label" for="postalAddress">Postal Address </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control rounded" id="postalAddress" aria-describedby="postalAddress" placeholder="Enter your postal Address" value="59857,00200 City Square Nairobi, Kenya">
                            </div>
                        </div>

                        <div class="mb-3 row" style="display: none">
                            <label class="col-sm-2 col-form-label" for="zipCode">Zip / Postal Code *</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control rounded" id="zipCode" aria-describedby="zipCode" placeholder="Zip / Postal Code" value="00200">
                            </div>
                        </div>

                        <div class="mb-3 row" style="display: none">
                            <label class="col-sm-2 col-form-label" for="city">Town / City </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control rounded" id="city" aria-describedby="city" placeholder="Nairobi" value="Nairobi">
                            </div>
                        </div>

                        <div class="mb-3 row" style="display: none">
                            <label class="col-sm-2 col-form-label" for="country">Country *</label>
                            <div class="col-sm-3">
                                <select id="country">
                                    @foreach ($pageBo->countrys as $country)
                                        @if ($country->countryCode == "KE")
                                            <option value="{{ $country->countryCode }}" selected>{{ $country->countryName }}</option>
                                        @else
                                            <option value="{{ $country->countryCode }}">{{ $country->countryName }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label" for="relation">Relation *</label>
                            <div class="col-sm-5">
                                <select class="form-select" id="relation">
                                    @foreach($pageBo->relations as $relation)
                                        @if ($relation->display_graduation_yr == true)
                                            <option value="{{ $relation->relation_name }}" showText="{{ $relation->display_graduation_yr }}" selected>{{ $relation->relation_name }}</option>
                                        @else
                                            <option value="{{ $relation->relation_name }}" showText="{{ $relation->display_graduation_yr }}">{{ $relation->relation_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="graduationClassDiv" class="mb-3 row" style="display: none">
                            <label class="col-sm-2 col-form-label" for="classOf">Graduation Class *</label>
                            <div class="col-sm-5">
                                <select class="form-select" id="classOf">

                                    @foreach($pageBo->graduationClass as $graduationClass)
                                        <option value="{{ $graduationClass->graduation_key }}">{{ $graduationClass->graduation_key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="organisationDiv" class="mb-3 row">
                            <label class="col-sm-2 col-form-label" for="company">Organisation</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control rounded" id="company" aria-describedby="company" placeholder="Organisation / Company">
                            </div>
                        </div>

                        <div id="jobTitleDiv" class="mb-3 row">
                            <label class="col-sm-2 col-form-label" for="jobTitle">Job Title</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control rounded" id="jobTitle" aria-describedby="jobTitle" placeholder="Job Title">
                            </div>
                        </div>
                        <button class="awesome-checkout-button" type="button"></button>
                    </form>
                </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Boot
    strap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->

    <script src="{{ $pageBo->expressCheckoutUrl }}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/simple.money.format.js"></script>
    <script src="js/selectstyle.js"></script>
    <script>
        // Declare Variable
        var donorDetails = @json($pageBo->donorDetails, JSON_PRETTY_PRINT);
        // declares another variable called payload and assigns it an object with three properties: method, headers, and body
        var payload = {
            "method": "post",
            "headers": {"Content-type": "application/json; charset=UTF-8"},
            "body": @json($pageBo->cellulantExpressCheckoutRequestBodyPayload, JSON_PRETTY_PRINT)
        };

        // Tingg.renderPayButton function is called with an object that contains two properties: className and checkoutType. The function renders a payment button using the specified class name and checkout type.
        Tingg.renderPayButton({
            className: 'awesome-checkout-button',
            checkoutType: 'redirect'
        });
        // Executed when the page is loaded : sets up conditional logic to show or hide the #graduationClassDiv element based on the selected option of the #relation element.
        $(function() {
            var rel =  $('#relation').children("option:selected").attr('showText');
            if(rel ==='1'){
                $('#graduationClassDiv').show();
            } else {
                $('#graduationClassDiv').hide();
            }


        });
        // Executed when the page is loaded :Sets up conditional logic to hide or show elements on the page based on the selected value of the #campaign element. It also performs validation and prefilling of certain elements based on the selected campaign.
        $(function(){
            if($('#campaign').val() === "Vice Chancellor's Run"){
                $('#participationDiv').hide();
                prefillVcRunAmount();
                amountValidator();
                amountValueValidator();
            }else{
                $('#amount').val('');
                $('#participationDiv').hide();
            }
        });

        function validate() {
            var valid = true;
            if($('#firstName').val() === null | $('#firstName').val() === ""){
                valid = false;
                firstNameValidator();
            }

            valid=amountValueValidator();
            if($('#lastName').val() === null | $('#lastName').val() === ''){
                valid = false;
                lastNameValidator();
            }
            if($('#city').val() === null | $('#city').val() === ''){
                valid = false;
                cityValidator();
            }
            if($('#email').val() === null | $('#email').val() === ''){
                valid = false;
                emailValidator();
            }
            if($('#zipCode').val() === null | $('#zipCode').val() === ''){
                valid = false;
                zipCodeValidator();
            }
            if($('#phoneNumber').val() === null | $('#phoneNumber').val() === ''){
                valid = false;
                phoneValidator();
            }
            if($('#amount').val() === null | $('#amount').val() === ''){
                valid = false;
                amountValidator();
            } else {
                var value = $('#amount').val().replace(/,/g, '');
                if(!(!isNaN(value) && parseFloat(value) > 0)){
                    valid = false;
                }
            }
            if ($('#amountCurrency option:selected').length === 0) {
                valid = false;
                amountCurrencyValidator();
            }
            if ($('#country option:selected').length === 0) {
                valid = false;
                countryValidator();
            }
            /*if ($('#salutation option:selected').length == 0) {
                valid = false;
                $('#salutation').addClass("is-invalid");
                $('#salutation').removeClass("is-valid");
            }*/
            if($('#campaign option:active').length === 0){
                var val = $('#campaign').children("option:selected").attr('showText');
                if(val === 1){
                    if($('#description').val() === "" || $('#description').val() === null){
                        $('#description').addClass("is-invalid");
                        $('#description').removeClass("is-valid");
                    } else {
                        $('#description').addClass("is-invalid");
                        $('#description').removeClass("is-valid");
                    }
                }
            }

            if($('#relation option:selected').length === 0){
                var val = $('#relation').children("option:selected").attr('showText');
                if(val === 1){
                    if($('#classOf').children("option:selected").val() === "" || $('#classOf').children("option:selected").val() === null){
                        $('#description').addClass("is-invalid");
                        $('#description').removeClass("is-valid");
                    } else {
                        $('#description').addClass("is-invalid");
                        $('#description').removeClass("is-valid");
                    }
                }
            }
            if ($("input[name='participation']:checked").val==null) {
                $('#participation').addClass("is-invalid");
            }

            return valid;
        }
        function pickDonorDetails(){
            if(validate()){
                donorDetails.firstName = $('#firstName').val();
                donorDetails.lastName = $('#lastName').val();
                donorDetails.company = $('#company').val();
                donorDetails.country = $('#country').children("option:selected").val();
                donorDetails.jobTitle = $('#jobTitle').val();
                donorDetails.graduatingClass = $('#classOf').children("option:selected").val();
                donorDetails.city = $('#city').val();
                donorDetails.email = $('#email').val();
                donorDetails.zipCode = $('#zipCode').val();
                donorDetails.currency = $('#amountCurrency').children("option:selected").val();
                donorDetails.salutation = $('#salustation').children("option:selected").val();
                donorDetails.phoneNumber = $('#phoneNumber').val();
                donorDetails.merchantID = payload.body.merchantTransactionID;
                donorDetails.campaign = $('#campaign').val();

                donorDetails.requestDescription = $('#description').val();

                donorDetails.relation = $('#relation').children("option:selected").val();

                payload.body.currencyCode = $('#amountCurrency').children("option:selected").val();
                payload.body.requestAmount = $('#amount').val().replace(/,/g, '');
                payload.body.customerEmail = $('#email').val();
                payload.body.MSISDN = $('#phoneNumber').val();
                payload.body.customerFirstName = $('#firstName').val();
                payload.body.customerLastName = $('#lastName').val();
                payload.body.requestDescription = $('#description').val();


                return true;
            }
            return false;
        }

        $('#amount').on('keyup',function(){
            amountValidator();
        });
        $('#amount').mouseout(function() {
            amountValidator();
        });
        function amountValidator(){
            if(!($('#amount').val() === null || $('#amount').val() === "")) {
                var value = $('#amount').val().replace(/,/g, '');
                if (!isNaN(value) && parseFloat(value) > 0) {
                    $('#amount').addClass("is-valid");
                    $('#amount').removeClass("is-invalid");
                    amountValueValidator();
                } else {
                    $('#amount').addClass("is-invalid");
                    $('#amount').removeClass("is-valid");
                }
            } else {
                $('#amount').addClass("is-invalid");
                $('#amount').removeClass("is-valid");
            }


        }

        function amountValueValidator() {
            //Minimum allowed Donation is 1000 kes for VC Run
            if($('#campaign').val()==="Vice Chancellor's Run"){
                //check if value is KES
                if($('#amountCurrency').val()==='KES'){

                    if($('#amount').val()<1000){
                        //console.log('Less than Ksh 1000');
                        $('#amount').addClass("is-invalid");
                        $('#amount').removeClass("is-valid");
                        $('#amountValueValidator').show();
                        $('#amountValueValidator').html('Vice Chancellor\'s Run contributions must be above 1000 KES').addClass("error-msg");
                        return false;
                    }
                    else{
                        $('#amount').addClass("is-valid");
                        $('#amount').removeClass("is-invalid");
                        $('#amountValueValidator').hide();
                        $('#amountValueValidator').removeClass('error-msg');
                        return true;
                    }
                }else if($('#amountCurrency').val()==='USD'){
                    if($('#amount').val()<8.67){
                        //console.log('Less than Ksh 1000');
                        $('#amount').addClass("is-invalid");
                        $('#amount').removeClass("is-valid");
                        $('#amountValueValidator').show();
                        $('#amountValueValidator').html('Vice Chancellor\'s Run contributions must be above 8.67 USD').addClass("error-msg");
                        return false;
                    }
                    else{
                        $('#amount').addClass("is-valid");
                        $('#amount').removeClass("is-invalid");
                        $('#amountValueValidator').hide();
                        $('#amountValueValidator').removeClass('error-msg');
                        return true;
                    }
                }
            }
            else{
                $('#amountValueValidator').hide();
                $('#amountValueValidator').removeClass('error-msg');
                return true;
            }
        }


        $('#firstName').on('keyup',function(){
            firstNameValidator();
        });
        $('#firstName').mouseout(function(){
            firstNameValidator();
        });
        function firstNameValidator(){
            if($('#firstName').val() === null || $('#firstName').val() === ""){
                $('#firstName').addClass("is-invalid");
                $('#firstName').removeClass("is-valid");
            }else{
                $('#firstName').addClass("is-valid");
                $('#firstName').removeClass("is-invalid");
            }
        }
        $('#lastName').on('keyup',function(){
            lastNameValidator();
        });
        $('#lastName').mouseout(function(){
            lastNameValidator();
        });
        function lastNameValidator(){
            if($('#lastName').val() === null || $('#lastName').val() === ""){
                $('#lastName').addClass("is-invalid");
                $('#lastName').removeClass("is-valid");
            }else{
                $('#lastName').addClass("is-valid");
                $('#lastName').removeClass("is-invalid");
            }
        }
        $('#city').on('keyup',function(){
            cityValidator();
        });
        $('#city').mouseout(function(){
            cityValidator();
        });
        function cityValidator(){
            if($('#city').val() === null || $('#city').val() === ""){
                $('#city').addClass("is-invalid");
                $('#city').removeClass("is-valid");
            }else{
                $('#city').addClass("is-valid");
                $('#city').removeClass("is-invalid");
            }
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
            }else{
                if($('#email').val().match(emailRegex)) {
                    $('#email').addClass("is-valid");
                    $('#email').removeClass("is-invalid");
                } else {
                    $('#email').addClass("is-invalid");
                    $('#email').removeClass("is-valid");
                }
            }
        }
        $('#zipCode').on('keyup',function(){
            zipCodeValidator();
        });
        $('#zipCode').mouseout(function(){
            zipCodeValidator();
        });
        function zipCodeValidator(){
            if($('#zipCode').val() === null || $('#zipCode').val() === ""){
                $('#zipCode').addClass("is-invalid");
                $('#zipCode').removeClass("is-valid");
            }else{
                $('#zipCode').addClass("is-valid");
                $('#zipCode').removeClass("is-invalid");
            }
        }
        $('#postalAddress').on('keyup',function(){
            postalAddressValidator();
        });
        $('#postalAddress').mouseout(function(){
            postalAddressValidator();
        });
        function postalAddressValidator(){
            if($('#postalAddress').val() === null || $('#postalAddress').val() === ""){
                $('#postalAddress').addClass("is-invalid");
                $('#postalAddress').removeClass("is-valid");
            }else{
                $('#postalAddress').addClass("is-valid");
                $('#postalAddress').removeClass("is-invalid");
            }
        }
        $('#phoneNumber').on('keyup',function(){
            phoneValidator();
        });
        $('#phoneNumber').mouseout(function(){
            phoneValidator();
        });
        function phoneValidator(){
            if($('#phoneNumber').val() === null || $('#phoneNumber').val() === ""){
                $('#phoneNumber').addClass("is-invalid");
                $('#phoneNumber').removeClass("is-valid");
            }else{
                var msisdnregx = /^\+(?:[0-9] ?){6,14}[0-9]$/;
                if($('#phoneNumber').val().match(msisdnregx)){
                    $('#phoneNumber').addClass("is-valid");
                    $('#phoneNumber').removeClass("is-invalid");
                } else {
                    $('#phoneNumber').addClass("is-invalid");
                    $('#phoneNumber').removeClass("is-valid");
                }
            }
        }
        $('#amountCurrency').on('keyup',function(){
            amountCurrencyValidator();
        });
        function amountCurrencyValidator(){
            if($('#amountCurrency option:selected').length == 0){
                $('#amountCurrency').addClass("is-invalid");
                $('#amountCurrency').removeClass("is-valid");
            }else{
                $('#amountCurrency').addClass("is-valid");
                $('#amountCurrency').removeClass("is-invalid");
            }
        }
        $('#country').on('keyup',function(){
            countryValidator();
        });
        $('#relation').on( "change", function(){
            var rel =  $('#relation').children("option:selected").attr('showText');
            if(rel ==='1'){
                $('#graduationClassDiv').show();
            } else {
                $('#graduationClassDiv').hide();
            }
        });
        $('#campaign').on( "change", function(){
            amountValueValidator();
            var rel =  $('#campaign').children("option:selected").attr('showText');
            if(rel ==='1'){
                $('#descriptionDiv').show();
            } else {
                $('#descriptionDiv').hide();
            }
        });
        $('#amount').change(function(){
            if($(this).val() === "Vice Chancellor's Run"){
                amountValueValidator();
            }
        });
        $('#amountCurrency').change(function(){
            if($(this).val() === "USD"){
                $('#basic-addon1').html('$')
                if($('#campaign').val() === "Vice Chancellor's Run"){
                    prefillVcRunAmount();
                }else{
                    $('#amount').val('');
                }

            }else{
                $('#basic-addon1').html('Ksh')
                if($('#campaign').val() === "Vice Chancellor's Run"){
                    prefillVcRunAmount();
                }else{
                    $('#amount').val('');
                }
            }
        });
        $('#campaign').change(function(){
            if($(this).val() === "Vice Chancellor's Run"){
                $('#participationDiv').hide();
                prefillVcRunAmount();
                amountValueValidator();
            }else{
                $('#amount').val('');
                $('#participationDiv').hide();
            }
        });

        //Prefill form with data when vc run is selected
        function prefillVcRunAmount()
        {
            if($('#amountCurrency').val()==='KES'){
                $('#amount').val(1000);
                amountValidator();
            }else{
                $('#amount').val(8.67);
            }
        }


        function countryValidator(){
            if($('#country option:selected').length === 0){
                $('#country').addClass("is-invalid");
                $('#country').removeClass("is-valid");
            }else{
                $('#country').addClass("is-valid");
                $('#country').removeClass("is-invalid");
            }
        }
        $('#amount').simpleMoneyFormat();
        $('.awesome-checkout-button').on('keyup',function(){
            $('#amount').simpleMoneyFormat();
        })
        $( function() {
            $( "#contactDetailsSection" ).accordion({
                collapsible: false
            });
            $( "#giftSection" ).accordion({
                collapsible: false
            });
        } );
        // The main purpose of the function is to validate the user's input and then send a donation request to a server.
        $('.awesome-checkout-button').on('click',
            function() {
            // console.log(JSON.stringify(donorDetails));
                if (pickDonorDetails()) {
                    //Save Campaign Option
                    if($('#campaign').val()==="Vice Chancellor's Run"){

                        var participationOptions = @json($participation);
                        var checkedBoxes=[]
                        for (let index = 1; index < participationOptions.length+1; index++) {
                            if($('#participation' + index).is(":checked")){
                                checkedBoxes.push(participationOptions[index-1].id);
                            }

                        }
                        //Set default checkbox value to 1 -> #physical appearance
                        if(checkedBoxes.length===0){
                            checkedBoxes.push(1);
                        }
                        const requestOptions = {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(
                                {
                                    merchantID: donorDetails.merchantID,
                                    participationIDs: checkedBoxes
                                })
                        };
                        fetch(window.location.href + "api/saveCampaignOption",requestOptions)
                       // .then(function(res){ console.log(requestOptions); })
                    }

                    fetch(window.location.href + 'api/saveDonationRequest', {
                        "method": "POST",
                        "headers": {
                            "Content-type": "application/json; charset=UTF-8"
                        },
                        "body": JSON.stringify(donorDetails)
                    })
                    .then(responce => responce)
                    .then(function (data) {
                        fetch(window.location.href + 'api/encrypt/{{ $pageBo->donationCode }}', {
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
                                checkoutType: "redirect" // or ‘modal’
                            });
                        })
                        .then(function (error) {
                        });
                    })
                    .then(function () {
                        //console.log(data);
                    });


                    }
            });
    </script>
  </body>
</html>

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
let stepCount = 3
step[current_step].classList.add('d-block');
if (current_step == 0) {
    prevBtn.classList.add('d-none');
    //submitBtn.classList.add('d-none');
    nextBtn.classList.add('d-inline-block');
}

const progress = (value) => {
    document.getElementsByClassName('progress-bar')[0].style.width = `${value}%`;
}

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
});

function showTotalAmount(){
    amount=getTotalAmount();
    console.log(amount);
    if($('#amountCurrency').children("option:selected").val()=='KES'){
        $('#totalAmountDiv').text('Ksh '+amount);
    }
    else{
        $('#totalAmountDiv').text('$ '+amount);
    }
}

function getTotalAmount() {
    var amount = 0;


    if ($('input[name="participation"]:checked').val() == "partAny") {
        amount += parseInt($('#anyAmount').val());
    } else {
        if($('#amountCurrency').children("option:selected").val()=='KES'){
            amount += 1000;
        }
        else{
            amount+=8.67;
        }
        
    }
    if ($('#supportVc').is(":checked")) {
        amount += parseInt($('#sponsorVcAmountValue').val());
    }
    if ($('#supportAnother').is(":checked")) {
        amount += parseInt($('#sponsorParticipantAmountValue').val());
    }
    return amount;
}

//Select default Currency
function selectDefaultCurrency()
{
    //1 usd = 115.85 ksh
    var usdToKsh=115.85;
    if($('#amountCurrency').children("option:selected").val()=='KES')
    {
        $('#currencyOption').text('Ksh');
        $('#currencyOption1').text('Ksh');
        $('#currencyOption3').text('Ksh');

        $('#registrationCost').text('Ksh 1000')
        $('#registrationCost1').text('Ksh 1000')
        //check if there are input fields with data
        var amount = parseInt($('#anyAmount').val())
        if(!$('#anyAmount').val() ||amount>1)
        {
            $('#anyAmount').val(amount*usdToKsh);
        }

        var amount1 = parseInt($('#sponsorVcAmountValue').val())
        if(!$('#sponsorParticipantAmountValue').val() ||amount1>1)
        {
            $('#sponsorVcAmountValue').val(amount1*usdToKsh);
        }

        var amount2 = parseInt($('#sponsorParticipantAmountValue').val())
        if(!$('#sponsorParticipantAmountValue').val() ||amount2>1)
        {
            $('#sponsorParticipantAmountValue').val(amount2*usdToKsh);
        }



    }else{
        $('#currencyOption').text('$');
        $('#currencyOption1').text('$');
        $('#currencyOption3').text('$');

        $('#registrationCost').text('$ 8.67')
        $('#registrationCost1').text('$ 8.67')

        var amount = parseInt($('#anyAmount').val())
        if(!$('#anyAmount').val() ||amount>1)
        {
            $('#anyAmount').val(amount/usdToKsh);
        }

        var amount1 = parseInt($('#sponsorVcAmountValue').val())
        if(!$('#sponsorVcAmountValue').val() ||amount1>1)
        {
            $('#sponsorVcAmountValue').val(amount1/usdToKsh);
        }

        var amount2 = parseInt($('#sponsorParticipantAmountValue').val())
        if(!$('#sponsorParticipantAmountValue').val() ||amount2>1)
        {
            $('#sponsorParticipantAmountValue').val(amount2/usdToKsh);
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
            var amount = parseInt($('#anyAmount').val());  
            if(!$('#anyAmount').val() ||amount  < 0){
                $('#anyAmount').addClass("is-invalid");
                $('#anyAmount').removeClass("is-valid");
                return false;
            }else{
                $('#anyAmount').removeClass("is-invalid");
                return true;
            }

        }else if($('input[name="participation"]:checked').val()=="partPhysical"){
            $('#noKilometersCard').show();
            if($('#numberOfKilometers option:selected').val()=='none'){
                $('#numberOfKilometers').addClass("is-invalid");
                return false;
            }else{
                $('#numberOfKilometers').removeClass("is-invalid");
                return true;
            }
        }else if($('input[name="participation"]:checked').val()=="partVirtual"){
            $('#noKilometersCard2').show();
            if($('#numberOfKilometers2 option:selected').val()=='none'){
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
    if($('input[name="participation"]:checked').val()=="partAny"){
        $('#anyParticipationAmount').show();
    }else{
        $('#anyParticipationAmount').hide();
    }

    if($('input[name="participation"]:checked').val()=="partPhysical"){
        $('#noKilometersCard').show();
    }else{
        $('#noKilometersCard').hide();
    }

    if($('input[name="participation"]:checked').val()=="partVirtual"){
        $('#noKilometersCard2').show();
    }else{
        $('#noKilometersCard2').hide();
    }
});

//END OF PART ONE ** Participation Section ** //

//START OF PART TWO ** Sponsor VC Section ** //

function validateSponsorVc(){
    if($('#supportVc').is(":checked")){
        var amount = parseInt($('#sponsorVcAmountValue').val());
        if(!$('#sponsorVcAmountValue').val() ||amount  < 0){
            $('#sponsorVcAmountValue').addClass("is-invalid");
            $('#sponsorVcAmountValue').removeClass("is-valid");
            return false;
        }else{
            $('#sponsorVcAmountValue').removeClass("is-invalid");
            return true;
        }
    }else if($('#supportAnother').is(":checked")){
        var amount = parseInt($('#sponsorParticipantAmountValue').val());
        if(!$('#sponsorParticipantAmountValue').val() ||amount  < 0 ||$('#vCparticipants option:selected').val()=='none'){
            if($('#vCparticipants option:selected').val()=='none'){
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
        phoneValidator();
        return false;
    }
    return true;
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

$('#phonenumber').on('keyup',function(){
    phoneValidator();
});
$('#phonenumber').mouseout(function(){
    phoneValidator();
});
function phoneValidator(){
    if($('#phonenumber').val() === null || $('#phonenumber').val() === ""){
        $('#phonenumber').addClass("is-invalid");
        $('#phonenumber').removeClass("is-valid");
    }else{
        var msisdnregx = /^\+(?:[0-9] ?){6,14}[0-9]$/;
        if($('#phonenumber').val().match(msisdnregx)){
            $('#phonenumber').addClass("is-valid");
            $('#phonenumber').removeClass("is-invalid");
        } else {
            $('#phonenumber').addClass("is-invalid");
            $('#phonenumber').removeClass("is-valid");
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


$('#relation').on( "change", function(){
    var rel =  $('#relation').children("option:selected").attr('showText');
    if(rel ==='1'){
        $('#graduationClassDiv').show();
    } else {
        $('#graduationClassDiv').hide();
    }
});
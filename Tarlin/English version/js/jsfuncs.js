var sAdditCont = '', sMailSendMessage="Вашето съобщение бе успешно изпратено!", sErrorMailSendMessage="Поради възникнала грешка при изпращането, моля свържете се директно чрез email с екипа на ShpilkaBG.";
var iIntUsl, bIsMMsgSent=false;

//** Load page content text
function FillContent(ind){
   $('#column_r_content').load( gCoFolder + arPageContentSrc[ind]+gCoFComName + gExt, function(){
                     if(sAdditCont.length>0 && !bIsMMsgSent) {
                            $('#addcont').text(sAdditCont);
                            bIsMMsgSent = true;
                     }
                     
                   //** close Interiorni uslugi if opened
                     if(bSubStatus) OpenSub($('.mbutton:eq('+(iIntUsl-1)+')'))
                    });
   
   
}

var aspLink = 'http://alpinworks.brinkster.net/Shpilka/';
var aspMailProcess = 'contactusprocess.asp';
var arFormItems = Array(
    {elem:"NameV", required:true, message:"Моля напишете вашето име!", emsg_t:"Име"},
    {elem:"Email_Address", required:true, message:"Моля попълнете е-мейл!", emsg_t:"E-mail"},
    {elem:"Telephone_No", required:false, message:"Моля попълнете телефонен номер!", emsg_t:"Телефон"},
    {elem:"Message", required:true, message:"Моля оставете съобщение!", emsg_t:"Съобщение"},
    {elem:"mailTo", required:false, message:'', emsg_t:''} );
var aspMailTo = 'shpilkabg' + '@' + 'gmail.com';

var msgMailError = "Моля въведете валиден е-мейл адрес!"
  
function SubmitMail(){
    //alert($('#form1').val(arFormItems[0]))
    //alert($('input[name=NameV]').text())
    $('#mailTo').val(aspMailTo);
    
    var foStr='';
    for (a=0; a<arFormItems.length; a++){
        if (arFormItems[a].required)
            if (!$('#'+arFormItems[a].elem).val()){
                alert(arFormItems[a].message);
                return false;
            }
    }
    
    if (!validateEmail($('#'+arFormItems[1].elem).val())){
        alert(msgMailError);
        return false;
    }
    
    
    //** create the body of the mail
    var d = new Date();
    d = d.toDateString();
    var space = ":  "; 
    
    $('#MSub').val( "Попълнена контакт форма от сайта ShpilkaBG ("+ d + ")" );
    $('#HL').val( "Потребител със следните данни е попълнил формата за контакти:" );
    for (a=0; a<arFormItems.length-1; a++){
        fVal = $('#'+arFormItems[a].elem).val();
        if(fVal!='')
            $('#'+arFormItems[a].elem+'1').val(arFormItems[a].emsg_t + space + fVal );
    }
    $('#senDate').val( "Дата" + space + d );
    

   // $('#contactForm').attr("contentType", "application/json; charset=utf-8");
    $('#contactForm').attr("contentType", "application/json; charset=windows-1251");
    url = aspLink + aspMailProcess
    $('#contactForm').attr("action", url);
    
    /* Local Links ...
    url = aspMailProcess
    $('#contactForm').attr("action", url);
    */

    $('#contactForm').submit();
    return false;
            
}

function validateEmail(elementValue){  
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)?([\.]{1}[a-zA-Z]{2,4}){1,4}$/;
    return emailPattern.test(elementValue);  
  } 

var timeHide, timeShow;
timeHide = 200;
timeShow = 1500;
var speed = 1000;

function StartBlinkingText(obj, mode){
    var time, opac;
    //if(mode) alert('show\n'+obj); else alert('hide\n'+obj);
    //mode = 1
    //alert(mode)
    if(mode){
        // show
       // $(obj).css('display', 'block');
        //$(obj).css('visibility', 'visible');
      //  $(obj).fadeTo(speed, 1.0);
        opac = 1.0;
        time = timeShow ;
    }
    else{
        //hide
        //$(obj).css('display', 'none');
        //$(obj).css('visibility', 'hidden');
       // $(obj).fadeTo(speed, 0.0);
        opac = 0.0;
        time = timeHide;
    }
    
    $(obj).fadeTo(speed, opac, function(){    
                                setTimeout(function(){
                                                StartBlinkingText(obj, Math.abs(mode-1));
                                                }, time );
                                          }
    );
}

$(document).ready(function() {
    
    if (!$.browser.msie) {
        var prBox = $('#promoBlock');   //promoHo
        StartBlinkingText(prBox,0);
    }
    

    //*** only for CONTACT page
    if ( $('#contact').length > 0 ){
        //**clean the additional content variable
        sAdditCont='';
        //** s=1 and e=1 are parameters which the send message event sets
        if (window.location.href.indexOf('s=1')>-1) {
            N=11;
            sAdditCont = sMailSendMessage;
        }//** error in sending mail
        if (window.location.href.indexOf('e=1')>-1) {
            N=11;
            sAdditCont = sErrorMailSendMessage;
        }
        

        if(sAdditCont.length>0 && !bIsMMsgSent) {
                $('#addcont').css('display', 'block');
                $('#addcont').text(sAdditCont);
                bIsMMsgSent = true;
         }
     }
     
});
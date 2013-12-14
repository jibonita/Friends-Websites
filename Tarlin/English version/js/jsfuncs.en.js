var sMailSendMessage="Your message was successfully sent!", 
    sErrorMailSendMessage="Due to sending error please contact by email the ShpilkaBG stuff.";

var arFormItems = Array(
    {elem:"NameV", required:true, message:"Please fill your name !", emsg_t:"Име"},
    {elem:"Email_Address", required:true, message:"Please fill your e-mail !", emsg_t:"E-mail"},
    {elem:"Telephone_No", required:false, message:"Please fill your phone number !", emsg_t:"Телефон"},
    {elem:"Message", required:true, message:"Please leave some message !", emsg_t:"Съобщение"},
    {elem:"mailTo", required:false, message:'', emsg_t:''} );

var msgMailError = "Please enter a correct e-mail!"
var aspLink = 'http://alpinworks.brinkster.net/Shpilka/EN/';
  

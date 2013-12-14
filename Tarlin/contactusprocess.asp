<%'Response.CodePage = 65001 
  'Response.CharSet = "utf-8"
  Response.CodePage = 1251 
Response.CharSet = "windows-1251"%>
<%
'' //----- Labels
Dim headLine, mailSubject, lbName, lbEmail, lbPhone, lbMsg, lbDate
Dim space
    headLine = "Потребител със следните данни е попълнил формата за контакти:"& vbNewLine& vbNewLine
    mailSubject = "Попълнена контакт форма от сайта ShpilkaBG ( "& Date() &")"
    space = ": "
    lbName = "Име" &space
    lbEmail = "E-mail" &space
    lbPhone = "Телефон" &space
    lbMsg = "Съобщение" &space
    lbDate = "Дата" &space
''// end labels
''//Links
Dim gcDefUMail, gcSuccPage, gcErrPage, gcAppSite
    gcDefUMail = "empty@mail.com"
    gcSuccPage = "contact.html?s=1"
    gcErrPage = "contact.html?e=1"
    'Local
    'gcAppSite = "http://192.168.0.160/dev/Tarlin/"
    'Server
    gcAppSite = "http://devs.hit.bg/ShP/"		'gcAppSite = "http://alpinworks.hit.bg/NewS/"

''// end links

''// New properties
Dim headLine1, msgSubj, seDate

headLine1 = Request("HL")
msgSubj = Request("MSub")
seDate = Request("senDate")


''//end


Dim mail_to, mail_from 
mail_to     = Request("mailTo")
mail_from   = Request("Email_Address1")
'if Len(mail_from)=0 then mail_from = gcDefUMail

For Each f In Request.Form
        emsg  = emsg & f & " = " &  Trim(Request.Form(f)) &  vbNewLine
Next
'response.Write emsg
'response.end

Dim error
error = 0
if (mail_from="" AND Request("Message1")="" ) then error = 1
''//Response.Write "all?="& Request.ServerVariables("QUERY_STRING")&""

If error=1 Then
    response.redirect gcErrPage
Else
    Dim f, emsg, r, o, c, other
    fline = "_______________________________________________________________________"& vbNewLine & vbNewLine   
   ''// headLine = "User with the following information has signed in the contact form:"& vbNewLine
    
    'emsg = lbName & Request("NameV")& vbNewLine &_
    '       lbEmail & mail_from & vbNewLine 
    'if (Request("Telephone_No")<>"") then  emsg = emsg& lbPhone & Request("Telephone_No")& vbNewLine   
    'emsg = emsg& lbMsg & Request("Message")& vbNewLine& vbNewLine&_
    '        lbDate& Date()& vbNewLine
            
    emsg = Request("NameV1")& vbNewLine &_
           mail_from & vbNewLine 
    if (Request("Telephone_No1")<>"") then  emsg = emsg& Request("Telephone_No1")& vbNewLine   
    emsg = emsg & Request("Message1")& vbNewLine& vbNewLine&_
            seDate & vbNewLine
           
    'Response.Write "emsg?="& emsg&""

    headLine = headLine1 & vbNewLine& vbNewLine
    mailSubject = msgSubj
    
    error = SendMail(mail_to, mailSubject, fline& headLine & emsg & fline)
    
    ' SEND SMS
    call SendMail("359889357795@sms.mtel.net", "You've got Mail", mail_from & " e populnil kontakt formata na ShpilkaBG")
    '359889809707
End if

if Len(error)=0 then
    response.Write "Todo va bien!"
    response.redirect gcAppSite & gcSuccPage
else
    response.Write "Errores!:" & error
    response.redirect gcAppSite & gcErrPage
end if

%>

<%
'--------------------------------------------------------------------------
' Sends an email and returns an empty string if successful. Otherwise, it
' returns the error message.
'--------------------------------------------------------------------------
function SendMail(toAddr, subjectText, bodyText)
    dim mailer
    dim cdoMessage, cdoConfig
    'Assume all will go well.
    SendMail = ""
    
    on error resume next
    'Configure the message.
    set cdoMessage = Server.CreateObject("CDO.Message")
    set cdoConfig = Server.CreateObject("CDO.Configuration")
    cdoConfig.Fields("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2
    cdoConfig.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "smtp.gmail.com"
    cdoConfig.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/smtpusessl") = True
    cdoConfig.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "smtp.gmail.com"
    cdoConfig.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 465
    cdoConfig.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/smtpauthenticate") = 1
    cdoConfig.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/sendusername") = "shpilkabg@gmail.com"
    cdoConfig.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/sendpassword") = "portokal"
    cdoConfig.Fields.Item ("http://schemas.microsoft.com/cdo/configuration/languagecode ") = "bg"
    cdoConfig.Fields.Update
    set cdoMessage.Configuration = cdoConfig
    'Create the email.
    cdoMessage.From     = mail_from
    cdoMessage.To       = toAddr
    cdoMessage.Subject  = subjectText
    cdoMessage.textBody = bodyText
    'cdoMessage.bodypart.charset = "utf-8"
    cdoMessage.bodypart.charset = "windows-1251"
    'Send it.
    
    'on error resume next
    cdoMessage.Send
    'If an error occurred, return the error description.
    if Err.Number <> 0 then
        SendMail = Err.Description
    end if
    
    'Clean up.
    set cdoMessage = Nothing
    set cdoConfig  = Nothing

end function 

%>
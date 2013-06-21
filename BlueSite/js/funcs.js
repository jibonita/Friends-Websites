// JScript source code
var sActMenu;
var actPage = 1; //** to be changed in html pages
var iGSlideImgNum = 0;

//** custom menu labels
var arMenuItems = Array('Home','Asbestos','Fungi Properties','Mold Procedures','HVAC Cleaning','Content Cleaning','Industrial Insulation','Projects','Demolition', 'E-Mail');
var arMenuLinkFile = Array('index','asbestos','fungi','mold','infoproc','coclean', 'industrial', 'projects', 'demolition','');
//*** !!! Galleries with images for slide should have the same name as the html file for the corresponding page
//*** !!! Files will have name of this model: 1.jpg, 2.jpg, 3.jpg, etc.
var gGPath; 

//** end of custom info block
    
function SetActiveStatus(ind)
{
    /*
    jQuery('#'+sActMenu).removeClass('active');
    jQuery(o).addClass('active');
    sActMenu = jQuery(o).attr('id');
    */
    
    document.location.href = arMenuLinkFile[ind]+'.html';
}


jQuery(document).ready(function(){
    
    preloadImages();
    
    var pgCont = jQuery('body').html();
   
    jQuery('body').load( 'template.html', function(){
                     
            SetUpTopMenu();
            
            if (iGSlideImgNum > 0)
                SetGallerySlide();
            else
                jQuery('#imSliHolder').css('display', 'none');
            
            jQuery('#maincontent').html(pgCont);
            
            SetUpBottomMenu();
                        
            if (typeof curvyCornersNoAutoScan != 'undefined' )
                curvyCorners.init();
    
        });
    
});

function preloadImages() {

    var img,i=0;
    gGPath = "images/SlideG/"+arMenuLinkFile[actPage-1]+"/"
    
	if (document.images) {
	    while (i<iGSlideImgNum)
	    {
		    img = newImage(gGPath + (i++)+".jpg");
	    }
	}
}
function newImage(arg) {
	if (document.images) {
		rslt = new Image();
		rslt.src = arg;
		return rslt;
	}
}


function SetUpTopMenu(){
    var tnode = jQuery('#menu');
    for (a=0; a < arMenuItems.length; a++){
        
        /*** create the following structure for each element
         *   <div class="menuBlock active" id="mb1" onclick="SetActiveStatus(num);">
         *       <div class="leftBottomCorner"></div><div class="rightBottomCorner"></div>
         *   </div><div class="gap">&nbsp;<div class="vline"></div></div>
        ***/
            
        var n = document.createElement("div");
        jQuery(n).addClass("menuBlock");
        if ((a+1)==actPage) 
            jQuery(n).addClass("active");
        else
            jQuery(n).bind('click', {msg: a}, function(event){ 
                                                    SetActiveStatus(event.data.msg); });
        jQuery(n).attr("id", 'mb'+(a+1));
        jQuery(n).append(arMenuItems[a])
        /*
        var t = document.createElement("div");
        jQuery(t).addClass("leftBottomCorner");
        jQuery(t).appendTo(jQuery(n));
        t = document.createElement("div");
        jQuery(t).addClass("rightBottomCorner");
        jQuery(t).appendTo(jQuery(n));
        */
        tnode.append( n );
    
        if(a < arMenuItems.length-1)
        {
            var n1 = document.createElement("div");
            jQuery(n1).addClass("gap");
            jQuery(n1).html('&nbsp;');
            var n2 = document.createElement("div");
            jQuery(n2).addClass("vline");
            jQuery(n2).appendTo(jQuery(n1));
            tnode.append( n1 );
        }
    }
}
function SetUpBottomMenu()
{
        var action;
        //** footer menu
        for (var i=0; i< arMenuItems.length; i++)
        {
            action = ((i+1)!=actPage)? 'onclick="SetActiveStatus('+i+');"' : '';
            jQuery('#footerMenuLine').append('<div class="menuBlock" '+ action+'>'+arMenuItems[i]+'</div>');
        }

}

function SetGallerySlide(){

    
    var ho, ul, li, img;
    ho = jQuery(".holder");
    ul = document.createElement("ul");
    for (i=0; i<iGSlideImgNum;i++)
    {
        li = document.createElement("li");
        img = document.createElement("img");
        jQuery(img).attr("src", gGPath + (i+1)+".jpg");
        //jQuery(img).appendTo(jQuery(li)); 
        jQuery(ul).append(jQuery(li).append(jQuery(img)));
    }
    jQuery(ul).appendTo(ho);
   // alert(jQuery(ho).html());

 /* slideshow */
    var gallery1 = new slideGallery($$(".gallery1"), {
        steps: 2,
        mode: "circle",
        random: true,
        autoplay: false,
        stop: ".stop",
        start: ".start",
        duration: 4000,
        speed: 800
    }); 
/* end slideshow */

}

function wlog( content,flAddNew){
    var  id="logger";
    var dv = document.getElementById(id);
    
    if (!dv){
        dv = document.createElement('div');
        dv.setAttribute('id',id);
	    document.body.appendChild(dv);
	  //  dv.style.display="none";
    }
    
    if (flAddNew)
        document.getElementById(id).innerHTML =content+ "<br>"
    else
        document.getElementById(id).innerHTML =  document.getElementById(id).innerHTML +content+"<br>"
        
}

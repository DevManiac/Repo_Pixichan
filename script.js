





















/*//Das is ne funktion für nen Back-to-top button
var img = document.getElementById('sec_img');

// When the user scrolls down 150px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        img.src = 'img/index_fabi.png';
    } else {
        img.src = 'img/index_fabi_1.png';
    }
}

function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
*/

/*

function hello(id)
{
    var images = document.getElementsByClassName("img");

		var uploader = images[id].getAttribute("alt");
		alert(uploader);
	
	
}
*/


//Das ist mal ne uhr

setInterval(upTime,500);
function upTime()
{
  var dt = new Date();

    if(dt.getMinutes() <10)
    {
        document.getElementById("time").innerHTML =   dt.getHours() + ':0' + dt.getMinutes();
    }else
    {
        document.getElementById("time").innerHTML =   dt.getHours() + ':' + dt.getMinutes();
    }
}






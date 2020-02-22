const WARN_BEFORE = {d:0, h:2, m:30, s:0};
	WARN_BEFORE.distance = WARN_BEFORE.s * 1000 +
			WARN_BEFORE.m * 1000 * 60 +
			WARN_BEFORE.h * 1000 * 60 * 60 +
			WARN_BEFORE.d * 1000 * 60 * 60 * 24;
const BLINK_BEFORE = {d:0, h:0, m:30, s:0};
	BLINK_BEFORE.distance = BLINK_BEFORE.s * 1000 +
			BLINK_BEFORE.m * 1000 * 60 +
			BLINK_BEFORE.h * 1000 * 60 * 60 +
			BLINK_BEFORE.d * 1000 * 60 * 60 * 24;

function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}

function blink_text() {
	$('.blink').fadeOut(500);
	$('.blink').fadeIn(500);
}

function matchCountDown(el) {

	var matchStatus = el.data("statuscode");
	
	var matchDate = el.data("matchdate");
	if (!matchDate || (parseInt(matchStatus) == 1)) 
		return false;

	//Set the date we're counting down to
	var startofMatchDate = new Date(matchDate).getTime();

	var endofMatch = el.data("endmatchdate"); 
	if (endofMatch) 
		var endofMatchDate = new Date(endofMatch).getTime();
	else
		return false;

	
	//Update the count down every 1 second
	el.data("interval", setInterval(function() {
	
			// Get todays date and time
			var now = new Date().getTime();

			// Find the distance between now and the count down date
			var distance1 = startofMatchDate - now;

			// Find the distance between now and the count down date
			var distance2 = endofMatchDate - now;
			
			var msg = "";

			// only show something within x hrs before match
			if (distance1 < 0) {
				msg = el.data("statustextPlaying");

				// end of match
				if (distance2 < 0) {
					// If the match has ended, write some text 
					clearInterval(el.data("interval"));
					//el.removeAttribute('data-interval');
					el.removeClass('blink');
					msg = el.data("statustextEnd");
					el.html(msg);
				}
			} 
			else if (distance1 <= WARN_BEFORE.distance) {
				// Time calculations for days, hours, minutes and seconds
				var days = Math.floor(distance1 / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance1 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance1 % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance1 % (1000 * 60)) / 1000);
			
				// show countdown clock within x time before match
				//msg = "Start over " + msg + zeroPad(hours,2) + "u" + zeroPad(minutes,2) + ""; // + ":" + zeroPad(seconds,2);
				msg = sprintf(el.data("statustextTimer"), days>0? days+"d+": "", hours, minutes);

				// and let it blink when it is almost time
				if (distance1 <= BLINK_BEFORE.distance) {
					el.addClass('blink');
				}
			} 
			else {
				// it still takes a long time before before the match starts, so show nothing
				msg = "";
			}
			if (el.html() == "" || el.data('interval') != "") {
				el.html(msg);
			}
		}, 1000)
	);
	
	return true;
}

function loadjscssfile(filename, filetype){
    if (filetype=="js"){ //if filename is a external JavaScript file
        var fileref=document.createElement('script')
        fileref.setAttribute("type","text/javascript")
        fileref.setAttribute("src", filename)
    }
    else if (filetype=="css"){ //if filename is an external CSS file
        var fileref=document.createElement("link")
        fileref.setAttribute("rel", "stylesheet")
        fileref.setAttribute("type", "text/css")
        fileref.setAttribute("href", filename)
    }
    if (typeof fileref!="undefined")
        document.getElementsByTagName("head")[0].appendChild(fileref)
}
 
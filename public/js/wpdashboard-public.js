!function(e){var n=!1;if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){var o=window.wpc,t=window.wpc=e();t.noConflict=function(){return window.wpc=o,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var o=arguments[e];for(var t in o)n[t]=o[t]}return n}function n(o){function t(n,r,i){var c;if("undefined"!=typeof document){if(arguments.length>1){if("number"==typeof(i=e({path:"/"},t.defaults,i)).expires){var a=new Date;a.setMilliseconds(a.getMilliseconds()+864e5*i.expires),i.expires=a}i.expires=i.expires?i.expires.toUTCString():"";try{c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c)}catch(e){}r=o.write?o.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=(n=(n=encodeURIComponent(String(n))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape);var s="";for(var f in i)i[f]&&(s+="; "+f,!0!==i[f]&&(s+="="+i[f]));return document.cookie=n+"="+r+s}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],d=/(%[0-9A-Z]{2})+/g,u=0;u<p.length;u++){var l=p[u].split("="),C=l.slice(1).join("=");this.json||'"'!==C.charAt(0)||(C=C.slice(1,-1));try{var g=l[0].replace(d,decodeURIComponent);if(C=o.read?o.read(C,g):o(C,g)||C.replace(d,decodeURIComponent),this.json)try{C=JSON.parse(C)}catch(e){}if(n===g){c=C;break}n||(c[g]=C)}catch(e){}}return c}}return t.set=t,t.get=function(e){return t.call(t,e)},t.getJSON=function(){return t.apply({json:!0},[].slice.call(arguments))},t.defaults={},t.remove=function(n,o){t(n,"",e(o,{expires:-1}))},t.withConverter=n,t}return n(function(){})});
function guid(){function n(){return Math.floor(65536*(1+Math.random())).toString(16).substring(1)}return n()+n()+"-"+n()+"-"+n()+"-"+n()+"-"+n()+n()+n()}

(function( $ ) {
	'use strict';

	let wpdashboard_url = 'https://my.wpdashboard.io/';
	let wpdashboard_id = null;
	let wpdashboard_cookie = wpc.get('wp_u_c');
	if(!wpdashboard_cookie) {
		wpdashboard_cookie = wpc.get('__wpc');
		if(!wpdashboard_cookie) {
            wpdashboard_cookie = guid();
            wpc.set('wp_u_c', wpdashboard_cookie, {expires: 1825});
            wpc.set('__wpc', wpdashboard_cookie, {expires: 1825});
        }
	}

	$.ajax({
		url: wpdashboard_url + 'api/plugin/pageview/track/',
		method: 'POST',
		data: {
			'url': window.location.origin + window.location.pathname,
			'user_agent': navigator.userAgent,
			'referrer': document.referrer,
			'found': is_404,
			'key': wpdashboard_key,
			'c': wpdashboard_cookie
		},
		success: function(data) {
			wpdashboard_id = data.results.id;
		}
	});

	$(window).bind('beforeunload', function() {
        $.ajax({
            url: wpdashboard_url + 'api/plugin/pageview/track/' + wpdashboard_id,
			data: {
            	'c': wpdashboard_cookie
			},
            method: 'POST',
			success: function(data) {
            	return true;
			}
        });
	});

})( jQuery );

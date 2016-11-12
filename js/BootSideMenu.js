// sidemenu의 view를 위한 script

$(document).ready
(function ( $ ) {

	$.fn.BootSideMenu = function( options ) {

		var oldCode, newCode, side;

		newCode = "";

		var settings = $.extend({
			side:"left",
			autoClose:true
		}, options );

		side = settings.side;
		autoClose = settings.autoClose;

		this.addClass("container sidebar");

		if(side=="left"){
			this.addClass("sidebar-left");
		}else if(side=="right"){
			this.addClass("sidebar-right");
		}else{
			this.addClass("sidebar-left");
		}

		oldCode = this.html();

		newCode += "<div class=\"row\">\n";
		newCode += "	<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg1-12\" data-side=\""+side+"\">\n"+ oldCode+" </div>\n";
		newCode += "</div>";
		newCode += "<div class=\"toggler\">\n";
		newCode += "	<span class=\"glyphicon glyphicon-chevron-right\">&nbsp;</span> <span class=\"glyphicon glyphicon-chevron-left\">&nbsp;</span>\n";
		newCode += "</div>\n";

		//Mod suggested by asingh3
		//https://github.com/AndreaLombardo/BootSideMenu/issues/1

		//this.html(newCode);

    		var wrapper = $(newCode);
		// copy the children to the wrapper.
		$.each(this.children(), function () {
			$('.panel-content', wrapper).append(this);
		});

		// Empty the element and then append the wrapper code.
		$(this).empty();
		$(this).append(wrapper);

		if(autoClose){
			$(this).find(".toggler").trigger("click");
		}

	};

	$(document).on('click', '.sidebar .list-group-item', function(){
		$('.sidebar .list-group-item').each(function(){
			$(this).removeClass('active');
		});
		$(this).addClass('active');
	});


	$(document).on('click','.toggler', function(){
		var toggler = $(this);
		var container = toggler.parent();
		//var listaClassi = container[0].classList; //Old
		var listaClassi = $(container[0]).attr('class').split(/\s+/); //IE9 Fix - Thanks Nicolas Renaud
		var side = getSide(listaClassi);
		var containerWidth = container.width();
		var status = container.attr('data-status');
		if(!status){
			status = "opened";
		}
		doAnimation(container, containerWidth, side, status);
		console.log(container);
	});

	$(document).on('click','.chattoggler', function(){
		console.log('chattoggler on');

		$('.log-list').hide();
		$('.video-list').hide();
		$('.friend-list').show();

		var toggler = $(this);
		var container = $('.sidebar-right');
		//var listaClassi = container[0].classList; //Old
		var listaClassi = $(container[0]).attr('class').split(/\s+/); //IE9 Fix - Thanks Nicolas Renaud
		var side = getSide(listaClassi);
		var containerWidth = container.width();
		var status = container.attr('data-status');
		if(!status){
			status = "opened";
		}

		if(status != "opened"){
			doAnimation(container, containerWidth, side, status);
		}else{

		}
	});

	$(document).on('click','.videotoggler', function(){

		$('.log-list').hide();
		$('.friend-list').hide();
		$('.video-list').show();

		var toggler = $(this);
		var container = $('.sidebar-right');
		//var listaClassi = container[0].classList; //Old
		var listaClassi = $(container[0]).attr('class').split(/\s+/); //IE9 Fix - Thanks Nicolas Renaud
		var side = getSide(listaClassi);
		var containerWidth = container.width();
		var status = container.attr('data-status');
		if(!status){
			status = "opened";
		}

		if(status != "opened"){
			doAnimation(container, containerWidth, side, status);
		}else{

		}

	});

	$(document).on('click','.logtoggler', function(){

		$('.log-list').show();
		$('.friend-list').hide();
		$('.video-list').hide();
		var toggler = $(this);

		var container = $('.sidebar-right');
		//var listaClassi = container[0].classList; //Old
		var listaClassi = $(container[0]).attr('class').split(/\s+/); //IE9 Fix - Thanks Nicolas Renaud
		var side = getSide(listaClassi);
		var containerWidth = container.width();
		var status = container.attr('data-status');
		if(!status){
			status = "opened";
		}

		if(status != "opened"){
			doAnimation(container, containerWidth, side, status);
		}
	});

	/*Cerca un div con classe submenu e id uguale a quello passato*/
	function searchSubMenu(id){
		var found = false;
		$('.submenu').each(function(){
			var thisId = $(this).attr('id');
			if(id==thisId){
				found = true;
			}
		});
		return found;
	}

//restituisce il lato del sidebar in base alla classe che trova settata
function getSide(listaClassi){
	var side;
	for(var i = 0; i<listaClassi.length; i++){
		if(listaClassi[i]=='sidebar-left'){
			side = "left";
			break;
		}else if(listaClassi[i]=='sidebar-right'){
			side = "right";
			break;
		}else{
			side = null;
		}
	}
	return side;
}
//esegue l'animazione
function doAnimation(container, containerWidth, sidebarSide, sidebarStatus){
	var toggler = container.children()[1];
	var buttondiv = $('.side-button-menu');
	if(sidebarStatus=="opened"){
		if(sidebarSide=="left"){
			container.animate({
				left:-(containerWidth+2)
			});
			toggleArrow(toggler, "left");
		}else if(sidebarSide=="right"){
			container.animate({
				right:- (containerWidth +2)
			});
			buttondiv.animate({
				right:- 0
			});
			toggleArrow(toggler, "right");
		}
		container.attr('data-status', 'closed');
	}else{
		if(sidebarSide=="left"){
			container.animate({
				left:0
			});
			toggleArrow(toggler, "right");
		}else if(sidebarSide=="right"){
			container.animate({
				right:0
			});
			buttondiv.animate({
				right:containerWidth
			});
			toggleArrow(toggler, "left");
		}
		container.attr('data-status', 'opened');

	}

}

function toggleArrow(toggler, side){
	if(side=="left"){
		$(toggler).children(".glyphicon-chevron-right").css('display', 'block');
		$(toggler).children(".glyphicon-chevron-left").css('display', 'none');
	}else if(side=="right"){
		$(toggler).children(".glyphicon-chevron-left").css('display', 'block');
		$(toggler).children(".glyphicon-chevron-right").css('display', 'none');
	}
}

function onWindowResize() {
	 $(".toggler").each( function(){
		var container = $(this).parent();
		var listaClassi = $(container[0]).attr('class').split(/\s+/);
		var side = getSide(listaClassi);

		var status = container.attr('data-status');
		var containerWidth = container.width();
		if (status==="closed") {
			if(side=="left"){
				container.css("left",-(containerWidth+2))

			}else if(side=="right"){
				container.css("right",-(containerWidth+2))

			}
		}
	})
}
window.addEventListener('resize', onWindowResize, false);
}( jQuery ));

function addChatMessage(e) {
    var user = e.user || "NO_ONE";
    var message = e.message;
    var chatboxElement = e.chatbox;

    console.log(user);
    console.log(message);
    console.log(chatboxElement);

    if(e.messageType == 'chat'){
        chatboxElement.append('<br><p>' + user + " : " + message + '</p>');
    }else{
        chatboxElement.append(user + " : " + message + '\n');
    }
		console.log(chatboxElement.prop('scrollHeight'));
		chatboxElement.css('scrollHeight', 0);
}

// 배열 속성을 지우는 함수
Array.remove = function(array, from, to) {
    var rest = array.slice((to || from) + 1 || array.length);
    array.length = from < 0 ? array.length + from : from;
    return array.push.apply(array, rest);
};

// 현재 display 되어 있는 popup의 수
var total_popups = 0;

// popup의 id들
var popups = [];

// popup을 닫을 떄 사용하는 함수
function close_popup(id) // 종료하는 popup의 id를 인자값으로 받음
{
    for (var iii = 0; iii < popups.length; iii++) // popups 배열의 길이만큼 반복
    {
        if (id == popups[iii]) // popups 배열의 모든 id와 인자값으로 받은 id를 비교
        {
            Array.remove(popups, iii); // 지움

            document.getElementById(id).style.display = "none"; // display 되어 있던 popup창을 'none'으로

            calculate_popups();

            return;
        }
    }
}

// popup을 display하기 위한 함수.
//displays the popups. Displays based on the maximum number of popups that can be displayed on the current viewport width
function display_popups() {
    var right = 220; // 위치 변경을 위한 수치

    var iii = 0;
    for (iii; iii < total_popups; iii++) // popup의 갯수만큼 반복
    {
        if (popups[iii] != undefined) // 기존에 diplay 되어 있는 팝업이라면
        {
            var element = document.getElementById(popups[iii]);
            element.style.right = right + "px"; // 팝업의 위치를 'right' 수치만큼 이동(최초 220px)
            right = right + 320; // 다음 위치가 조절되는 popup은 기존의 320만큼 더 이동
            element.style.display = "block"; // diplay block
        }
    }

    // popup의 갯수가 한 화면에 표시되는 popup 갯수의 한도를 넘었을 경우,
    // 가장 먼저 호출한 popup부터 display = none
    for (var jjj = iii; jjj < popups.length; jjj++) {
        var element = document.getElementById(popups[jjj]);
        element.style.display = "none";
    }
}
// 새로운 popup을 등록. popups array에 id를 추가.
function register_popup(id, name) {
    for (var iii = 0; iii < popups.length; iii++) {
        // 이미 popups 배열에 존재하는 id라면
        if (id == popups[iii]) {
            Array.remove(popups, iii); // 배열에서 기존에 등록되있던 id를 remove

            popups.unshift(id); // 배열의 첫번째에 id를 추가

            calculate_popups();

            return;
        }
    }

    console.log('register_popup used, id : ' + id + ', name : ' + name);

    // chatox element 작성
    var element = '<div class="popup-box chat-popup" id="' + id + '">';
    element = element + '<div class="popup-head">';
    element = element + '<div class="popup-head-left">' + name + '</div>';
    element = element + '<div class="popup-head-right"><a href="javascript:close_popup(\'' + id + '\');">&#10005;</a></div>';
    element = element + '<div style="clear: both"></div></div><div class="popup-messages"></div>';
    element = element + '<input type="text" class="popup-input" onkeydown="sendChatMessage(event)"></div>';
    // innerHTML method로 작성된 element를 body[0]에 추가
    document.getElementsByTagName("body")[0].innerHTML = document.getElementsByTagName("body")[0].innerHTML + element;
    // 배열의 첫번쨰에 id를 추가
    popups.unshift(id);

    calculate_popups();

}

// 한번에 표시할 수 있는 popup의 갯수를 파악.
function calculate_popups() {
    // 화면의 넓이
    var width = window.innerWidth;
    // 페이지의 넓이가 540 이하일 경우 표시할 수 있는 popup의 갯수 0
    if (width < 540) {
        total_popups = 0;
    }
    else {
        width = width - 200;
        // popup box 한 개의 넓이는 320, 320으로 화면 크기를 나누어 표시할 최대 popup box의 갯수를 산정.
        //320 is width of a single popup box
        total_popups = parseInt(width / 320);
    }

    display_popups();

}

// 웹페이지가 'load'되거나 'resize' 될 경우 calculate_popups 함수를 체이싱.
window.addEventListener("resize", calculate_popups);
window.addEventListener("load", calculate_popups);

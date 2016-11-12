<style>
            @media only screen and (max-width : 540px)
            {
                .chat-sidebar
                {
                    display: none !important;
                }

                .chat-popup
                {
                    display: none !important;
                }
            }

            .chat-sidebar
            {
                width: 200px;
                position: fixed;
                height: 100%;
                right: 0px;
                top: 0px;
                padding-top: 10px;
                padding-bottom: 10px;
                border: 1px solid rgba(29, 49, 91, .3);
            }

            .sidebar-name
            {
                padding-left: 10px;
                padding-right: 10px;
                margin-bottom: 4px;
                font-size: 12px;
            }

            .sidebar-name span
            {
                padding-left: 5px;
            }

            .sidebar-name a
            {
                display: block;
                height: 100%;
                text-decoration: none;
                color: inherit;
            }

            .sidebar-name:hover
            {
                background-color:#e1e2e5;
            }

            .sidebar-name img
            {
                width: 32px;
                height: 32px;
                vertical-align:middle;
            }

            .popup-box
            {
                display: none;
                position: fixed;
                bottom: 0px;
                right: 220px;
                height: 285px;
                background-color: rgb(237, 239, 244);
                width: 300px;
                border: 1px solid rgba(29, 49, 91, .3);
                
            }

            .popup-box .popup-head
            {
                background-color: #6d84b4;
                padding: 5px;
                color: white;
                font-weight: bold;
                font-size: 14px;
                clear: both;
            }

            .popup-box .popup-head .popup-head-left
            {
                float: left;
            }

            .popup-box .popup-head .popup-head-right
            {
                float: right;
                opacity: 0.5;
            }

            .popup-box .popup-head .popup-head-right a
            {
                text-decoration: none;
                color: inherit;
            }

            .popup-box .popup-messages
            {
                height: 100%;
                overflow-y: scroll;
            }
            .img-btn{
                background: url("img/infoModButton.png") no-repeat;
                background-size: 100% auto;
                border: none;
                width:100%;
                position:absolute;
                padding:0;
            }
            .btn{
                width:100%;
            }
            .col-md-2{
                padding:0;
            }
            .navbar-fixed-bottom{
                margin-bottom:100px;
            }
            .fbody{
                bottom:50px;
            }
            .vbottom{
                vertical-align:bottom;
            }
</style>

<!-- 서버 통신과 관련된 기능 -->
<script>
        var io = io.connect('https://chat-webapp-by-node-server-karchev.c9users.io:8080');
        var sessionId = 'kim'

        console.log(sessionId);

        io.emit('saveMyData', { id : sessionId });

        // 메세지가 입력될 시 이벤트(서버로 메세지 전달)
        function inputChatMessage(e){
          if(e.keyCode == 13){
            console.log("ON KEYCODE 13");
            console.log(document.activeElement.value);
            var inputElement = document.activeElement;
            var parentOfInput = inputElement.parentNode;

            // 메세지 내용
            var new_message = document.activeElement.value;
            // 메세지를 받을 유저
            var toUser = parentOfInput.getAttribute('id');
            // 메세지 보내는 유저
            // 상수. 나중에 세션 값을 서버로 받아, 배열로 socket 서버에 접속 중인 각 유저의 socket.id와 id를 동시에 관리해 처리.
            var fromUser = 'kim';
            var chatboxElement = $('#' + toUser + ' > .popup-messages'); // 대화 내용을 출력할 chatbox element

            io.emit('send_chat_message',
            {
              from: fromUser,
              to: toUser,
              message: new_message
            });

            // 자신이 입력한 내용을 업로드
            addChatMessage({ user: "you", message: new_message, chatbox: chatboxElement } );
            $(inputElement).val('');

          }
        }
        io.on('recieveMessage', function(e){
          console.log('@for debug, message recieved : ' + JSON.stringify(e));
          fromUser = e.from; // 보낸 사람(chatbox id)
          toUser = e.to; // 나
          message = e.message; // 메세지 내용

          console.log(fromUser);

          register_popup(fromUser, fromUser);

          chatboxElement = $('#' + fromUser + ' > .popup-messages'); // chat box element

          addChatMessage({ user: fromUser, message: message, chatbox: chatboxElement })
        });
        function addChatMessage(e){
          var user = e.user || "NO_ONE";
          var message = e.message;
          var chatboxElement = e.chatbox;

          chatboxElement.append('<br><p>' + user + " : " + message + '</p>');
        }
        </script>
<!-- 뷰와 관련된 기능 -->
<script>
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
                for(var iii = 0; iii < popups.length; iii++) // popups 배열의 길이만큼 반복
                {
                    if(id == popups[iii]) // popups 배열의 모든 id와 인자값으로 받은 id를 비교
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
            function display_popups()
            {
                var right = 220; // 위치 변경을 위한 수치

                var iii = 0;
                for(iii; iii < total_popups; iii++) // popup의 갯수만큼 반복
                {
                    if(popups[iii] != undefined) // 기존에 diplay 되어 있는 팝업이라면
                    {
                        var element = document.getElementById(popups[iii]);
                        element.style.right = right + "px"; // 팝업의 위치를 'right' 수치만큼 이동(최초 220px)
                        right = right + 320; // 다음 위치가 조절되는 popup은 기존의 320만큼 더 이동
                        element.style.display = "block"; // diplay block
                    }
                }

                // popup의 갯수가 한 화면에 표시되는 popup 갯수의 한도를 넘었을 경우,
                // 가장 먼저 호출한 popup부터 display = none
                for(var jjj = iii; jjj < popups.length; jjj++)
                {
                    var element = document.getElementById(popups[jjj]);
                    element.style.display = "none";
                }
            }
            // 새로운 popup을 등록. popups array에 id를 추가.
            function register_popup(id, name)
            {
                for(var iii = 0; iii < popups.length; iii++)
                {
                    // 이미 popups 배열에 존재하는 id라면
                    if(id == popups[iii])
                    {
                        Array.remove(popups, iii); // 배열에서 기존에 등록되있던 id를 remove

                        popups.unshift(id); // 배열의 첫번째에 id를 추가

                        calculate_popups();

                        return;
                    }
                }

                console.log('register_popup used, id : ' + id + ', name : ' + name);

                // html 태그를 포함하여, element를 작성
                var element = '<div class="popup-box chat-popup" id="'+ id +'">';
                element = element + '<div class="popup-head">';
                element = element + '<div class="popup-head-left">'+ name +'</div>';
                element = element + '<div class="popup-head-right"><a href="javascript:close_popup(\''+ id +'\');">&#10005;</a></div>';
                element = element + '<div style="clear: both"></div></div><div class="popup-messages"></div>';
                element = element + '<input type="text" onkeydown="inputChatMessage(event)" style="position:absolute;bottom: 2px;left: 0;width: 295px;"></div>';
                // innerHTML method로 작성된 element를 body[0]에 추가
                document.getElementsByTagName("body")[0].innerHTML = document.getElementsByTagName("body")[0].innerHTML + element;
                // 배열의 첫번쨰에 id를 추가
                popups.unshift(id);

                calculate_popups();

            }

            // 한번에 표시할 수 있는 popup의 갯수를 파악.
            function calculate_popups()
            {
                // 화면의 넓이
                var width = window.innerWidth;
                // 페이지의 넓이가 540 이하일 경우 표시할 수 있는 popup의 갯수 0
                if(width < 540)
                {
                    total_popups = 0;
                }
                else
                {
                    width = width - 200;
                    // popup box 한 개의 넓이는 320, 320으로 화면 크기를 나누어 표시할 최대 popup box의 갯수를 산정.
                    //320 is width of a single popup box
                    total_popups = parseInt(width/320);
                }

                display_popups();

            }

            // 웹페이지가 'load'되거나 'resize' 될 경우 calculate_popups 함수를 체이싱.
            window.addEventListener("resize", calculate_popups);
            window.addEventListener("load", calculate_popups);

        </script>
<div class="row vbottom">
    <div class="container">
    
    </div>
</div>
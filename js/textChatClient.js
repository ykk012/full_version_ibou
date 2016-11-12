// text chat을 위한 client

  // debugging용, user id
  // socket 연결 변수
  var textChatSocket = io('https://chat-webapp-by-node-server-karchev.c9users.io:8082');
  
  function textChatInit(){
    // socket 서버에 자신의 id를 전송, socket 서버에 저장해둔다.
    // 연결을 끊을 때 서버 쪽에서 저장하고 있던 id는 소멸
    if(typeof myId == "undefined" || myId == null){
      console.log("@debugging log :: No id");
    }else{
      console.log('user in emited');
      textChatSocket.emit('userIn', { id : myId });
    }
  }

  // @@@사이드바의 유저 목록을 갱신하기 위한 이벤트 start
  textChatSocket.on('res_sidebar_data', function(e){
    console.log('@debugging log :: 사이드바의 현재 접속 유저 목록을 갱신하기 위한 이벤트');
    console.log('@debugging log :: 전달받은 Obj, ' + JSON.stringify(e));

    e.forEach(function(userid, index) {
        var element = null;
        console.log(Object.keys(userid));
        var userStrId = Object.keys(userid);
        userStrId = "'" + userStrId + "'"
        if(Object.keys(userid) != myId){
        // element = '<a class="list-group-item" name=' + userStrId + ' href="javascript:register_popup(' + userStrId + ', ' + userStrId + ');">' + Object.keys(userid) + '</a>';
        element = '<a class="list-group-item" name=' + userStrId + ' onclick="register_popup(' + userStrId + ', ' + userStrId + ');">' + Object.keys(userid) + '</a>';
        }
        console.log(element);

        $('.friend-list').append(element)
    })
  })
  // @@@사이드바의 유저 목록을 갱신하기 위한 이벤트 end

  // @@@다른 유저의 연결, 연결이 끊어진 것과 관련된 이벤트  start
  textChatSocket.on('another_user_in', function(e){
    console.log('@debugging log :: 다른 유저가 접속했을 시의 이벤트');
    console.log('@debugging log :: 전달받은 Obj, ' + JSON.stringify(e));

    // frien-list에 추가할 element var
    var element = null;
    // 접속한 user의 id, string
    var userStrId = "'" + e.userId + "'";

    // element의 작성, element의 name attribute를 userStrId로
    element = '<a class="list-group-item" name=' + userStrId + ' onclick="register_popup(' + userStrId + ', ' + userStrId + ');">' + e.userId + '</a>';
    // append(jquery ajax)
    $('.friend-list').append(element);
  });

  textChatSocket.on('another_user_out', function(e) {
    console.log('@debugging log :: 다른 유저가 접속을 끊었을 시의 이벤트');
    console.log('@debugging log :: 전달받은 Obj, ' + JSON.stringify(e));

    // 연결을 끊은 user의 id, string
    var userStrId = '"' + e.userId + '"';

    // 연결을 끊은 user의 id(string)을 name selector로 사용해 제거(ajax)
    $('a[name*=' + userStrId  +']').remove();
  })
  // @@@다른 유저의 연결, 연결이 끊어진 것과 관련된 이벤트  end

  // @@@채팅 메세지를 주고 받기 위한 이벤트 start
  function sendChatMessage(e){
    console.log("check");
    if(e.keyCode == 13){
      console.log('@debugging log :: ENTER KEY(keycode 13) 입력 확인');
      console.log('@debugging log :: 엔터를 눌렀을 당시 포커싱 된 text input 메뉴의 값, ' + document.activeElement.value);

      // 현재 포커싱된 input menu의 element, 채팅 메세지 입력 후 입력창의 텍스트를 지우기 위함.
      var activatedElement = document.activeElement;
      // 현재 포커싱된 input menu의 parent element, 이 값으로 어느 유저에게 보내는 메세지인지 판단
      var parentOfActivateElement = activatedElement.parentNode;
      // 현재 포커싱된 input menu의 parent element의 'id' attribute, 메세지를 받을 유저, 'send_chat_message.emit' 이벤트를 통해 서버로 전달됨
      var toUser = parentOfActivateElement.getAttribute('id');
      // 현재 포커싱된 input menu element에 입력된 값, 서버에 '전달할 메세지'로 전해짐
      var messageValue = activatedElement.value;
      // 자신이 입력될 메세지가 출력될 chatbox의 element
      var chatboxElement = $('#' + toUser + '>.popup-messages');


      // 서버로 자신의 아이디, 메세지를 전달할 상대방의 id, 그리고 메세지를 전달
      textChatSocket.emit('send_chat_message', {
        from    : myId,
        to      : toUser,
        message : messageValue
      })

      // 자신이 입력한 내용을 input menu 상위의 chatbox에 업로드
      addChatMessage({
        user        : myId,
        message     : messageValue,
        chatbox     : chatboxElement,
        messageType : 'chat'
      })

      // input menu의 val을 비움
      $(activatedElement).val('')
    }
  }

  textChatSocket.on('recieveMessage', function(e){
    console.log('@debugging log :: 다른 유저에게서 메세지를 받았을 때의 이벤트');
    console.log('@debugging log :: 전달받은 Obj, ' + JSON.stringify(e));

    var fromUser = e.from; // 보낸 사람(chatbox id)
    var toUser = e.to; // 나
    var message = e.message; // 메세지 내용

    // chat box, 메세지를 보낸 유저에 해당하는
    register_popup(fromUser, fromUser);

    // register_popup으로 생성된 chat box의 element
    var chatboxElement = $('#' + fromUser + ' > .popup-messages'); // chat box element

    // 채팅 메세지 등록
    addChatMessage({
        user: fromUser,
        message: message,
        chatbox: chatboxElement,
        messageType: 'chat'
    })
  })
  // @@@채팅 메세지를 주고 받기 위한 이벤트 end
  
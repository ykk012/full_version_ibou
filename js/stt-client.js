function sttInit() {

    var url = document.location.href;
    var sttServer = io.connect("https://stt-test-karchev.c9users.io:8080");
    // 수정 필요
    sttServer.emit('connected', {
        'room': url.substr(url.lastIndexOf("/") + 1),
        'id': 'lee'
    });
    
    sttServer.on('broadcast_trancscript', function(e) {
        console.log(JSON.stringify(e));
        var time = new Date();
        time = time.getMonth() + "/" + time.getDay() + " " + time.getHours() + ":" + time.getMinutes() + ":" + time.getSeconds();
        var finalTranscript = e.transcript;
        var from = e.from;
        // $('#logTextArea').val($('#logTextArea').val() + "[" + time + "]" + " " + from + " : " + finalTranscript + "\n");
        $('#logTextArea').append("[" + time + "]" + " " + from + " : " + finalTranscript + "<br/>");
    });

    var finalTranscript = '';
    var recognizing = false;
    
    $('document').ready(function() {
        
        $('#logArea').hide();
        if (!('webkitSpeechRecognition' in window)) {
            alert("당신의 브라우저는 STT 기능을 지원하지 않습니다!");
        }
        
        else {
            var recognition = new webkitSpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;
            recognition.lang = 'ja'; // 언어 설정
            recognition.onstart = function() {
                recognizing = true;
                $('#start_button').html('STOP');
            };

            recognition.onerror = function(event) {
                console.log("STT 기능 에러 발생");
                $('#start_button').html('다시 시작');
            };

            recognition.onend = function() {
                console.log('recognition 끝');
                recognizing = false;
                $('#instructions').html('&nbsp;');
                $('#start_button').html('다시 시작');
            };

            recognition.onresult = function(event) {
                var interimTranscript = '';
                // Assemble the transcript from the array of results
                for (var i = event.resultIndex; i < event.results.length; ++i) {
                    if (event.results[i].isFinal) {
                        finalTranscript += event.results[i][0].transcript;
                    }
                    else {
                        interimTranscript += event.results[i][0].transcript;
                    }
                }
                console.log("interim:  " + interimTranscript);
                console.log("final:    " + finalTranscript);
                // update the page
                if (finalTranscript.length > 0) {
                    var time = new Date();
                    time = time.getMonth() + "/" + time.getDay() + " " + time.getHours() + ":" + time.getMinutes() + ":" + time.getSeconds();
                    // $('#logTextArea').val($('#logTextArea').val() + "[" + time + "]" + " " + myId + " : " + finalTranscript + "\n");
                    $('#logTextArea').append("[" + time + "]" + " " + myId + " : " + finalTranscript + "<br/>");
                    sttServer.emit('transcriptBroadCast', {
                        'room': url.substr(url.lastIndexOf("/") + 1),
                        'transcript': finalTranscript,
                        'from' : myId
                    });
                    recognition.stop();
                    recognizing = false;
                }
            };

            $("#start_button").click(function(e) {
                e.preventDefault();
                if (recognizing) {
                    recognition.stop();
                    $('#start_button').html('STT START');
                    recognizing = false;
                }
                else {
                    finalTranscript = '';
                    // Request access to the User's microphone and Start recognizing voice input
                    recognition.start();
                    $('#start_button').html('waiting');
                    $('#transcript').html('&nbsp;');
                }
            });
        }
        
        // workbench 내 채팅 처리
        $('#roomChatInput').keypress(function (e) {
            console.log('addevent!!!!');
            var key = e.which || e.keyCode;
            if (key === 13) { 
                console.log("roomChat enter");
             	var roomChatText = $('#roomChatInput').val();
             	var time = new Date();
             	time = time.getMonth() + "/" + time.getDay() + " " + time.getHours() + ":" + time.getMinutes() + ":" + time.getSeconds();
             	$('#roomChatInput').val('');
             	sttServer.emit('transcriptBroadCast', {'room' : url.substr(url.lastIndexOf("/")+1),'transcript' : roomChatText, 'from' : myId});
             	// $('#logTextArea').val($('#logTextArea').val() + "[" + time + "]" + " " + myId + " : " + roomChatText + "\n");
             	$('#logTextArea').append("[" + time + "]" + " " + myId + " : " + roomChatText + "<br/>");
            }
        });
        
        $('#roomChatButton').click(function(){
            console.log('click!');
        })
    });


    
};
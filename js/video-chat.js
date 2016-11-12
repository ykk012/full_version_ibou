
    // WebRTC 설정
    var SIGNALING_SERVER = "https://group-chgat-slide-karchev.c9users.io:8080";
    var USE_AUDIO = true;
    var USE_VIDEO = {
      "mandatory": {
       "minWidth": "140",
       "maxWidth": "140",
       "minHeight": "140",
       "maxHeight": "140",
       "minFrameRate": "30"
      },
      "optional": []
    }
    var DEFAULT_CHANNEL = '';
    var MUTE_AUDIO_BY_DEFAULT = false;

    // stun 서버로 google 서버 사용
    var ICE_SERVERS = [
        {url:"stun:stun.l.google.com:19302"}
    ];

    var signaling_socket = io.connect(SIGNALING_SERVER);   // socket.io 링크
    var local_media_stream = null; // 로컬 스트림
    var peers = {};                // 피어 링크
    var peer_media_elements = {};  // 비디오 출력 속성

    function videoChatInit() {
        DEFAULT_CHANNEL = 'test1';
        console.log("Connecting to signaling server");
        // io 서버 연결
        // connect 이벤트 emit
        signaling_socket.on('connect', function() {
            console.log("Connected to signaling server");
            // 로컬 미디어 설정
            setup_local_media(function() { // LINE : 237
                // 채널 접속, 피어 연결 시작
                join_chat_channel(DEFAULT_CHANNEL, myId); // LINE : 67
            });
        })
        // 서버와 연결 끊길 경우
        signaling_socket.on('disconnect', function() {
            console.log("Disconnected from signaling server");
            // 모든 피어 정보 말소
            for (peer_id in peer_media_elements) {
                peer_media_elements[peer_id].remove();
            }
            // 피어 연결 닫기
            for (peer_id in peers) {
                peers[peer_id].close
            }
            // 초기화
            peers = {};
            peer_media_elements = {};
        });
        // 채널 접속을 위한 함수(join 이벤트 emit)
        function join_chat_channel(channel, userdata) {
            signaling_socket.emit('join', {"channel": channel, "userdata": userdata});
        }
        // 채널 말소를 위한 함수(part 이벤트 emit)
        function part_chat_channel(channel) {
            signaling_socket.emit('part', channel);
        }

        // 피어 추가
        signaling_socket.on('addPeer', function(config) {
            console.log('Signaling server said to add peer:', JSON.stringify(config));
            var peer_id = config.peer_id;
            var user_id = config.userdata;
            console.log("user's Id : " + user_id);
            if (peer_id in peers) {
                // 이미 해당 피어 연결이 존재할 경우
                console.log("Already connected to peer ", peer_id);
                return;
            }
            // 피어 연결
            var peer_connection = new RTCPeerConnection(
                {"iceServers": ICE_SERVERS},
                {"optional": [{"DtlsSrtpKeyAgreement": true}]}
            );
            peers[peer_id] = peer_connection;

            // JSEP 요청
            peer_connection.onicecandidate = function(event) {
                if (event.candidate) {
                    signaling_socket.emit('relayICECandidate', {
                        'peer_id': peer_id,
                        'ice_candidate': {
                            'sdpMLineIndex': event.candidate.sdpMLineIndex,
                            'candidate': event.candidate.candidate
                        }
                    });
                }
            }
            peer_connection.onaddstream = function(event) {
                console.log("onAddStream", event);
                var remote_media = USE_VIDEO ? $("<video>") : $("<audio>");
                remote_media.attr("autoplay", "autoplay");
                if (MUTE_AUDIO_BY_DEFAULT) {
                    remote_media.attr("muted", "true");
                }
                remote_media.attr("controls", "");
                peer_media_elements[peer_id] = remote_media;
                $('#videoArea').append(remote_media);
                
                attachMediaStream(remote_media[0], event.stream);
            }

            peer_connection.addStream(local_media_stream);

            if (config.should_create_offer) {
                console.log("Creating RTC offer to ", peer_id);
                peer_connection.createOffer(
                    function (local_description) {
                        console.log("Local offer description is: ", local_description);
                        peer_connection.setLocalDescription(local_description,
                            function() {
                                signaling_socket.emit('relaySessionDescription',
                                    {'peer_id': peer_id, 'session_description': local_description});
                                console.log("Offer setLocalDescription succeeded");
                            },
                            function() { Alert("Offer setLocalDescription failed!"); }
                        );
                    },
                    function (error) {
                        console.log("Error sending offer: ", error);
                    });
            }
        });

        signaling_socket.on('sessionDescription', function(config) {
            console.log('Remote description received: ', config);
            var peer_id = config.peer_id;
            var peer = peers[peer_id];
            var remote_description = config.session_description;
            console.log(config.session_description);

            var desc = new RTCSessionDescription(remote_description);
            var stuff = peer.setRemoteDescription(desc,
                function() {
                    console.log("setRemoteDescription succeeded");
                    if (remote_description.type == "offer") {
                        console.log("Creating answer");
                        peer.createAnswer(
                            function(local_description) {
                                console.log("Answer description is: ", local_description);
                                peer.setLocalDescription(local_description,
                                    function() {
                                        signaling_socket.emit('relaySessionDescription',
                                            {'peer_id': peer_id, 'session_description': local_description});
                                        console.log("Answer setLocalDescription succeeded");
                                    },
                                    function() { Alert("Answer setLocalDescription failed!"); }
                                );
                            },
                            function(error) {
                                console.log("Error creating answer: ", error);
                                console.log(peer);
                            });
                    }
                },
                function(error) {
                    console.log("setRemoteDescription error: ", error);
                }
            );
            console.log("Description Object: ", desc);

        });

        signaling_socket.on('iceCandidate', function(config) {
            var peer = peers[config.peer_id];
            var ice_candidate = config.ice_candidate;
            peer.addIceCandidate(new RTCIceCandidate(ice_candidate));
        });

        signaling_socket.on('removePeer', function(config) {
            console.log('Signaling server said to remove peer:', config);
            var peer_id = config.peer_id;
            if (peer_id in peer_media_elements) {
                peer_media_elements[peer_id].remove();
            }
            if (peer_id in peers) {
                peers[peer_id].close();
            }

            delete peers[peer_id];
            delete peer_media_elements[config.peer_id];
        });
    }

    function setup_local_media(callback, errorback) {
        if (local_media_stream != null) {
            if (callback) callback();
            return;
        }

        console.log("Requesting access to local audio / video inputs");

        navigator.getUserMedia  = navigator.getUserMedia ||
                  navigator.webkitGetUserMedia ||
                  navigator.mozGetUserMedia ||
                  navigator.msGetUserMedia;

        navigator.getUserMedia({"video":USE_VIDEO, "audio":USE_AUDIO},
            function(stream) {
                console.log("Access granted to audio/video");
                local_media_stream = stream;
                var local_media = USE_VIDEO ? $("<video>") : $("<audio>");
                local_media.attr("autoplay", "autoplay");
                local_media.attr("muted", "true");
                local_media.attr("controls", "");
                $('#videoArea').append(local_media);
                
                attachMediaStream(local_media[0], stream);

                if (callback) callback();
            },
            function() {
                console.log("Access denied for audio/video");
                alert("비디오, 오디오 장치를 찾을 수 없거나, 액세스가 거부되었습니다.");
                if (errorback) errorback();

            });
    }
    
    signaling_socket.on('other_user_disconnect', function(event){
        var disconnectedUser = event.userdata;
        $('.' + disconnectedUser).remove();
    })
    
    function toggleChatSideMenu(){
        console.log('slide toggle');
        $('#videoArea').slideToggle();
    }
    



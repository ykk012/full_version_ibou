$(document).ready(function() {
    expiration_check('loginInfo'); 
    $('.page').each(function() {
        $(this).css('display', 'inline-block');
        $(this).hide();
    });

    $('#login').bind('click', function() { //로그인
        expiration_check('loginInfo'); 
        var data = {
            m_id: $('#login_id').val(),
            m_pwd: $('#login_pwd').val()
        };
        json = JSON.stringify(data);
        var req = createRequestObject();
        console.log(json);

        req.open("POST", "https://project-board-css-karchev.c9users.io/member/login", true);
        req.setRequestHeader("Content-Type", "application/json"); //URL : 경로

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                var get_data = JSON.parse(req.responseText);
                console.log(get_data);
                my_sessionStorage('loginInfo',get_data);
                
                console.log(JSON.parse(sessionStorage.getItem('loginInfo')));
                $('#loginpage').hide();
                $('#loginedpage').show();
                if (document.getElementById('loginuser')) {
                    $('#loginuser').remove();
                }
                $('#loginedpage').append("<p id='loginuser'>" + get_data.m_name + ' 님, 환영합니다.</p>');

            }
            console.log(req.readyState);
        }
        req.send(json);
    })

    $('#logout').bind('click', function() { //로그아웃
        sessionStorage.removeItem('loginInfo');
        var req = createRequestObject();
        req.open("POST", "https://project-board-css-karchev.c9users.io/member/logout", true);


        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                $('#loginedpage').hide();
                $('#loginpage').show();
            }
            console.log(req.readyState);
        }
        req.send();

    });

    $('#join').bind('click', function() {
        if ($('#InputPassword').val() != $('#InputConfirm').val()) {
            return;
        }
        data = {
            m_id: $('#InputId').val(),
            m_pwd: $('#InputPassword').val(),
            m_name: $('#InputName').val()
        };
        json = JSON.stringify(data);
        var req = createRequestObject();
        console.log(json);

        req.open("POST", "https://project-board-css-karchev.c9users.io/member/joinus", true);
        req.setRequestHeader("Content-Type", "application/json"); //URL : 경로

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                $('#joinpage').hide();
                $('#loginpage').show();
            }
        }
        req.send(json);

    });

    $('#withdraw').bind('click', function() { //회원탈퇴
        var loginInfo = JSON.parse(sessionStorage['loginInfo']);
        data = {
            m_num: loginInfo.m_num
        };
        json = JSON.stringify(data);
        var req = createRequestObject();
        console.log(json);

        req.open("POST", "https://project-board-css-karchev.c9users.io/member/withdrawMember", true);
        req.setRequestHeader("Content-Type", "application/json"); //URL : 경로

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                $('#infopage').hide();
                $('#loginpage').show();
                alert("탈퇴성공");
            }
        }
        req.send(json);
    });

    $('#loginedToInfo').bind('click', function() {
        $('#loginedpage').hide();
        $('#infopage').show();
        var loginInfo = JSON.parse(sessionStorage['loginInfo']);
        console.log(loginInfo);
        $('#infoID').attr('value', loginInfo.m_id);
        $('#infoName').attr('value', loginInfo.m_name);
    });

    $('#infoToModify').bind('click', function() {
        $('#infopage').hide();
        $('#modifypage').show();
        var loginInfo = JSON.parse(sessionStorage['loginInfo']);
        $('#modID').attr('value', loginInfo.m_id);
        $('#modName').attr('value', loginInfo.m_name);
    });

    $('#modify').bind('click', function() {
        modData = {};
        if ($('#modPassword').val() != $('#modConfirm').val()) {
            return;
        }
        if ($('#modPassword').val().indexOf("") != -1) {
            modData.m_pwd = $('#modPassword').val();
        }
        if ($('#modName').val().indexOf("") != -1) {
            modData.m_name = $('#modName').val();
        }
        expiration_check('loginInfo'); 
        if(sessionStorage.getItem('loginInfo')){
            modData.m_num = JSON.parse(sessionStorage.getItem('loginInfo')).content.m_num;
        }
        data = modData;
        json = JSON.stringify(data);
        var req = createRequestObject();
        console.log(data);

        req.open("POST", "https://project-board-css-karchev.c9users.io/member/modifyMember", true);
        req.setRequestHeader("Content-Type", "application/json"); //URL : 경로

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                var loginInfo = JSON.parse(req.responseText);
                sessionStorage.setItem('loginInfo', JSON.stringify(loginInfo));
                $('#modifypage').hide();
                $('#infopage').show();
                alert("수정 완료");
            }
            console.log(req.readyState);
        }
        req.send(json);
    });

    $('#loginToJoin').bind('click', function() {
        $('#loginpage').hide();
        $('#joinpage').show();

    });

    $('#loginedToInfo').bind('click', function() {
        $('#loginedpage').hide();
        $('#infopage').show();
    });

    $('#modifyToInfo').bind('click', function() {
        $('#modifypage').hide();
        $('#infopage').show();
    });

    $('#joinToLogin').bind('click', function() {
        $('#joinpage').hide();
        $('#loginpage').show();
    });

    $('#infoToLogined').bind('click', function() {
        $('#infopage').hide();
        $('#loginedpage').show();
    });
    
    if (sessionStorage.getItem('loginInfo') === undefined || sessionStorage.getItem('loginInfo') === null || sessionStorage.getItem('loginInfo').length === 0) {
        $('#loginpage').show();
    }
    else {
        $('#loginedpage').show();
        $('#loginedpage').append("<h3 id='loginuser'>" + JSON.parse(sessionStorage.getItem('loginInfo')).content.m_name + ' 님, 환영합니다.</h3>');
    }
});
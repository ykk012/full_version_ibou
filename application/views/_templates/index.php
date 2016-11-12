
<?php 
$userInfo = $this->session->userdata['mInfo'];
$nick = $userInfo->m_nick;
?>

<script type="text/javascript">
$(document).ready(function(){
	$('#sendMessage').click(function(){
		$('inputSendMessage').append("<input type='text'/>");
	});
});
</script>

<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<div class="container-fluid col-xs-10 col-md-6">

    <div class="jumbotron" >
        <div class="list-content"  >
        <?php $friend = $this->session->flashdata('friendsList'); 
        ?>
        <ul class="list-group">
            <li href="#" class="list-group-item title">
                Your friend List
            </li>

            <!-- for each문 돌려서 출력 -->

            <?php
            if(isset($friend)){
            foreach($friend as $key){
             ?>
            <li href="#" class="friend_list list-group-item text-left" id="<?php echo $key->m_no; ?>" >
                <img class="img-thumbnail"  src="http://bootdey.com/img/Content/user_1.jpg">
                <label class="pull-right">
                    <a  class="btn btn-success btn-xs glyphicon glyphicon-ok" href="/index.php/friends/fInfo/<?php echo $key->m_no; ?>/" title="View"></a>
                    <a  class="btn btn-danger  btn-xs glyphicon glyphicon-trash" href="#" title="Delete"></a>
                    <a  class="btn btn-info  btn-xs glyphicon glyphicon glyphicon-comment" 
                    href='/index.php/Alarm/openInputMessage?from=' + key target="_blank" title="Send message" id="sendMessage"></a>      
                </label>
                <label class="name">
                    Nickname : <?php echo $key->m_nick ?>
                </label>
                <label class="comment">
                    Comment : This is User comment.
                </label>
                <div class="break"></div>
                <form class="inputSendMessage" action="/index.php/Alam/sendMessage" method="post">
            	</form>
            </li>
            
            <?php }} else {?>
            <li href="#" class="friend_list list-group-item text-left">
                <label class="commnet">등록된 친구가 없습니다.</label>
                <div class="break"></div>
            </li>
            <?php }?>
            <!-- 여기까지 -->


            <!--<li href="#" class="more list-group-item text-left">
                <a class="btn btn-block btn-primary">
                    <i class="glyphicon glyphicon-refresh"></i>
                    Load more...
                </a>
            </li>-->

        </ul>
        </div>
    </div>
</div>

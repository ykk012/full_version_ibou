
<style>
    .body{
        width:100%;
        height:700px;
        text-align: center;
    }


    .T_left{
        width:50%;
        height:700px;
        float:left;
        background-color: ;
        text-align:left;
    }
    .T_right{
        width:50%;
        height:700px;
        float:left;
        background-color: ;
        text-align:center;


    }
</style>


<div class="body">

    <div class="T_left">
        <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open('Team/Team_NameUpdate',$attributes);
      
    echo"<h4>チームの名: <input type='text'  name='team_name' placeholder='チームの名' value='{$team_name}'>
              <input type='hidden' name='t_num' value='{$t_num}'>
        <input class='btn btn-success' type='submit' value='変更'><br><h4></form>";
        ?>

        <div class="">
         
            <?php
            $cnt=count($f_list); //배열길이샘
            
            echo "<BR><h2>フレンドリスト</h2> ";

            for($i=0;$i<$cnt;$i++) {
                $attributes = array('class' => '클래스명 적어라');
                echo form_open('Team/Team_Friendsinsert',$attributes);
                $name = $f_list[$i]->m_id;
                echo" <h4>$name<input type='hidden'  name='id' value='{$name}'>
                         <input type='hidden' name='t_num' value='{$t_num}'>
                       <input class='btn btn-info'type='submit' value='チーム招待'></h4></form>";
            }

            ?>
        </div>
        <div class="">

            <?php
            $cnt=count($t_member); //배열길이샘
            echo"<br>";
            echo "<h2>チームメンバー</h2> ";
            for($i=0;$i<$cnt;$i++) {

                $attributes = array('class' => '클래스명 적어라');
                echo form_open('Team/user_delete_admin',$attributes);
                $name = $t_member[$i]->m_name;
                if($name==$user_name){
                   echo"<h3>リーダー&nbsp:&nbsp$name</h3></form>";
                }
              else{
                echo" <h3>$name<input type='hidden'  name='name' value='{$name}'>
                         <input type='hidden' name='t_num' value='{$t_num}'>
                <input class='btn btn-info ' type='submit' value='強制脱退'></h3></form>";
              }

            }
                
            
            ?>
        </div>

    
        <?php
        $attributes = array('class' => '클래스명 적어라');
        echo form_open('Team/Team_delete_team',$attributes);
      
        echo" <input type='hidden'  name='t_name' value='{$team_name}'>
                       <input class='btn btn-danger btn-lg' type='submit' value='チーム削除'></form>";
                       
       $attributes = array('class' => '클래스명 적어라');
        echo form_open('Team/index',$attributes);

        echo" <input  class='btn btn-default btn-lg' type='submit' value='帰る'></form>";
        ?>
        <br><br>

    </div>
    <div class="T_right">
        <h1>私のチーム</h1>
              
     <!--       	<div class="contents">-->
				 <!--   <p>Name:베이비웨어러블기기</p>-->
					<!--<p>C_Date : 2016-07-04 </p>-->
     <!--           <a href="/workbench/connect/19"><button >참가</button></a>-->
			  <!--   </div>-->
		
			     
        
         <?php
        // //강퇴부분추가하기(만들기)++++++++++
        // $cnt=count($t_list); //배열길이샘
        // for($i=0;$i<$cnt;$i++) {
        //     $name = $t_list[$i]->t_name;
        //     echo"<h2>$name</h2>";
        // }
        // ?>
  

    </div>
    
</div>
<?php echo validation_errors(); ?>
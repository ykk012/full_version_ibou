
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

        echo"<h1>チームの名 : $team_name</h1>";
        ?>

        <div class="">
       
            <?php
            $cnt=count($t_member); //배열길이샘
     
            echo "<h3>チームメンバー</h3> ";
            for($i=0;$i<$cnt;$i++) {
                $name = $t_member[$i]->m_name;
                if($i==0){
                echo"<h4>リーダー:$name</h4>";
                }
                else{
                    echo"<h4>$name</h4>";
                }
            }
            $attributes = array('class' => '클래스명 적어라');
            echo form_open('Team/Team_delete_user',$attributes);
            echo" <input type='hidden'  name='t_name' value='{$team_name}'>
                       <input class='btn btn-danger' type='submit' value='脱退'></form>";
                       
            $attributes = array('class' => '클래스명 적어라');
            echo form_open('Team/index',$attributes);

            echo" <input class='btn btn-default' type='submit' value='帰る'></form>";
            ?>
        </div>



    </div>
    <div class="T_right">
        <h1>私のチーム</h1>
    	<!--<div class="contents">-->
				 <!--   <p>Name:베이비웨어러블기기</p>-->
					<!--<p>C_Date : 2016-07-04 </p>-->
     <!--           <a href="/workbench/connect/19"><button >참가</button></a>-->
			  <!--   </div>-->
	
			  
        
        
        
         <?php
        // $cnt=count($t_list); //배열길이샘
        // for($i=0;$i<$cnt;$i++) {
        //     $name = $t_list[$i]->t_name;
        //     echo"<h2>$name</h2>";
        // }
        // ?>


    </div>

</div>
<?php echo validation_errors(); ?>
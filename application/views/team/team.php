<style>
    .body{
        width:100%;
        height:400px;
        text-align: center;
        
        
    }
    .f_serch{
        width:400px !important;
        margin : 0px;
        
    }
    .team_div{
    width:300px;
    display : inline-block;
    
    border: 1px solid white;
    
    
    }
    .div_context{
        display :inline-block;
        text-align: center;
    }
    .team_div form{
        float : left;
        margin-left: 100px;
        margin-right: 100px;
    }
    .btn{
        width: 100px !important;
    } 

    

</style>
<div class="body">

    <div>
        <a class="btn btn-success "  href="/Team/Team_Mpage">チーム作り</a>
    </div>
    <div>
                <?php
                $cnt=count($list);
                for($index1 = 0 ; $index1 < $cnt ; $index1++){
                    echo "<div class='team_div'><div class='div_context'>";
                    for($index2 =0 ; $index2 < count($list[$index1]) ; $index2++){
                        $attributes = array('class' => '클래스명 적어라');
                    
                        echo form_open('Team/Team_info',$attributes);
                        $name = $list[$index1][$index2]->t_name;
                        echo "<h3>$name</h3><input type='hidden'  name='team_name' value='{$name}'><input class='btn btn-info' type='submit' value='チーム管理'></form>";
                    }
                    echo "</div></div>";
                }
                ?>
    </div>
</div>
  
<?php echo validation_errors(); ?>
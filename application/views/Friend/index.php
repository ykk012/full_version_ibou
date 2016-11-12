<style>
    .body{
        width:100%;
        height:400px;
        display: inline-block;
        text-align: center;
    }
    .f_serch{
        width: 300px !important;
        height:400px;
  
    }
    .form_line{
        text-align: left;
    }
    .btn{
        width: 100px !important;
    }

</style>
<?php
$attributes = array('class' => '클래스명 적어라'); ?>


<div class="body">

        <?php echo form_open('Member/search',$attributes); ?>        
            <input type="text" placeholder="SearchID" name="SearchID">
            <input class='btn btn-default' type="submit" value="Search" >
       
        </form>
       
        <div class="">
            <ul class="">
                <?php
                if($list!=null) {
                    $cnt=count($list); //배열길이샘
                    
              
                    for($i=0;$i<$cnt;$i++){
                        $attributes = array('class' => 'form_line');
                        echo form_open('Friend/Insert_Friend',$attributes);//폼열기

                        $name=$list[$i]->m_id;
                        echo" $name<input type='hidden'  name='id' value='{$name}'>
                         <input type='hidden'  name='serchID' value='{$ID}'>
                       <input class='btn btn-info' type='submit' value='友達申請'></form>";
                    }

                }
                else{
                    echo"データがありません";
                }

               ?>
            </ul>
        </div>

    
</div>


<?php echo validation_errors(); ?>
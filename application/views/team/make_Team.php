<style>
    .f_body{
        height:300px;
    }
</style>

    <div class="f_body" style="border:2px solid dodgerblue; margin-left:500px; margin-right: 500px;margin-bottom: 50px; margin-top:100px;">


     
        <?php
        $attributes = array('class' => '클래스명 적어라');
        echo form_open('Team/Make_team',$attributes); //이부분 INSER문 들어가게 컨트롤러 위치수정 ?>
        팀이름 : <input type="text" value="" name="TeamName">
        <input type="submit" class='btn btn-default' value="생성" style="margin-right:auto;">
        </form>
    

    </div>


<?php echo validation_errors(); ?>

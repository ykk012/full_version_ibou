<div class="container body-container body">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="/img/ca_img1.jpg" alt="firstSlide" width="460" height="345">
            </div>

            <div class="item">
                <img src="/img/ca_img2.jpg" alt="secondSlide" width="460" height="345">
            </div>

            <div class="item">
                <img src="/img/ca_img3.jpg" alt="3rdSlide" width="460" height="345">
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div id='bodypage'>
        

    </div>
    <div id="underCarouselRow" class="row">
        <div id="logpage" class="panel-body col-sm-4 clearfix">
                    <?php 
                    if(isset($_SESSION['loginInfo'])) {
                        include 'application/views/member/loginedpage.php';}
                    else{
                        include 'application/views/member/home.php';
                    }
                    ?>
        </div>
        <div id="introTextDiv" class="col-sm-8">
            <h1>IBOU</h1>
            <p>Idea brainstorming Online Utility</p>
            <blockquote>
            <p>IBOU는 사용자와 사용자의 팀원들이 생각을 정리하는 것을 도와주는<br/>
            온라인 브레인스토밍 회의 지원 서비스입니다.</p>
            <footer>From Dev</footer>
            </blockquote>
        </div>
    </div>
</div>

<!--<div class="row bottom-nav-row">-->
<!--    <div class="col-md-12 col-sm-12 col-height">-->
<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">-->
<!--                Simple You-->
<!--            </div>-->
<!--            <div class="panel-body clearfix">-->
<!--                <ul>-->
<!--                    <li>당신이 소속된 팀 : <span class="bold">N</span><span class="pull-right">+</span><br/></li>-->
<!--                    <li>당신의 워크벤치 : <span class="bold">N</span><span class="pull-right">+</span><br/></li>-->
<!--                    <li>당신이 남은 저장소 용량 : <span class="bold">N/N Mb</span><span class="pull-right">+</span></li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
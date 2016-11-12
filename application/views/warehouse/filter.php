


  
<script src="/js/warehouse/filter.js"></script>
<div class="clearfix"></div>

<div class="bs-component" style="width: 560px !important; display:inline-block; ">
    <div class="pull-left">
        <ul class="nav nav-tabs" style=" display:inline-block;">
            <li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true">정렬</a></li>
            <li class=""><a href="#tab2" data-toggle="tab" aria-expanded="false">필터</a></li>
            <li style=" text-align:right; width:400; ">
                <input type="text" id="search_query" class="form-control" style="width:200px;height:45px;margin-right: 0px;margin-left: 200px;" placeholder="Search">
                <input type="radio" name="search_mod" value="before" class="btn btn-default"><label>첫글자</label>
            <input type="radio" name="search_mod" value="mid" class="btn btn-default"><label>가운데</label>
            <input type="radio" name="search_mod" value="after" class="btn btn-default"><label>마지막</label>
            </li>
        </ul>
        
    </div>
    <div id="myTabContent" class="tab-content" style="padding : 10px;">
        <div class="tab-pane fade active in" id="tab1">
            
            <div class="pull-left">
                <div><input type='radio' name='order' value='ASC'><span>오름차 순</span></div>
                <div><input type='radio' name='order' value='DESC'><span>내림차 순</span></div>
            </div>

        </div>
        <div class="tab-pane fade" id="tab2">
            <div class="pull-left">

                업로드 시간
                <input type='text' name='date1'>에서

                <input type='text' name='date2'>까지

            </div>
            <div class="pull-left">
                <input type='checkbox' name='ext' value='image'><span>이미지 파일</span>
                <input type='checkbox' name='ext' value='archive'><span>압축 파일</span>
                <input type='checkbox' name='share' value='share'><span>쉐어 파일(본인파일포함)</span>
            </div>
        </div>
    </div>
</div>

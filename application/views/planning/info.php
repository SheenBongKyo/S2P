<div class="row mb10">
    <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1 fwb">감리원 배치 계획표 정보</h3>
    </div>
    <div class="col-5 tar">
        <button type="button" class="mt10 btn btn btn-outline-secondary mb10" onclick="history.back()">목록보기</button>
    </div>
</div>
<div class="card supervisor-card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 tar">
                <button type="button" class="btn btn btn-outline-primary mb10" onclick="modalCreate('planningSupervisorModal')">감리원 등록</button>
                <?php if ($monthCount > 0 && !empty($headerDate)) { ?>
                <button type="button" class="btn btn btn-outline-secondary mb10" onclick="fontSet('up')">폰트 +</button>
                <button type="button" class="btn btn btn-outline-secondary mb10" onclick="fontSet('down')">폰트 -</button>
                <button type="button" class="btn btn btn-outline-secondary mb10" onclick="printPage()">인쇄하기</button>
                <?php } ?>
            </div>
        </div>
        
        <div class="print-area">
            <p class="tac fwb mt100 mb50 font-set" style="font-size: 20px">감 리 원 배 치 계 획 표</p>
            <p class="fwb mb5 font-set" style="font-size: 13px">
                ○ 사&nbsp;&nbsp;&nbsp;업&nbsp;&nbsp;&nbsp;명 : <?php echo $planning['pln_subject']?>
            </p>
            <div class="row">
                <div class="col-lg-12">
                    <?php if ($monthCount > 0 && !empty($headerDate)) { ?>
                        <table class="supervisor-table font-set" style="font-size: 10px">
                            <colgroup>
                                <col width="1%"/>
                                <col width="3%"/>
                                <col width="5%"/>
                                <col width="3%"/>
                                <?php for ($i = 1; $i <= $monthCount; $i++) { ?>
                                    <col width="<?php echo (71 / $monthCount)?>%"/>
                                <?php } ?>
                                <col width="3%"/>
                                <col width="4%"/>
                                <col width="5%"/>
                                <col width="5%"/>
                            </colgroup>
                            <tr>
                                <td rowspan="4" class="lhg26">구<br/>분</td>
                                <td rowspan="4" class="lhg26">분<br/>야</td>
                                <td rowspan="4" class="lhg26">성<br/>명</td>
                                <td rowspan="4" class="lhg26">등<br/>급</td>
                                <td colspan="<?php echo $monthCount?>" class="hg10"></td>
                                <td rowspan="4" class="lhg26">개<br/>월</td>
                                <td rowspan="4">환<br/>산<br/>비</td>
                                <td rowspan="4">인<br/>월<br/>수</td>
                                <td rowspan="4" class="lhg26">비<br/>고</td>
                            </tr>
                            <tr>
                                <?php foreach ($headerDate as $year => $months) { ?>
                                    <td colspan="<?php echo count($months)?>"><?php echo $year?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php foreach ($headerDate as $year => $months) { ?>
                                    <?php foreach ($months as $idx => $month) { ?>
                                        <td class="p0 hg25"><?php echo (int)$month?></td>
                                    <?php } ?>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php for ($i = 1; $i <= $monthCount; $i++) { ?>
                                    <td class="p0 hg25"><?php echo $i?></td>
                                <?php } ?>
                            </tr>
                            <?php foreach ($planningSupervisor as &$item) { ?>
                                <tr>
                                    <?php if ($gubunRows[$item['pls_gubun']][0] == $item['pls_id']) { ?>
                                        <td rowspan="<?php echo count($gubunRows[$item['pls_gubun']]) * 3?>">
                                            <?php echo $item['pls_gubun_rv']?>
                                        </td>
                                    <?php } ?>
                                    <td rowspan="3"><?php echo $item['pls_field_rv']?></td>
                                    <td rowspan="3">
                                        <?php echo $item['pls_name']?><br/>
                                        <button type="buton" class="btn btn-sm btn-rounded btn-outline-warning wd25 hg25 p0" onclick="modify(<?php echo $item['pls_id']?>)"><i class="fas fa-edit fs10"></i></button>
                                        <button type="buton" class="btn btn-sm btn-rounded btn-outline-danger wd25 hg25 p0" onclick="remove(<?php echo $item['pls_id']?>)"><i class="fas fa-trash-alt fs10"></i></button>
                                    </td>
                                    <td rowspan="3"><?php echo $item['pls_level_rv']?></td>
                                    <?php foreach ($headerDate as $year => $months) { ?>
                                        <?php foreach ($months as $idx => $month) { ?>
                                        <td class="p0 hg25"></td>
                                        <?php } ?>
                                    <?php } ?>
                                    <td rowspan="3"><?php echo $item['month_count']?></td>
                                    <?php if ($item['pls_gubun'] != 6) { ?>
                                        <td rowspan="3"><?php echo $plsLevelPrice[$item['pls_level']]?></td>
                                        <td rowspan="3"><?php echo sprintf('%0.3f', $plsLevelPrice[$item['pls_level']] * $item['month_count'])?></td>
                                    <?php } else { ?>
                                        <td rowspan="3"></td>
                                        <td rowspan="3"></td>
                                    <?php } ?>
                                    <td rowspan="3"><?php echo $item['pls_bigo']?></td>
                                </tr>
                                <tr>
                                    <?php foreach ($headerDate as $year => $months) { ?>
                                        <?php foreach ($months as $idx => $month) { ?>
                                            <?php $date = $year.'-'.$month;?>
                                            <?php $lastDay = date('t', strtotime($date."-01"));?>
                                            <td class="p0 hg25 
                                                <?php echo (
                                                    $date >= substr($item['pls_start_date'], 0, 7) &&
                                                    $date <= substr($item['pls_end_date'], 0, 7)
                                                ) ? 'table-active' : ''?>
                                            ">
                                                <?php echo ($date == substr($item['pls_start_date'], 0, 7) ? 
                                                    (substr($item['pls_start_date'], 8) == "01" ? '' : '<p class="m0 wd60p hg100p back-white lhg25">'.(int)substr($item['pls_start_date'], 8).'</p>') : '')?>
                                                <?php echo ($date == substr($item['pls_end_date'], 0, 7) ? 
                                                    (substr($item['pls_end_date'], 8) == $lastDay ? '' : '<p class="m0 wd60p hg100p back-white lhg25" style="margin-left:40%!important;">'.(int)substr($item['pls_end_date'], 8).'</p>') : '')?>
                                            </td>
                                        <?php } ?>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <?php foreach ($headerDate as $year => $months) { ?>
                                        <?php foreach ($months as $idx => $month) { ?>
                                            <td class="p0 hg25"></td>
                                        <?php } ?>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td class="p5" colspan="<?php echo $monthCount + 4?>">총배치 인월수</td>
                                <td></td>
                                <td></td>
                                <td><?php echo sprintf('%0.3f', $totalInwolsu)?></td>
                                <td></td>
                            </tr>
                        </table>
                        <p class="mt15 font-set" style="font-size: 12px">※ 감리대상공사비 : <?php echo number_format($planning['pln_price'])?> 원</p>
                        <p class="font-set" style="font-size: 12px">○ 법 정 &nbsp; 인 월 수 : <?php echo sprintf('%0.3f', $courtInwolsu)?> 인월</p>
                        <p class="font-set" style="font-size: 12px">○ 총배치 &nbsp;인월수 : <?php echo sprintf('%0.3f', $totalInwolsu)?> 인월</p>
                        <p class="font-set" style="font-size: 12px">
                            ○ 비상주감리원 인월수(배치율) : 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $transientInwolsu ? sprintf('%0.3f', $transientInwolsu) : 0?> 인월
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            (<?php echo $transientInwolsuPercent ? sprintf('%0.2f', $transientInwolsuPercent) : 0?>%)
                        </p>
                    <?php } else { ?>
                        <p class="p100 mb0 tac">감리원을 등록해주세요.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="planningSupervisorModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">감리원 등록</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="planningSupervisorForm" method="post" onkeydown="return enterFormSubmit(event, 'submitBtn')">
                    <input type="hidden" name="pls_id" id="pls_id"/>
                    <div class="form-group">
                        <label>구분</label>
                        <div>
                            <select name="pls_gubun" id="pls_gubun" class="form-control">
                                <option value="">- 구분 선택 -</option>
                                <?php foreach ($plsGubun as $value => $key) { ?>
                                <option value="<?php echo $value?>"><?php echo $key?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>분야</label>
                        <div>
                            <?php foreach ($plsField as $value => $key) { ?>
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="pls_field" id="pls_field_<?php echo $value?>" value="<?php echo $value?>">
                                        <label class="custom-control-label" for="pls_field_<?php echo $value?>"><?php echo $key?></label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>성명</label>
                        <input type="text" class="form-control" name="pls_name" id="pls_name" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label>등급</label>
                        <div>
                            <?php foreach ($plsLevel as $value => $key) { ?>
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="pls_level" id="pls_level_<?php echo $value?>" value="<?php echo $value?>">
                                        <label class="custom-control-label" for="pls_level_<?php echo $value?>"><?php echo $key?></label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>시작일</label>
                                <input type='date' class="form-control" name="pls_start_date" id="pls_start_date" placeholder="YYYY-MM-DD"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>종료일</label>
                                <input type='date' class="form-control" name="pls_end_date" id="pls_end_date" placeholder="YYYY-MM-DD"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>비고</label>
                        <input type="text" class="form-control" name="pls_bigo" id="pls_bigo" maxlength="50">
                    </div>
                </form>
            </div>
            <div class="form-group text-center">
                <button type="button" class="btn btn-outline-primary" button-type="submit" form-id="planningSupervisorForm" id="submitBtn">등록</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>

<script>
printPage = function () {
    $('.print-area .btn').hide();
    $('.print-area').printThis({loadCSS: '<?php echo base_url() ?>assets/css/common.css'})
    setTimeout(() => {
        $('.print-area .btn').show();
    }, 1000);
}
fontSet = function (type) {
    const fontSetClass = 'font-set';
    const fontSetEle = $('.'+fontSetClass);
    if (fontSetEle.length > 0) {
        $.each(fontSetEle, function(idx, item){
            let fontSize = parseInt($(item).css('font-size').replace('px', ''));
            if (type == 'up') {
                $(item).css('font-size', (fontSize + 1)+'px');
            } else if (type == 'down') {
                $(item).css('font-size', (fontSize - 1)+'px');
            }
        });
    }
}
modify = function (id) {
    _ajaxGet(
        "<?php echo base_url('planning/getPlanningSurpervisorInfo')?>", 
        { id: id }, 
        function (resp) {
            if (resp.resultCode == SUCCESS_CODE) {
                modalCreate('planningSupervisorModal', resp.data);
	        }
        }
    );
}
remove = function (id) {
    if (confirm("데이터 삭제 시 복구가 불가능합니다.\n그래도 삭제하시겠습니까?")) {
        _ajaxPost(
            "<?php echo base_url('planning/planningSupervisorRemove')?>", 
            { id: id }
        );
    }
}
</script>
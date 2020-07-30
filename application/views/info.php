<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=1210" />
	<title>S2P 프로젝트</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/common.css')?>">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.kr.min.js"></script>
    <script src="<?php echo base_url('assets/js/common.js')?>"></script>
    <script src="<?php echo base_url('assets/js/printThis.js')?>"></script>
</head>
<body>
<div class="mt100 container printArea" style="width: 1080px" id="printTable">
    <p class="tac fwb mb50 fs20">감 리 원 배 치 계 획 표</p>
    <div class="fr">
        <button type="button" class="btn btn-default mb10" onclick="create()">감리원 등록</button>
        <button type="button" class="btn btn-default mb10" onclick="printPage()">인쇄하기</button>
    </div>
    <p class="fwb">
        ○ 사 업 명 : <?php echo $blockPlanning['bpi_subject']?>
    </p>
    <div class="row">
        <div class="col-lg-12">
            <?php if ($monthCount > 0 && !empty($headerDate)) { ?>
                <table class="basic-table border-table supervisor-table" style="font-size: 10px">
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
                    <?php foreach ($blockPlanningSupervisorList as &$item) { ?>
                        <tr>
                            <?php if ($gubunRows[$item['bps_gubun']][0] == $item['bps_id']) { ?>
                                <td rowspan="<?php echo count($gubunRows[$item['bps_gubun']]) * 3?>" class="p0">
                                    <?php echo $item['bps_gubun_rv']?>
                                </td>
                            <?php } ?>
                            <td rowspan="3"><?php echo $item['bps_field_rv']?></td>
                            <td rowspan="3" class="p0">
                                <?php echo $item['bps_name']?>
                                <br/>
                                <button type="buton" class="btn btn-xs btn-warning" onclick="create(<?php echo $item['bps_id']?>)">수정</button>
                                <button type="buton" class="btn btn-xs btn-danger" onclick="deleted(<?php echo $item['bps_id']?>)">삭제</button>
                            </td>
                            <td rowspan="3" class="p0"><?php echo $item['bps_level_rv']?></td>
                            <?php foreach ($headerDate as $year => $months) { ?>
                                <?php foreach ($months as $idx => $month) { ?>
                                <td class="p0 hg25"></td>
                                <?php } ?>
                            <?php } ?>
                            <td rowspan="3" class="p0"><?php echo $item['month_count']?></td>
                            <td rowspan="3" class="p0"><?php echo $bpsLevelPrice[$item['bps_level']]?></td>
                            <td rowspan="3"><?php echo sprintf('%0.3f', $bpsLevelPrice[$item['bps_level']] * $item['month_count'])?></td>
                            <td rowspan="3"><?php echo $item['bps_bigo']?></td>
                        </tr>
                        <tr>
                            <?php foreach ($headerDate as $year => $months) { ?>
                                <?php foreach ($months as $idx => $month) { ?>
                                    <?php $date = $year.'-'.$month;?>
                                    <?php $lastDay = date('t', strtotime($date."-01"));?>
                                    <td class="p0 hg25 
                                        <?php echo (
                                            $date >= substr($item['bps_start_date'], 0, 7) &&
                                            $date <= substr($item['bps_end_date'], 0, 7)
                                        ) ? 'table-active' : ''?>
                                    ">
                                        <?php echo ($date == substr($item['bps_start_date'], 0, 7) ? 
                                            (substr($item['bps_start_date'], 8) == "01" ? '' : '<p class="m0 wd60p hg24 back-white" style="padding-top: 6.2px;">'.(int)substr($item['bps_start_date'], 8).'</p>') : '')?>
                                        <?php echo ($date == substr($item['bps_end_date'], 0, 7) ? 
                                            (substr($item['bps_end_date'], 8) == $lastDay ? '' : '<p class="m0 wd60p hg24 back-white" style="padding-top: 6.2px; margin-left:40%!important;">'.(int)substr($item['bps_end_date'], 8).'</p>') : '')?>
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
                </table>
            <?php } else { ?>
                <table class="basic-table border-table">
                    <tr>
                        <td class="p50">감리원을 등록해 주세요.</td>
                    </tr>
                </table>
            <?php } ?>
        </div>
    </div>
    <div class="fr">
        <button type="button" class="mt10 btn btn-default mb10" onclick="setFont('up')">폰트 +</button>
        <button type="button" class="mt10 btn btn-default mb10" onclick="setFont('down')">폰트 -</button>
        <button type="button" class="mt10 btn btn-default mb10" onclick="history.back()">목록보기</button>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">감리원 등록</h4>
            </div>
            <div class="modal-body">
                <form id="blockPainningSupervisorUpdateForm" method="post" onkeydown="return enterFormSubmit(event, 'submitBtn')">
                    <input type="hidden" name="bpi_id" id="bpi_id">
                    <input type="hidden" name="bps_id" id="bps_id"/>
                    <div class="form-group">
                        <label>구분</label>
                        <div>
                            <?php foreach ($bpsGubun as $value => $key) { ?>
                                <label class="radio-inline"><input type="radio" name="bps_gubun" id="bps_gubun" value="<?php echo $value?>"><?php echo $key?></label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>분야</label>
                        <div>
                            <?php foreach ($bpsField as $value => $key) { ?>
                                <label class="radio-inline"><input type="radio" name="bps_field" id="bps_field" value="<?php echo $value?>"><?php echo $key?></label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>성명</label>
                        <input type="text" class="form-control" name="bps_name" id="bps_name" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label>등급</label>
                        <div>
                            <?php foreach ($bpsLevel as $value => $key) { ?>
                                <label class="radio-inline"><input type="radio" name="bps_level" id="bps_level" value="<?php echo $value?>"><?php echo $key?></label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>시작일</label>
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="bps_start_date" id="bps_start_date" placeholder="YYYY-MM-DD" datepicker readonly/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>종료일</label>
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="bps_end_date" id="bps_end_date" placeholder="YYYY-MM-DD" datepicker readonly/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>비고</label>
                        <input type="text" class="form-control" name="bps_bigo" id="bps_bigo" maxlength="50">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" button-type="submit" form-id="blockPainningSupervisorUpdateForm" id="submitBtn">등록</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>
</body>
<style>
    .datepicker { top: 95px!important }
</style>
<script>
    function setFont(type) {
        let fontSize = $('.supervisor-table').css('font-size').replace('px', '');
        if (type == 'up') {
            if (fontSize <= 20) {
                $('.supervisor-table').css('font-size', (parseInt(fontSize, 10) + 1)+'px');
            } else {
                alert("더 이상 폰트 사이즈를 높일 수 없습니다.");
            }
        } else if (type == 'down') {
            if (fontSize > 1) {
                $('.supervisor-table').css('font-size', (parseInt(fontSize, 10) - 1)+'px');
            } else {
                alert("더 이상 폰트 사이즈를 줄일 수 없습니다.");
            }
        }
    }
    function create(id) {
        const formId = '#blockPainningSupervisorUpdateForm';
        if (id) {
            const list = <?php echo json_encode($blockPlanningSupervisorList) ?>;
            const items = list.filter(item => item.bps_id == id);
            if (items.length == 0) return false;
            $.each(items[0], function(key, value){
                if ($(formId+' #'+key).length > 0) {
                    if ($(formId+' #'+key).attr('type') == 'radio') {
                        $(formId+' #'+key+'[value="'+value+'"]').prop('checked', true);
                    } else {
                        $(formId+' #'+key).val(value);
                    }
                }
            });
        } else {
            $(formId+' input[type="hidden"]').val('');
            $(formId+' input[type="text"]').val('');
            $(formId+' input[type="radio"]:checked').prop('checked', false);
        }
        $('#bpi_id').val('<?php echo $blockPlanning['bpi_id']?>');
        $('#myModal').modal();
    }
    function deleted(id) {
        if (id && confirm("해당 감리원을 삭제 하시겠습니까?\n삭제 시 복구가 불가능합니다.")) {
            $.ajax({
                url: "<?php echo base_url('home/blockPainningSupervisorDelete')?>",
                type: "POST",
                data: { bps_id: id },
                dataType: "json",
                async: false,
                success: function (resp) {
                    ajaxResult(resp, "");
                }
            });
        }
    }
    function printPage() {
        $('.btn').hide();
        $('#printTable').printThis({loadCSS: '<?php echo base_url() ?>assets/css/common.css'})
        setTimeout(() => {
            $('.btn').show();
        }, 1000);
    }
</script>
</html>
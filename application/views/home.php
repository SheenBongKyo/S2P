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
</head>
<body>
<div class="container pt100">
    <div class="row">
        <div class="col-lg-8">
            <h3 class="fwb m0">감리원 배치 계획표 목록</h3>
        </div>
        <div class="col-lg-4 tar">
            <button type="button" class="btn btn-default mb10" data-toggle="modal" data-target="#myModal">등록하기</button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="basic-table">
                <colgroup>
                    <col />
                    <col width="70%"/>
                    <col width="20%"/>
                </colgroup>
                <tr>
                    <th>No</th>
                    <th>사업명</th>
                    <th>등록날짜</th>
                </tr>
                <?php foreach ($blockPlanningList as $idx => $item) { ?>
                    <tr>
                        <td><?php echo count($blockPlanningList) - $idx?></td>
                        <td class="tal">
                            <a href="<?php echo base_url('info')?>?id=<?php echo $item['bpi_id']?>"><?php echo $item['bpi_subject']?></a>
                            <button type="buton" class="btn btn-xs btn-danger" onclick="deleted(<?php echo $item['bpi_id']?>)">삭제</button>
                        </td>
                        <td><?php echo $item['bpi_created']?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">감리원 배치 계획표 등록</h4>
            </div>
            <div class="modal-body">
                <form id="blockPainningUpdateForm" method="post" onkeydown="return enterFormSubmit(event, 'submitBtn')">
                    <div class="form-group">
                        <label>사업명</label>
                        <input type="text" class="form-control" name="bpi_subject">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" button-type="submit" id="submitBtn" form-id="blockPainningUpdateForm">등록</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    function deleted(id) {
        if (id && confirm("해당 감리원 배치 계획표를 삭제 하시겠습니까?\n삭제 시 복구가 불가능합니다.")) {
            $.ajax({
                url: "<?php echo base_url('home/blockPainningDelete')?>",
                type: "POST",
                data: { bpi_id: id },
                dataType: "json",
                async: false,
                success: function (resp) {
                    ajaxResult(resp, "");
                }
            });
        }
    }
</script>
</html>
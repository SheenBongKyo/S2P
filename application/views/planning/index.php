<div class="row mb10">
    <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1 fwb">감리원 배치 계획표 목록</h3>
    </div>
    <div class="col-5 tar">
        <button type="button" class="btn btn-outline-primary" onclick="modalCreate('planningModal')">배치 계획표 등록</button>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="default-table table">
                <colgroup>
                    <col />
                    <col width="50%"/>
                    <col width="20%"/>
                    <col width="20%"/>
                </colgroup>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>사업명</th>
                        <th>등록날짜</th>
                        <th>관리</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($planning as $idx => $item) { ?>
                        <tr>
                            <td><?php echo count($planning) - $idx?></td>
                            <td class="tal">
                                <a href="<?php echo base_url('planning/info')?>/<?php echo $item['pln_id']?>"><?php echo $item['pln_subject']?></a>
                            </td>
                            <td><?php echo $item['pln_created']?></td>
                            <td>                                
                                <button type="buton" class="btn btn-sm btn-outline-warning" onclick="modify(<?php echo $item['pln_id']?>)">수정</button>
                                <button type="buton" class="btn btn-sm btn-outline-danger" onclick="remove(<?php echo $item['pln_id']?>)">삭제</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="planningModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">배치 계획표 등록</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="blockPainningUpdateForm" method="post" onkeydown="return enterFormSubmit(event, 'submitBtn')">
                    <input type="hidden" name="pln_id"/>
                    <div class="form-group">
                        <label>사업명</label>
                        <input type="text" class="form-control" name="pln_subject">
                    </div>
                    <div class="form-group">
                        <label>감리대상공사비</label>
                        <input type="text" class="form-control input-price wd90p dp-ib tar" name="pln_price" maxlength="15"> 원
                    </div>
                </form>
            </div>
            <div class="form-group text-center">
                <button type="button" class="btn btn-outline-primary" button-type="submit" id="submitBtn" form-id="blockPainningUpdateForm">등록</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>

<script>
modify = function (id) {
    _ajaxGet(
        "<?php echo base_url('planning/getPlanningInfo')?>", 
        { id: id }, 
        function (resp) {
            if (resp.resultCode == SUCCESS_CODE) {
                modalCreate('planningModal', resp.data);
	        }
        }
    );
}
remove = function (id) {
    if (confirm("데이터 삭제 시 복구가 불가능합니다.\n그래도 삭제하시겠습니까?")) {
        _ajaxPost(
            "<?php echo base_url('planning/planningRemove')?>", 
            { id: id }
        );
    }
}
</script>
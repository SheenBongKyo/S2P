<div class="row mb10">
    <div class="col-7 align-self-center">
        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1 fwb">계정 목록</h4>
    </div>
    <div class="col-5 tar">
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="modalCreate('accountModal')">계정 등록</button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="default-table table wd-fix">
                <colgroup>
                    <col width="5%"/>
                    <col width="10%"/>
                    <col />
                    <col width="15%"/>
                    <col width="15%"/>
                    <col width="15%"/>
                    <col width="15%"/>
                </colgroup>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>회원 유형</th>
                        <th>아이디</th>
                        <th>회원명</th>
                        <th>등록일</th>
                        <th>최종 로그인</th>
                        <th>관리</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($member['list'] as $idx => $item) { ?>
                        <tr>
                            <td><?php echo $item['_num']?></td>
                            <td><?php echo $item['mem_level_rv']?></td>
                            <td><?php echo $item['mem_userid']?></td>
                            <td><?php echo $item['mem_name']?></td>
                            <td><?php echo $item['mem_created']?></td>
                            <td><?php echo $item['mem_logined'] ? $item['mem_logined'] : '-'?></td>
                            <td>                                
                                <button type="buton" class="btn btn-sm btn-outline-warning" onclick="modify(<?php echo $item['mem_id']?>)">수정</button>
                                <?php if ($item['mem_level'] > 1) { ?>
                                    <button type="buton" class="btn btn-sm btn-outline-danger" onclick="remove(<?php echo $item['mem_id']?>)">삭제</button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php echo $paging?>
    </div>
</div>

<div id="accountModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">계정 등록</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="memberUpdateForm" method="post" onkeydown="return enterFormSubmit(event, 'submitBtn')">
                    <input type="hidden" name="mem_id"/>
                    <div class="form-group">
                        <label>회원 유형</label>
                        <div>
                            <select name="mem_level" id="mem_level" class="form-control">
                                <option value="">- 구분 선택 -</option>
                                <?php foreach ($memLevel as $value => $key) { ?>
                                <option value="<?php echo $value?>"><?php echo $key?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>아이디</label>
                        <input type="text" class="form-control" name="mem_userid">
                    </div>
                    <div class="form-group">
                        <label>회원명(업체명)</label>
                        <input type="text" class="form-control" name="mem_name">
                    </div>
                    <div class="form-group">
                        <label>비밀번호</label>
                        <input type="password" class="form-control" name="mem_password">
                        <small>※ 계정 수정 시 비밀번호 입력 시에만 수정됩니다.</small>
                    </div>
                </form>
            </div>
            <div class="form-group text-center">
                <button type="button" class="btn btn-outline-primary" button-type="submit" id="submitBtn" form-id="memberUpdateForm">등록</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>

<script>
modify = function (id) {
    _ajaxGet(
        "<?php echo base_url('account/getMemberInfo')?>", 
        { id: id }, 
        function (resp) {
            if (resp.resultCode == SUCCESS_CODE) {
                modalCreate('accountModal', resp.data);
	        }
        }
    );
}
remove = function (id) {
    if (confirm("데이터 삭제 시 복구가 불가능합니다.\n그래도 삭제하시겠습니까?")) {
        _ajaxPost(
            "<?php echo base_url('account/memberRemove')?>", 
            { id: id }
        );
    }
}
</script>
    
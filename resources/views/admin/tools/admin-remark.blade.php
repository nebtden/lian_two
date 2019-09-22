<div class="btn-group" data-toggle="buttons">
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
        管理员备注
    </button>

</div>
<div class="btn-group" data-toggle="buttons">
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-status">
        状态更改
    </button>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">管理员备注</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" class=" form-control admin_remark">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary admin_remark_submit">提交</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-status">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">状态更改</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <select name="admin_status" id="admin_status">
                    @foreach($statuses as $key=>$status)
                    <option value="{{ $key }}">{{$status}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary admin_status_submit">提交</button>
            </div>
        </div>
    </div>
</div>

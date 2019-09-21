$(function () {
    $('.client_change_to_user').click(function () {
        var id = $(this).data('id');
        var that = $(this);
        $.ajax({
            type:'POST',
            url:'/admin/api/change',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{"id":id},
            success:function(data){
                if(data.status==1){
                    alert('转换成功');
                    that.hide();
                }else{
                    alert(data.message);
                }
            }
        });

    })
})

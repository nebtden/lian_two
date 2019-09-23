$(function () {
    $('.client_accept').click(function () {
        var id = $(this).data('id');
        var that = $(this);
        $.ajax({
            type:'POST',
            url:'/user/client/accept',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{"id":id},
            success:function(data){
                if(data.status==1){
                    alert('接收成功');
                    that.parent('td').closest('phone').html(data.data.phone);
                }else{
                    alert(data.message);
                }
            }
        });

    })
})

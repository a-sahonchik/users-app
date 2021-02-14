$(function(e){
  $('#blockSelectedUsers').click(function(e){
    e.preventDefault();
    var userIds = [];
    $('input:checkbox[name=checkboxes]:checked').each(function(){
      userIds.push($(this).val());
    });

    $.ajax({
      url:'/user/block-selected',
      type:'POST',
      data:{
        checkboxes:userIds,
        _token:$('input[name=_token]').val()
      },
      success:function(response)
      {
        location.reload();
      }
    });
  });
});

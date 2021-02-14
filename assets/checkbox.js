$(function(e){
  $('#checkAllCheckboxes').click(function(e){
    $('.singleCheckbox').prop('checked', $(this).prop('checked'));
  });

  $('#deleteSelectedUsers').click(function(e){
    e.preventDefault();
    var userIds = [];
    $('input:checkbox[name=checkboxes]:checked').each(function(){
      userIds.push($(this).val());
    });

    $.ajax({
      url:'/user/delete-selected',
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

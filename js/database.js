$(function(){
  $('.delete').on("click", function () {
    var btnid = $(this).data("id");
    deleteData(btnid);
  });
});

function deleteData(btnid) {
  if (confirm('データを削除しますか？')) {
    $.ajax({
      type: "POST",
      url: "ajax.php",
      data: { btnid: btnid },
      success: function (data) {
        alert('削除しました');
        location.reload();
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert('Error : ' + errorThrown);
        $("#XMLHttpRequest").html("XMLHttpRequest : " + XMLHttpRequest.status);
        $("#textStatus").html("textStatus : " + textStatus);
        $("#errorThrown").html("errorThrown : " + errorThrown);
      }
    });
  }
  return false;
};

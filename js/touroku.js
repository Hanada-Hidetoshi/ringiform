const checkArr = ["氏名","メールアドレス","ユーザーID","パスワード"];
const newArr = [];

function formCheck() {
  swal({
    title: "データを登録しますか？",
    text: "未入力項目があると登録できません",
    buttons: true,
  })
    .then((dataSend) => {
      if (dataSend) {
        newArr.length = 0;
        for (let i = 0; i < checkArr.length; i++) {
          if (!$("#form" + (i + 1)).val()) {
            newArr.push(checkArr[i]);
            $("#form" + (i + 1)).css("background-color", "#EFCDC9");
          } else {
            $("#form" + (i + 1)).css("background-color", "transparent");
          }
        }
        if (!newArr.length) {
          $("#sendform").submit()
          return true;
        } else {
          swal({
            title: "未入力項目があります",
            text: newArr.toString() + "\n" + "が入力されていません",
          });
          $("#errorText").html(newArr.toString() + "を入力してください");
          $("#errorText").css("color", "red");
          return false;
        }
      } else {
        return false;
      }
    });
}

$("#register").on("click", function () {
  const uName = $(".login input[type=text]").val().trim();
  const pw = $(".login input[type=password]").val().trim();

  // 入力値のフォーマットチェック
  if (!checkFormat(uName, pw)) {
    return;
  }

  checkDuplication(uName)
    .then((isUnique) => {
      if (isUnique) {
        $("#err_message").html("");

        createUser(uName, pw)
          .then((status) => {
            console.log(status);
            window.location.href = `../`;
          })
          .catch((error) => {
            $("#err_message").html("ユーザー作成エラー。再度お試しください。");
            console.log(error);
          });
      } else {
        $("#err_message").html(
          "既に利用されている username のため、登録できません。"
        );
      }
    })
    .catch((error) => {
      $("#err_message").html("サーバーエラー。再度お試しください。");
      console.log(error);
    });
});

// 関数
function checkFormat(uName, pw) {
  if (!uName || !pw) {
    $("#err_message").html(
      "username と password を入力してから登録してください。"
    );
    return false;
  }

  if (uName.length > 120) {
    $("#err_message").html("username は120文字以内にしてください。");
    return false;
  }

  if (pw.length > 20) {
    $("#err_message").html("password は20文字以内にしてください。");
    return false;
  }

  if (!/[A-Za-z0-9_\-]+/.test(uName) || !/[A-Za-z0-9_\-]+/.test(pw)) {
    $("#err_message").html(
      "username と password は半角英数字、アンダースコア、ハイフンのみ利用できます。"
    );
    return false;
  }

  return true;
}

function checkDuplication(uName) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "./act_list/check_username.php",
      type: "POST",
      data: { u_name: uName },
      success: function (res) {
        const result = JSON.parse(res);
        resolve(result.isUnique);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error: " + textStatus + ": " + errorThrown);
        reject(new Error("Server error"));
      },
    });
  });
}

function createUser(uName, pw) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "./act_list/insert_user.php",
      type: "POST",
      data: { u_name: uName, pw: pw },
      success: function (res) {
        const result = JSON.parse(res);
        resolve(result.status);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error: " + textStatus + ": " + errorThrown);
        reject(new Error("Server error"));
      },
    });
  });
}

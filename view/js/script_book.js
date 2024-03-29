// ソートテーブルのセット
$(function () {
  $("#book_list").sortable();
});

// イベント
$("#logout").click(function () {
  window.location.href = "../controller/act_list/logout_act.php";
});

$("#delete_user").on("click", function () {
  if (confirm("本当に削除しますか？")) {
    $.ajax({
      url: "../controller/act_list/delete_user.php",
      type: "post",
      data: {},
      success: function (response) {
        console.log(response);
        window.location.href = "../";
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error: " + textStatus + ": " + errorThrown);
        window.location.href = "../";
      },
    });
  }
});

$("#book_list").on("click", ".book_item", function () {
  const bookId = $(this).attr("id");
  window.location.href = `./dog_ear.php?book_id=${bookId}`;
});

$("#book_cover_box").on("click", "#book_cover_img", function () {
  $("#img_upload").click();
});

$("#img_upload").on("change", function (e) {
  const reader = new FileReader();
  reader.onload = function (e) {
    $("#book_cover_img").attr("src", e.target.result);
  };
  reader.readAsDataURL(e.target.files[0]);
});

$("#book_list").sortable({
  stop: function (event, ui) {
    let ary = $(this).sortable("toArray");
    let order = [];
    ary.forEach((ele) => {
      order.push(parseInt(ele, 10));
    });

    let orderJSON = JSON.stringify(order);
    $("#books_order").val(orderJSON);
    postUpdateBooksOrder(orderJSON);
  },
});

// 関数
function postUpdateBooksOrder(order) {
  $.ajax({
    url: "../controller/act_list/update_order.php",
    type: "post",
    data: {
      type: "books",
      book_id: "NULL",
      order: order,
    },
    success: function (response) {
      console.log(response);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error: " + textStatus + ": " + errorThrown);
    },
  });
}

// ソートテーブルのセット
$(function () {
  $("#dog_ear_list").sortable();
});

// イベント
$("#top_btn").on("click", function () {
  window.location.href = "../";
});

let oldBookName;
$("#book_name")
  .on("focus", function () {
    oldBookName = $(this).text();
  })
  .on("blur", function () {
    const newBookName = $(this).text();
    if (newBookName != oldBookName) {
      postUpdateBooks("book_name", newBookName, $(this).data("book_id"));
    }
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

  let formData = new FormData();
  formData.append("book_cover_img", e.target.files[0]);
  formData.append("book_id", $(this).data("book_id"));

  $.ajax({
    url: "./act_list/update_book_cover_file.php",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      console.log(response);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error: " + textStatus + ": " + errorThrown);
    },
  });
});

$("#book_url_edit_btn").on("click", function () {
  const aTagHref = $("#book_url").attr("href");
  $("#book_url_update").val(aTagHref);
  $("#book_url_box").css("display", "none");
  $("#book_url_edit_box").css("display", "flex");
});

$("#book_url_ok").on("click", function () {
  const aTag = $("#book_url");
  const input = $("#book_url_update");
  const oldUrl = aTag.attr("href");
  const newUrl = input.val();

  if (oldUrl == newUrl) return;

  postUpdateBooks("book_url", newUrl, $(this).data("book_id"));
  aTag.attr("href", newUrl);

  $("#book_url_box").css("display", "flex");
  $("#book_url_edit_box").css("display", "none");
});

$("#book_url_cancel").on("click", function () {
  $("#book_url_box").css("display", "flex");
  $("#book_url_edit_box").css("display", "none");
});

$("#book_url").on("change", function () {
  postUpdateBooks("book_url", $(this).val(), $(this).data("book_id"));
});

$("#book_memo").on("change", function () {
  postUpdateBooks("book_memo", $(this).val(), $(this).data("book_id"));
});

$("#book_delete_btn").on("click", function () {
  if (confirm("本当に削除しますか？")) {
    const data = {
      book_id: $(this).data("book_id"),
      books_order: $(this).data("books_order"),
    };
    const encodedData = $.param(data);

    $.ajax({
      url: "./act_list/delete_book.php",
      type: "post",
      data: encodedData,
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

$(".dog_ear_item").on("change", "input, textarea", function () {
  postUpdateDogEar(
    $(this).attr("name"),
    $(this).val(),
    $(this).data("dog_ear_id")
  );
});

$(".dog_ear_item").on("click", ".delete_dog_ear", function () {
  if (confirm("本当に削除しますか？")) {
    const bookId = $(this).data("book_id");
    const data = {
      book_id: bookId,
      dog_ear_id: $(this).data("dog_ear_id"),
      dog_ear_order: $(this).data("dog_ear_order"),
    };
    const encodedData = $.param(data);

    $.ajax({
      url: "./act_list/delete_dog_ear.php",
      type: "post",
      data: encodedData,
      success: function (response) {
        console.log(response);
        window.location.href = `./dog_ear.php?book_id=${bookId}`;
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error: " + textStatus + ": " + errorThrown);
        window.location.href = `./dog_ear.php?book_id=${bookId}`;
      },
    });
  }
});

$("#dog_ear_list").sortable({
  stop: function (event, ui) {
    let ary = $(this).sortable("toArray");
    let order = [];
    let bookId = $(this).data("book_id");
    ary.forEach((ele) => {
      order.push(parseInt(ele, 10));
    });

    let orderJSON = JSON.stringify(order);
    $("#dog_ear_order").val(orderJSON);
    postUpdateDogEarOrder(orderJSON, bookId);
  },
});

// 関数
function postUpdateBooks(type, changeVal, bookId) {
  $.ajax({
    url: "./act_list/update_book.php",
    type: "post",
    data: {
      type: type,
      change_val: changeVal,
      book_id: bookId,
    },
    success: function (response) {
      console.log(response);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error: " + textStatus + ": " + errorThrown);
    },
  });
}

function postUpdateDogEar(type, changeVal, dogEarId) {
  $.ajax({
    url: "./act_list/update_dog_ear.php",
    type: "post",
    data: {
      type: type,
      change_val: changeVal,
      dog_ear_id: dogEarId,
    },
    success: function (response) {
      console.log(response);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error: " + textStatus + ": " + errorThrown);
    },
  });
}

function postUpdateDogEarOrder(order, bookId) {
  $.ajax({
    url: "./act_list/update_order.php",
    type: "post",
    data: {
      type: "dog_ear",
      book_id: bookId,
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

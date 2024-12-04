let path = location.pathname;

//ページごとに関数を呼び出し
if (path.endsWith("detail")) {
    detail();
} else if (path.endsWith("mypage")) {
    mypage();
} else if (path.endsWith("search")) {
    song_search();
}

//マイページ処理
function mypage() {
    let btn = document.querySelector(".send-button");
    btn.addEventListener("click", function () {
        let input = document.querySelector(".listname");
        if (input.value.length == "") {
        } else {
            btn.disabled = true; /*ボタンを非活性に*/
            document.forms.form.submit(); /*submit処理を行う*/
        }
    });
}

//詳細ページ処理
function detail() {
    let input_song = document.querySelector("#song-input");
    let input_artist = document.querySelector("#artist-input");
    let button_song = document.querySelector("#song-button");
    let button_artist = document.querySelector("#artist-button");
    let comment_btn = document.querySelectorAll(".btn-comment");
    let change_flgs = document.querySelectorAll(".change-flg");

    //編集削除ボタン処理
    change_flgs.forEach(function (change_flg) {
        let delete_button = change_flg.querySelector(".delete_btn");
        let destroy_url = "/song_destroy"
        let edit_button = change_flg.querySelector(".edit_btn");
        let edit_url = '/song_edit'
        let audio = change_flg.querySelector(".audio_list")

        //audioファイルがない時表示しないように
        audio.addEventListener("error", function() {
            audio.remove()
        })

        //削除ボタン処理
        delete_button.addEventListener("click", function () {
            var clickEle = $(this);
            var user_id = clickEle.attr("data-id")
            var deleteConfirm = confirm("削除してもよろしいでしょうか?");

            if (deleteConfirm == true) {
                //ボタンを非活性に
                var formData = new FormData();
                formData.append("id", user_id);
                console.log(user_id)
                delete_button.disabled = true;
                change_flg.querySelector(".btn-warning").disabled = true;
                ajax('post', formData, destroy_url, function () {
                    change_flg.remove();
                });
            } else {
                (function (e) {
                    e.preventDefault();
                });
            }
        });

        //編集ボタン処理
        edit_button.addEventListener("click", function () {
            var clickEle = $(this);
            var user_id = clickEle.attr("data-id");
            var point = change_flg.querySelector("#song-point").value
            var comment = change_flg.querySelector("#song-comment").value
            var audioInput = change_flg.querySelector("#audio")
            if (point.length == "") {
            } else {
                // 設定欄に入力された情報を取得する
                var formData = new FormData();
                formData.append("id", user_id);
                formData.append("points", point);
                formData.append("comment", comment);
                if (!(audioInput.files.length === 0)) {
                    formData.append("mp3_data", audioInput.files[0]);
                }

                edit_button.disabled = true;//ボタンを非活性に
                change_flg.querySelector(".spinner-border").classList.remove('d-none')//ロードアイコン表示
                ajax('post', formData, edit_url, function (response) {
                    var audio_path = JSON.parse(response).updatedContent;
                    var modal = change_flg.querySelector(".modal")
                    edit_button.disabled = false;//ボタンを再度活性化
                    change_flg.querySelector(".spinner-border").classList.add('d-none')//ロードアイコン非表示
                    change_flg.querySelector(".point_list").textContent = "点数:" + point
                    change_flg.querySelector(".comment_list").textContent = comment
                    if (!(audio_path === null)) audio.setAttribute("src", 'http://localhost/storage/audio/' + audio_path)
                    if (modal.classList.contains("show"))$(modal).modal('hide');
                })
            }
        });
    })

    //フォーム内numberinputを100以上入力できないように
    $('input[type="number"]').on('change focusout', function () {
        var pattern = /^[1-9]\d{0,3}$/;
        if ($(this).val() === "0")
            $(this).val()
        else if ($(this).val().match(pattern) === null)
            $(this).val($(this).val().replace(/^0+/, ''))
        else if (typeof $(this).attr('min') !== "undefined" && parseInt($(this).val()) < parseInt($(this).attr('min')))
            $(this).val($(this).attr('min'))
        else if (typeof $(this).attr('max') !== "undefined" && parseInt($(this).val()) > parseInt($(this).attr('max')))
            $(this).val($(this).attr('max'))
        else if (typeof $(this).attr('min') !== "undefined" && $(this).val() === '')
            $(this).val($(this).attr('min'))
    });


    //コメント開閉ボタンのコメント切替
    comment_btn.forEach(function (comment_button) {
        comment_button.addEventListener("click", () => {
            const isCollapsed = comment_button.classList.toggle("collapsed");
            comment_button.querySelector(".text-comment").textContent =
                isCollapsed ? "コメントを閉じる" : "コメントを開く";
        });
    });

    //送信ボタン多重送信対策
    button_song.addEventListener("click", function () {
        if (input_song.value.length == "") {
        } else {
            button_song.disabled = true; /*ボタンを非活性に*/
            button_artist.disabled = true;
            document.forms.songform.submit(); /*submit処理を行う*/
        }
    });

    //送信ボタン多重送信対策
    button_artist.addEventListener("click", function () {
        if (input_artist.value.length == "") {
        } else {
            button_song.disabled = true;
            button_artist.disabled = true;
            document.forms.artistform.submit();
        }
    });
}

//曲検索ページ処理
function song_search() {
    let search_btn = document.querySelector("#song-button");

    search_btn.addEventListener("click", function () {
        let input = document.querySelector("#song-input");
        if (input.value.length == "") {
        } else {
            search_btn.disabled = true; /*ボタンを非活性に*/
            document.forms.searchform.submit(); /*submit処理を行う*/
        }
    });

    //フォーム内nuberinputを100以上入力できないように
    $('input[type="number"]').on('change focusout', function () {
        var pattern = /^[1-9]\d{0,3}$/;
        if ($(this).val() === "0")
            $(this).val()
        else if ($(this).val().match(pattern) === null)
            $(this).val($(this).val().replace(/^0+/, ''))
        else if (typeof $(this).attr('min') !== "undefined" && parseInt($(this).val()) < parseInt($(this).attr('min')))
            $(this).val($(this).attr('min'))
        else if (typeof $(this).attr('max') !== "undefined" && parseInt($(this).val()) > parseInt($(this).attr('max')))
            $(this).val($(this).attr('max'))
        else if (typeof $(this).attr('min') !== "undefined" && $(this).val() === '')
            $(this).val($(this).attr('min'))
    });
}

//非同期通信用関数
function ajax(type, request, url, func) {
    /*request = 親要素のinput要素
      url = ルートパス
      func = Ajax処理後に行う処理 */

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: type,
        url: url,
        dataType: "text",
        data: request,
        processData: false,  // jQueryがデータを自動的に処理しないように
        contentType: false,
        success: func,
        error: function (jqXHR, textStatus, errorThrown) {
            alert("通信エラー: " + textStatus + " - " + errorThrown);
        }
    })
}

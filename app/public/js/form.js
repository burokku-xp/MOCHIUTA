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

    //削除ボタン処理
    change_flgs.forEach(function (change_flg) {
        let delete_button = change_flg.querySelector(".delete_btn");
        let destroy_url = "/song_destroy"
        let edit_button = change_flg.querySelector(".edit_btn");
        let edit_url = '/song_edit'

        //削除ボタン処理
        delete_button.addEventListener("click", function () {
            var deleteConfirm = confirm("削除してもよろしいでしょうか?");
            if (deleteConfirm == true) {
                //ボタンを非活性に
                delete_button.disabled = true;
                ajax('post' ,$(this), destroy_url, function () {
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
            delete_button.disabled = true;
            ajax(put, $(this), edit_url, function () {
                delete_button.disabled = false;
            })
        });
    })

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
        console.log('OK')
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
}

//非同期通信用関数
function ajax(type,request_id, url, func) {
    /*request_id = 親要素のHTMLid要素
      url = ルートパス
      func = Ajax処理後に行う */
    var clickEle = $(request_id);
    var userID = clickEle.attr("data-id");
    console.log($('meta[name="csrf-token"]').attr("content"))
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: type,
        url: url,
        dataType: "text",
        data: {
            id: userID,
        },
    })
        .done(func)
        .fail(function () {
            alert("エラーが起きました");
        });
}

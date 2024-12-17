let path = location.pathname;

let search = document.querySelector(".usersearch_btn");

//ヘッダーのユーザー検索
search.addEventListener("click", function () {
    let inputElement = document.querySelector('input[name="userSearch"]');
    let inputValue = inputElement.value;
    let search_url = "/user_searchResult"
    let search_request = new FormData();
    search.disabled = true;
    search_request.append("val", inputValue);
    $("#userseach_result").children().remove();

    ajax("post", search_request, search_url, function (response) {
        let response_obj = JSON.parse(response);
        let response_array = Object.entries(response_obj);
        search.disabled = false;
        response_array.forEach(([key, value]) => {
            if (key === "user_searchs") {
                Object.values(value).forEach((y) => {
                    $("#userseach_result").append('<div class="dropdown"><button type="button" class="btn btn-light ms-1 dropdown-toggle" data-bs-toggle="dropdown">' + y["user_name"] + '</button><ul id="userseach_' + y["user_id"] + '" class="dropdown-menu"></ul></div>')
                    Object.entries(y).forEach(([key, value]) => {
                        if (key === "list_content") {
                            Object.values(value).forEach((list_data) => {
                                $("#userseach_" + y["user_id"]).append('<div class="dropdown-item d-flex"><a href="/user_searchResult/' + list_data["list_id"] + '">' + list_data["list_name"] + '</a></div>')
                            });
                            $("#userseach_" + y["user_id"]).append('<div class="dropdown-item d-flex"><div><a id="' + y["user_id"] + '" class="link-dark link-offset-2 link-underline link-underline-opacity-0" href="#">' + favorite(y["user_id"], response_array) + '</a></div></div>')
                        }
                    })
                })
            }
        })
    })
})
//お気に入りユーザー処理
document.querySelector("#userseach_result").addEventListener("click", function (event) {
    if (event.target.className === "link-dark link-offset-2 link-underline link-underline-opacity-0") {
        if (event.target.textContent === "お気に入り☆") {
            let url = "/user_searchResult/favorite"
            let request = new FormData();
            request.append("id", event.target.id);
            ajax("post", request, url, function () {
                event.target.textContent = "お気に入り★"
            })
        } else if (event.target.textContent === "お気に入り★") {
            let url = "/user_searchResult/favoriteDelete"
            let request = new FormData();
            request.append("id", event.target.id);
            ajax("post", request, url, function () {
                event.target.textContent = "お気に入り☆"
            })
        }
        if (path.endsWith("mypage")) {
            refreshFavoriteUsers();
        }
    }
})

function favorite(user_id, obj) {
    for (const [key, value] of Object.entries(obj)) {
        if (key === "1") {
            for (const [subKey, subValue] of Object.entries(value["1"])) {
                if (subValue["user_id"] === user_id) {
                    return "お気に入り★";
                }
            }
        }
    }
    return "お気に入り☆";
}



//ページごとに関数を呼び出し
if (path.endsWith("detail")) {
    detail();
} else if (path.endsWith("mypage")) {
    mypage();
} else if (path.endsWith("search")) {
    song_search();
} else if (path.endsWith("user_searchResult")) {
    user_search();
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

    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('iframe-container');
        const items = document.querySelectorAll('.iframe-wrapper');
        refreshFavoriteUsers();
        let currentIndex = 0; // 現在表示されているアイテムのインデックス

        // 中央に最も近いアイテムを検出してactiveクラスを適用
        const updateActiveItem = () => {
            const containerCenter = container.scrollLeft + container.offsetWidth / 2;

            items.forEach(item => {
                const itemCenter = item.offsetLeft + item.offsetWidth / 2;
                const distance = Math.abs(containerCenter - itemCenter);

                if (distance < item.offsetWidth / 2) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        };

        // 自動スクロールの設定
        const autoScroll = () => {
            currentIndex = (currentIndex + 1) % items.length; // 次のインデックスを計算
            const targetItem = items[currentIndex];
            const targetPosition = targetItem.offsetLeft - (container.offsetWidth - targetItem.offsetWidth) / 2;

            container.scrollTo({
                left: targetPosition,
                behavior: 'smooth'
            });
        };

        // イベントリスナーでスクロール時にactiveクラスを更新
        container.addEventListener('scroll', () => {
            updateActiveItem();
        });

        // 5秒ごとに自動スクロールを実行
        setInterval(() => {
            autoScroll();
        }, 30000);

        // 初期状態でactiveクラスを適用
        updateActiveItem();
    });


    let user_list = document.querySelectorAll(".user_list")
    //ユーザがお気に入りしているかどうかをロード時にチェック

    //user_list.forEach(function (list) {
    let favorite_btn = list.querySelector(".favorite")

    if (favorite_btn.classList.contains("true")) favorite_btn.textContent = "★"
    if (favorite_btn.classList.contains("false")) favorite_btn.textContent = "☆"

    /*ユーザーをお気に入り登録する。*/
    favorite_btn.addEventListener("click", function () {
        console.log("ok")
        let request = new FormData();
        request.append("id", favorite_btn.id);
        if (favorite_btn.classList.contains("false")) {
            let url = "/user_searchResult/favorite"
            ajax("post", request, url, function () {
                favorite_btn.textContent = "★"
                favorite_btn.classList.remove("false")
                favorite_btn.classList.add("true")
            })
        } else if (favorite_btn.classList.contains("true")) {
            let url = "/user_searchResult/favoriteDelete"
            ajax("post", request, url, function () {
                favorite_btn.textContent = "☆"
                favorite_btn.classList.remove("true")
                favorite_btn.classList.add("false")
            })
        }
    })
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

        //削除ボタン処理
        delete_button.addEventListener("click", function () {
            var clickEle = $(this);
            var user_id = clickEle.attr("data-id")
            var deleteConfirm = confirm("削除してもよろしいでしょうか?");

            if (deleteConfirm == true) {
                //ボタンを非活性に
                var formData = new FormData();
                formData.append("id", user_id);
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
            console.log(audioInput.files)
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
                    change_flg.querySelector(".point_list").textContent = point
                    change_flg.querySelector(".comment_list").textContent = comment
                    if (!(audio_path === null)) audio.setAttribute("src", 'http://localhost/storage/audio/' + audio_path)
                    if (modal.classList.contains("show")) $(modal).modal('hide');
                })
            }
        });
    })

    document.querySelector(".listdelete").addEventListener("click", function () {
        if (confirm("削除してもよろしいでしょうか?")) {
            //ボタンを非活性に
            document.querySelector(".listdelete").disabled = true;
            document.querySelector(".list_delete").submit();
        } else {
            return;
        }
    });

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
    let search_forms = document.querySelectorAll(".search_form");

    search_forms.forEach(function (search_form) {
        let search_btn = search_form.querySelector(".send_button")
        search_btn.addEventListener("click", function () {
            let input = search_form.querySelector("#song-input");
            if (input.value.length == "") {
            } else {
                search_btn.disabled = true; /*ボタンを非活性に*/
                search_form.querySelector("#searchform").submit(); /*submit処理を行う*/
            }
        });
    })

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

//ユーザー検索ページ処理
function user_search() {
    let user_list = document.querySelectorAll(".user_list")
    //ユーザがお気に入りしているかどうかをロード時にチェック

    user_list.forEach(function (list) {
        let favorite_btn = list.querySelector(".favorite")


        if (favorite_btn.classList.contains("true")) favorite_btn.textContent = "★"
        if (favorite_btn.classList.contains("false")) favorite_btn.textContent = "☆"

        /*ユーザーをお気に入り登録する。*/
        favorite_btn.addEventListener("click", function () {
            let request = new FormData();
            request.append("id", favorite_btn.id);
            if (favorite_btn.classList.contains("false")) {
                let url = "/user_searchResult/favorite"
                ajax("post", request, url, function () {
                    favorite_btn.textContent = "★"
                    favorite_btn.classList.remove("false")
                    favorite_btn.classList.add("true")
                })
            } else if (favorite_btn.classList.contains("true")) {
                let url = "/user_searchResult/favoriteDelete"
                ajax("post", request, url, function () {
                    favorite_btn.textContent = "☆"
                    favorite_btn.classList.remove("true")
                    favorite_btn.classList.add("false")
                })
            }
        })
    })
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

//お気に入りユーザーリスト更新用
function refreshFavoriteUsers() {
    $.get("/favorite-users", function (data) {
        $('.favorite_tbody').html(data); // tbodyの内容を置き換え
        let user_list = document.querySelectorAll(".user_list")
        //ユーザがお気に入りしているかどうかをロード時にチェック
        user_list.forEach(function (list) {
            let favorite_btn = list.querySelector(".favorite")
            console.log(favorite_btn)

            if (favorite_btn.classList.contains("true")) favorite_btn.textContent = "★"
            if (favorite_btn.classList.contains("false")) favorite_btn.textContent = "☆"

            favorite_btn.addEventListener("click", function () {
                console.log("ok")
                let request = new FormData();
                request.append("id", favorite_btn.id);
                if (favorite_btn.classList.contains("false")) {
                    let url = "/user_searchResult/favorite"
                    ajax("post", request, url, function () {
                        favorite_btn.textContent = "★"
                        favorite_btn.classList.remove("false")
                        favorite_btn.classList.add("true")
                    })
                } else if (favorite_btn.classList.contains("true")) {
                    let url = "/user_searchResult/favoriteDelete"
                    ajax("post", request, url, function () {
                        favorite_btn.textContent = "☆"
                        favorite_btn.classList.remove("true")
                        favorite_btn.classList.add("false")
                    })
                }
            })
        })
    })
}
    let btn = document.getElementById('sendbutton');
    let input = document.getElementById('list-name').value;
    btn.addEventListener('click', function() {
        if(input==""){
        }else{
            btn.disabled = true /*ボタンを非活性に*/
            document.forms.listform.submit(); /*submit処理を行う*/
        }
    })
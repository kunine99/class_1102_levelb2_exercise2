<fieldset>
    <legend>會員註冊</legend>
    <div style="color:red">*請設定您要註冊的帳號及密碼(最長12個字元)</div>
    <!-- tr*5>td*2 -->
    <table>
        <tr>
            <td>Step1:登入帳號</td>
            <td><input type="text" name="acc" id="acc"></td>
        </tr>
        <tr>
            <td>Step2:登入密碼</td>
            <td><input type="password" name="pw" id="pw"></td>
        </tr>
        <tr>
            <td>Step3:再次確認密碼</td>
            <td><input type="password" name="pw2" id="pw2"></td>
        </tr>
        <tr>
            <td>Step4:信箱(忘記密碼時使用)</td>
            <td><input type="text" name="email" id="email"></td>
        </tr>
        <tr>
            <td>
                <button onclick="reg()">註冊</button>
                <button onclick="reset()">清除</button>
            </td>
            <td></td>
        </tr>
    </table>
</fieldset>

<script>
    function reset() {
        //空白代表空值(清除)
        $("#acc,#pw,#pw2,#email").val("");
        // $("acc").val("");
        // $("pw").val("");
        // $("pw2").val("");
        // $("email").val("");
    }

    function reg() {
        // 用物件的方式模擬陣列的效果
        // 宣告這個form是一個物件的格式(兩個大誇號包住物件是物件的寫法)
        let form = {
            // 你有一個acc的欄位，你這個acc是來自畫面上的這個欄位的value
            // 物件裡面的值跟值用之間用,分開
            acc: $("#acc").val(),
            pw: $("#pw").val(),
            pw2: $("#pw2").val(),
            email: $("#email").val()
        }


        // if(Object.values(form).indexOf('')>=0){
        if (form.acc == '' || form.pw == '' || form.pw2 == '' || form.email == '') {
            alert("不可空白")
        } else {
            if (form.pw != form.pw2) {
                alert("密碼錯誤")
            } else {
                // 我要把表單的內容送出去到資料庫
                //post api在php裡面 送出去一堆給他，最後會有結束的動作
                // $.post("api/chk_acc.php", {},()=> { })

                // 我要確認帳號acc,然後他的資料來自於form裡面的acc
                $.post("api/chk_acc.php", {
                    acc: form.acc
                }, (chk) => {
                    // 我預期他會回給我true or false代表(1存在或是0不存在)
                    if (parseInt(chk) == 1) {
                        alert('帳號重複')
                    } else {
                        $.post("api/reg.php", {}, () => {
                            alert("註冊成功，歡迎加入")

                        })
                    }



                })
            }

            print_r($chk);


        }


    }
</script>
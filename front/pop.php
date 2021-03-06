<fieldset>
    <!-- 題組二考題第12項目建置人氣文章區   直接複製news.php
    記得加第三欄人氣
    然後因為要照人氣排序,所以從文章撈資料那裏要記得
    加order by `goods` desc
    之後開始做按讚
    -->

    <legend>目前位置：首頁 > 人氣文章區</legend>
    <!-- table>tr*2>td*3 -->
    <table>
        <tr>
            <td width="30%">標題</td>
            <td width="50%">內容</td>
            <td>人氣</td>
        </tr>
        <?php
        $total = $News->math("count", "*",['sh'=>1]);
        $div = 5;
        $pages = ceil($total / $div);
        $now = $_GET['p'] ?? 1;
        $start = ($now - 1) * $div;

        $rows = $News->all(['sh' => 1], " order by `good` desc limit $start,$div");
        foreach ($rows as $key => $row) {
        ?>
            <tr>
                <td class="switch"><?= $row['title']; ?></td>
                <td class="switch">
                    <div class="short"><?= mb_substr($row['text'], 0, 20); ?>...</div>
                    <!-- 改成pop 行內樣式不要了 -->
                    <div class="pop">
                        <h1 style="color:skyblue;">
                        <?php
                        switch ($row['type']){
                            case 1:
                                echo "健康新知";
                            break;
                            case 2:
                                echo "菸害防制";
                            break;
                            case 3:
                                echo "癌症防治";
                            break;
                            case 4:
                                echo "慢性病防治";
                            break;
                        }

                        ?>
                        </h1>
                        <?= nl2br($row['text']); ?>
                    </div>
                </td>
                <td>
                <span><?=$row['good'];?></span>個人說<img src="icon/02B03.jpg" style="width:25px">
                <!-- 從news php 複製來的 -->
                <?php
                    if(isset($_SESSION['login'])){
                        $chk = $Log->math('count', '*', ['news' => $row['id'], 'user' => $_SESSION['login']]);
                        if($chk>0){
                           echo "<a class='g' data-news='{$row['id']}' data-type='1'>收回讚</a>";
                        }else{
                            echo "<a class='g' data-news='{$row['id']}' data-type='2'>讚</a>";

                        }
                    }
                ?> 
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <div>
        <?php
        // 前符號
        if(($now-1)>0){
            $prev=$now-1;
            echo "<a href='index.php?do=pop&p=$prev'>";
            echo " < ";
            echo "</a>";  
        }



        for ($i = 1; $i <= $pages; $i++) {
            // 放當前頁
            //如果$now==$i的話,我的字大小24p,不然的話16px
            $font = ($now == $i) ? '24px' : '16px';
            // echo我們的內容,先顯示我們的當前頁
            //我們的當前頁在index.php?do=pop這個地方 和 我們p=$i
            echo "<a href='index.php?do=pop&p=$i' style='font-size:$font'>";
            // 中間顯示我的頁碼$i
            echo $i;
            echo "</a>";
        }

        // 後符號,不能超過我的總頁數
        if(($now+1)<=$pages){
            $next=$now+1;
            echo "<a href='index.php?do=pop&p=$next'>";
            echo " > ";
            echo "</a>";  
        }
        ?>
    </div>
</fieldset>


<script>
//將on改成hovor,刪掉click,改成pop
    $(".switch").hover(function() {
        $(this).parent().find(".pop").toggle()
    })
    //接下來做彈出功能





    //news複製來的
    //當class=g的東西被按下的時候我要做...
    $(".g").on("click",function(){
        
        let type=$(this).data('type')  
        let news=$(this).data('news')

        
        $.post("api/good.php",{type,news},()=>{
            // 拿到資料後要根據type對我的畫面上做一些事情
        location.reload()
/*        let count;
         switch(type){
            case 1:  //收回讚
               $(this).text("讚");
               $(this).data('type',2)
                count=$(this).siblings('span').text()*1
                $(this).siblings('span').text(count-1)
            break;
            case 2:
                $(this).text("收回讚");
                $(this).data('type',1)
                count=$(this).siblings('span').text()*1
                $(this).siblings('span').text(count+1)
            break;
        } */
        })
    })


</script>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Xem thêm => <a class="btn btn-success" href="//bestauto.pro" target="_blank"> Duy.Mobi</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="#">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_name" class="col-sm-2 control-label">Tài khoản Facebook:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="user_name" name="user_name" value="" placeholder="Số điện thoại, user name, email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Mật khẩu:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu facebook" required>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="button" onclick="_getToken();" class="btn btn-info pull-right">Lấy token</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
<div id="duydeptrai" class="alert alert-success" style="text-align:center;background: #E6E6E6 !important;display:none"></div>
<center><span class="h4" style="background: #333; color: white;margin-bottom: 5px; display: block;padding:5px">Nhập tài khoản và mật khẩu Facebook của bạn và Click vào nút <b>Lấy token</b>. Sau vài giây, nếu thành công bạn sẽ nhận được kết quả như hình bên dưới, copy mã tokenc từ đoạn <b>EAAA...</b></span></center>
<div class="alert alert-success zoom" style="background: #444 !important;text-align: center" id="duykute"><img src="src/token_guide.png" style="width:100%" alt="Token Successfully" /></div>
</div>
<script>
    function _getToken() {
        var http = new XMLHttpRequest();
        var user = document.getElementById("user_name").value;
        var pass = document.getElementById("password").value;
        if (user == '' || pass == '') {
            alert('Nhập đầy đủ thông tin để get token');
        } else {
            var url = "person/get.php";
            var params = "u=" + user + "&p=" + pass + "";
            http.open("POST", url, true);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            http.onreadystatechange = function () {
                if (http.readyState == 4 && http.status == 200) {
                    document.getElementById("duydeptrai").style.display = 'block';
                    
                    document.getElementById("duydeptrai").innerHTML = http.responseText;
                }
            }
            http.send(params);
        }
    }
</script>
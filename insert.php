<?php
    //Khai báo biến
    $username = $userID = $password = $repass =$email = $gender = $interest = $address = $bird="";
    $flag = false;
    $errors = $err_day="";
    $day = $month = $year = "";
    
    $err_username = $err_userID = $err_password = $err_repass =$err_email = $err_gender = $err_interest = $err_address = $err_bird='';
    if($_SERVER['REQUEST_METHOD']="POST"){
        //Kiểm tra họ và tên
        if(empty($_POST["username"])){
            $err_username = "Không được để họ tên là trống";
            
        }
        else{
            $username = check_data($_POST["username"]);
        }
         //Kiểm tra Tên đăng nhập
        if(empty($_POST["userID"])){
            $err_userID = "Không được để Tên đăng nhập là trống";
            
        }
        else{
            $userID = check_data($_POST["userID"]);
        }
         //Biểu thức chính quy kiểm tra tên đăng nhập
        if(!preg_match("/^[a-zA-Z0-9]+$/",$userID)){
            $err_userID = "Tên đăng nhập phải theo đúng chuẩn chỉ có chữ và số";
        }
        //Kiểm tra Mật khẩu
        if(empty($_POST["password"])){
            $err_password = "Không được để mật khẩu là trống";
            
        }
        else{
            $password = check_data($_POST["password"]);
        }
         //Biểu thức chính quy kiểm tra nhập  mật khẩu
        if(!preg_match("/^[a-zA-Z0-9]{8,30}$/",$password)){
            $err_userID = "TMật khẩu phải đủ ít nhất 8 ký tự và theo chuẩn";
        }
        //Kiểm tra nhập lại mật khẩu Mật khẩu
        if(empty($_POST["repass"])){
            $err_repass = "Không được để nhập lại password là trống";
            
        }
        else{
            $repass = check_data($_POST["repass"]);
        }
         //Biểu thức chính quy kiểm tra mật khẩu và nhập lại mật khẩu
        if(!preg_match("/^[a-zA-Z0-9]{8,30}$/",$repass)){
            $err_repass = "Nhập lại pass phải đủ ít nhất 8 ký tự và theo chuẩn";
        }
        if($password!=$repass)
        {
            $errors = "Mật khẩu và nhập lại mật khẩu không khớp";
        }
        //Kiểm tra Email
        if(empty($_POST["email"])){
            $err_email = "Email không được để trống";
            
        }
        else{
            $email = check_data($_POST["email"]);
        }
         //Biểu thức chính quy kiểm tra email
        if(!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-z]+$/",$email)){
            $err_userID = "Phải nhập đúng định dạng email có @ và dấu chấm";
        }
        //Kiểm tra năm sinh phải đúng chuẩn
        //tháng 1,3,5,7,8,10,12: có 31 ngày
        //Thangs 4,6,9,11: Có 30 ngày
        //Thang2: năm chia hết cho 4, năm chia hết cho 100 thì phải chia hết cho 400 sẽ có 29 ngày còn không thì 28 ngày
        $day = $_POST["day"];
        $month = $_POST["month"];
        $year = $_POST["year"];
        switch ($month){
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                break;
            case 4: 
            case 6: 
            case 9: 
            case 11: 
                if($day>30){
                    $err_bird = "Lỗi ngày không khớp với tháng.";
                    break;
                }
            case 2:
                if($year%4==0){
                    if($year%100==0){
                        if($year%400==0){
                            if($day>29){
                                $err_bird = "Lỗi ngày không khớp với tháng.";
                            }
                            
                        }
                        else{
                           if($day>28){
                                $err_bird = "Lỗi ngày không khớp với tháng.";
                            } 
                        }
                    }
                    else{
                        if($day>29){
                            $err_bird = "Lỗi ngày không khớp với tháng.";
                        }
                    }
                }
                else{
                   if($day>28){
                        $err_bird = "Lỗi ngày không khớp với tháng.";
                    } 
                }
                    
                
        }
    }
    $bird = strval($year).'-'.strval($month).'-'.strval($day);
    $address = check_data($address);
    
    function check_data($data){
        $data =  trim($data);  //Cắt khoảng trắng 2 đầu
        $data = stripslashes($data); //Cắt bỏ ký tự \
        $data = htmlspecialchars($data);  //Bỏ tác dụng của thẻ HTML, tương tự hàm htmlentities()
        return $data;
    }
    ?>

<?php
    //Hiển thị ra các lỗi trong form
    if(!empty($err_username)){
        $flag = TRUE;
        echo $err_username."<br>";
    }
        
    if(!empty($err_userID)){
        $flag = true;
        echo $err_userID."<br>";
    }
        
    if(!empty($err_password))
    {
        $flag = true;
        echo $err_password."<br>";
    }
        
    if(!empty($err_repass)){
        $flag = true;
        echo $err_repass."<br>";  
    }
        
    if(!empty($errors)){
        $flag = true;
        echo $errors."<br>"; 
    }
        
     if(!empty($err_email)){
        $flag = true;
        echo $$err_email."<br>";
     }
    if(!empty($err_bird)){
        $flag = true;
        echo $err_bird."<br>";
    }
    if(!$flag){
        echo "họ và tên: ".$username."<br>";
        echo "Tên đăng nhập: ".$userID."<br>";
        echo "Email: ".$email."<br>";
        echo "Bird: ".$bird."<br>";
        echo "addresses: ".$address."<br>";
        echo "interest: ".$interest."<br>";
        echo "gender: ".$gender."<br>";

    }
?>

<?php
# đoạn code kết nối cơ sở dữ liệu với PHP
    $servername = "localhost";
    $username_db = "root";
    $password_db ="";
    $dbname = "qlsv";
    // kết nối cơ sở dữ liệu
    $conn = mysqli_connect($servername, $username_db, $password_db, $dbname);
    //kiem tra
    if(!$conn){
        die("Kết nối cơ sở dữ liệu thất bại. ".mysqli_connect_error());
    }
    else{
        echo "Kết nối thành công tới cơ sở dữ liệu mysql";
        $sql = "INSERT INTO regis (user, pass, fullname, bird, email) VALUES ('$userID', '$password', '$username', '$bird', '$email')";
        if(mysqli_query($conn, $sql)){
            echo "Đã kết nối thành công";
        }
        else{
            echo "Có lỗi khi chèn dữ liệu vào cơ sở dữ liệu: ".mysqli_error($conn);
        }
        mysqli_close($conn);
    }
?>


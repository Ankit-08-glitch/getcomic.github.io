<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    </head>
    <body class="b1">
    <div class="login-form">
        <form  method="post" id="Myform">
            <h2 class="text-center" id="hello">Email Verification</h2>   
            <br>    
            <div class="form-group first_box" id="f1">
                <input type="text" id="email" class="form-control" placeholder="Email" required="required">
			    <span id="email_error" class="field_error"></span>
            </div>
            <br>
            <div class="form-group first_box" id="f2">
                <button type="button" class="btn" onclick="send_otp()">Send OTP</button>
            </div>
            <br>
            <div class="form-group second_box" id="s1">
                <input type="text" id="otp" class="form-control" placeholder="OTP" required="required">
                <br>
			    <span id="otp_error" class="field_error"></span>
            </div>
            <div class="form-group second_box" id="s2">
                <button type="button" class="btn" onclick="submit_otp()">Submit OTP</button>
            </div>       
        </form>
    </div>
    <script>
        var otp=Math.floor(Math.random() * (9999 - 1000) + 1000);
        function send_otp()
        {
            const email=document.getElementById("email").value;
            const ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const a1=document.getElementById("f1");
                    const b1=document.getElementById("s1");
                    const a2=document.getElementById("f2");
                    const b2=document.getElementById("s2");
                    a1.style.display="none";
                    a2.style.display="none";
                    b1.style.display="block";
                    b2.style.display="block";
                }
                
            };
	        ajax.open("POST", "send_otp.php");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var data=new FormData();
            data='otp='+otp+email;
            ajax.send(data);
            
        }

        function submit_otp()
        {
            const otp1=document.getElementById("otp").value;
            const ajax1= new XMLHttpRequest();
            const email=document.getElementById("email").value;
            ajax1.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const a=document.getElementById("s1");
                    a.style.margin="0ex 0ex 0ex 15ex";
                    document.getElementById("s1").innerHTML =ajax1.responseText;
                    const b2=document.getElementById("s2");
                    b2.style.display="none";
                    send_mail();
                }
                if(ajax1.responseText=="Incorrect OTP! Please try Again")
                {
                    document.getElementById("s1").innerHTML =ajax1.responseText;
                    const b2=document.getElementById("s2");
                    const a=document.getElementById("s1");
                    a.style.margin="0ex 0ex 0ex 8ex";
                    b2.style.display="none";

                }                
            };
            ajax1.open("POST", "check_otp.php");
            ajax1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var data=new FormData();
            if(otp==otp1)
            r=1;
            else
            r=2;
            console.log(r);
            data='otp='+r+email;
            ajax1.send(data);
        }
        function send_mail()
        {
            const ajax2= new XMLHttpRequest();
            const email=document.getElementById("email").value;
            ajax2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const a=document.getElementById("s1");
                    a.style.margin="0ex 0ex 0ex 15ex";
                    document.getElementById("s1").innerHTML =ajax2.responseText;
                }
            };
            ajax2.open("POST", "demo.php");
            ajax2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var data=new FormData();
            data='email='+email;
            ajax2.send(data);
        }
    </script>
    <style>
        .second_box{display:none;}
        .field_error{color:red;}
    </style>
    </body>
</html>
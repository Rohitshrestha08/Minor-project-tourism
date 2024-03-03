<html>
    <head> <style>
        /*
* Prefixed by https://autoprefixer.github.io
* PostCSS: v8.4.14,
* Autoprefixer: v10.4.7
* Browsers: last 3 version
*/


@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");

:root {
    --primary-color: #f13033;
    --primary-color-dark: #c3282b;
    --secondary-color: #f9f9f9;
    --text-dark: #0f172a;
    --text-light: #64748b;
    --white: #ffffff;
    --bs-blue: #0d6efd;
    --bs-indigo: #6610f2;
    --bs-purple: #6f42c1;
    --bs-pink: #d63384;
    --bs-red: #dc3545;
    --bs-orange: #fd7e14;
    --bs-yellow: #ffc107;
    --bs-green: #198754;
    --bs-teal: #20c997;
    --bs-cyan: #0dcaf0;
    --bs-white: #fff;
    --bs-gray: #6c757d;
    --bs-gray-dark: #343a40;
    --bs-primary: #0d6efd;
    --bs-secondary: #6c757d;
    --bs-success: #198754;
    --bs-info: #0dcaf0;
    --bs-warning: #ffc107;
    --bs-danger: #dc3545;
    --bs-light: #f8f9fa;
    --bs-dark: #212529;
    --max-width: 1300px;
}
section .hotelownemail {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
    min-height: 100vh;
    margin: 0;
    width: 100%;
}
.hotelowner_loginemail {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 400px;
    margin-top: 6%;
    margin-bottom: 6%;
    margin-left: auto;
    margin-right: auto;
    -webkit-box-shadow: 0 0 15px 0 black;
            box-shadow: 0 0 15px 0 black;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
}
.hotelowner_loginemail .title{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
        -ms-flex-direction: row;
            flex-direction: row;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
    padding: 10px;
    color: white;
    background-color: #114bb0;
}

.hotelowner_loginemail form {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin-top: 10px;
    margin-bottom: 20px;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
}

.hotelowner_loginemail .input_hotelowner {
    margin: 10px;
    padding: 5px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
    position: relative;
}

.hotelowner_loginemail .input_hotelowner i {
    position: absolute;
    left: 10px;
    top: 50%; 
    -webkit-transform: translateY(-40%); 
        -ms-transform: translateY(-40%); 
            transform: translateY(-40%);
}

.hotelowner_loginemail .input_hotelowner input {
    height: 30px;
    padding: 5px;
    padding-left: 30px; 
}

.hotelowner_loginemail button {
    width:220px;
    font-size: large;
    margin-bottom: 10px;
    background-color: #007BFF;
    color: white;  
    border: none;
    border-radius: 2px;       
    height: 30px;
    margin:0;
}
.hotelowner_loginemail button:hover{
    background-color: #fcb900;
}
.hotelowner_loginemail .extra {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient:vertical;
    -webkit-box-direction:normal;
        -ms-flex-direction:column;
            flex-direction:column;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
}

.hotelowner_loginemail .extra a {
    color: #007BFF;
    text-decoration: none;
    margin: 10px;
}

.hotelowner_loginemail .extra a:hover {
    text-decoration: underline;
}

    </style>
    </head>
    <section class="hotelownemail">
            <div class="hotelowner_loginemail" id="hotelowner_loginemail">
                <div class="title">
                    <h1>Reset password</h1>
                </div>
                <form method="post" action="">
                    <div class="input_hotelowner">
                        <i class="fas fa-user"></i>
                        <input type="email" name="hotelowner_email" id="hotelowner_email" placeholder="Enter E-mail" required>
                    </div>
                    <button type="submit"name="sendotp">Send Otp</button>
                </form>
            </div>
        </section>
</html>
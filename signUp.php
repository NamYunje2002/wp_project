<!doctype html>
<html lang="en">
<head>
    <title>main</title>
    <meta charset= utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        div.wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            background-color: #ffffff;
            border: 1px solid #121481;
            border-radius: 5px;
        }

        div.container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }

        input {
            width: 250px;
            height: 35px;
            margin: 10px;
            padding: 10px 20px;
            background-color: #ffffff;
            border: 1px solid #121481;
            border-radius: 5px;
            font-size: 20px;
            color: #121481;
        }

        input[type=submit] {
            margin-bottom: 10px;
            height: 75px;
            background-color: #121481;
            color: #ffffff;
            cursor: pointer;
            font-size: 25px;
            font-weight: bold;
        }

        a {
            text-decoration: none;
            color: #121481;
        }

        input[type=button] {
            margin: 30px;
            height: 75px;
            background-color: #ffffff;
            border: 1px solid #121481;
            color: #121481;
            cursor: pointer;
            font-size: 25px;
            font-weight: bold;
        }

        input[type=button]:hover {
            background-color: #121481;
            border: 1px solid #ffffff;
            color: #ffffff;
        }

        .left_container {
            text-align: left;
            width: 90%;
        }

        span {
            display: block;
            width: 100%;
            text-align: left;
            font-size: 15px;
            font-weight: bold;
        }

        select {
            width: 80px;
            height: 35px;
            margin: 10px;
            padding: 5px;
            background-color: #ffffff;
            border: 1px solid #121481;
            border-radius: 5px;
            color: #121481;
        }

        input[type=radio] {
            vertical-align: middle;
            border: 1px solid #121481;
            border-radius: 50%;
            width: 1.25em;
            height: 1.25em;
        }

        label {
            color: #121481;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>SIGN UP</h2>
    <div class="wrapper">
        <form action="" method="post">
            <input type="text" id="id" placeholder="ID" />
            <input type="password" id="pw" placeholder="Password" />
            <input type="password" id="email" placeholder="Email" />
            <div class="left_container">
                <span>Birthday</span>
            </div>
            <div>
                <select id="month"><option selected disabled>Month</option></select>
                <select id="day"><option selected disabled>Day</option></select>
                <select id="year"><option selected disabled>Year</option></select>
            </div>
            <div class="left_container">
                <span>Gencder</span>
            </div>
            <div class="left_container">
                <label for="male">Male</label><input type="radio" name="gender" value="male" id="male">
                <label for="female">Female</label><input type="radio" name="gender" value="female" id="female">
            </div>
            <input type="submit" id="signUpButton" value="Sign Up" />
        </form>
        <hr color="#d6d6d6" width="90%">
        <input type="button" id="signUpButton" value="Cancel" onclick="location.href='./index.php'"/>
    </div>
</div>
<script>
    let monthArr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let monthSelect = document.getElementById('month');
    for(let i = 0; i < monthArr.length; i++) {
        let option = document.createElement('option');
        option.value = i+1;
        option.text = monthArr[i];
        monthSelect.appendChild(option);
    }

    let daySelect = document.getElementById('day');
    for(let i = 1; i <= 31; i++) {
        let option = document.createElement('option');
        option.value = i;
        option.text = i;
        daySelect.appendChild(option);
    }

    let curYear = new Date().getFullYear();
    let yearSelect = document.getElementById('year');
    for(let i = curYear; i >= curYear-100; i--) {
        let option = document.createElement('option');
        option.value = i;
        option.text = i;
        yearSelect.appendChild(option);
    }
</script>
</body>
</html>
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
    </style>
</head>
<body>
<div class="container">
<h2>asdf</h2>
    <div class="wrapper">
        <form action="" method="post">
            <input type="text" id="id" placeholder="ID" />
            <input type="password" id="pw" placeholder="PW" />
            <input type="submit" id="signUpButton" value="Log In" />
            <a href="">Forgot password?</a>
        </form>
        <hr color="#d6d6d6" width="90%">
        <input type="button" id="signUpButton" value="Sign Up" onclick="location.href='./signUp.php'"/>
    </div>
</div>
    <script>
        let a;
    </script>
</body>
</html>
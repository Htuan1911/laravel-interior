<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Không tìm thấy trang</title>
    <style>
        body {
            background-color: #FF7F2E;
            font-family: 'Concert One', cursive;
            margin: 0;
            overflow: hidden;
            padding: 0;
        }

        .text {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(19, 36, 44, 0.1);
            font-size: 30em;
            text-align: center;
        }

        .back-home {
            position: absolute;
            top: calc(40% + 180px);
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            color: #13242C;
            border: none;
            padding: 12px 24px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .back-home:hover {
            background-color: #13242C;
            color: white;
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            height: 300px;
            width: 500px;
        }

        .container::after {
            content: "";
            position: absolute;
            background-color: rgba(19, 36, 44, 0.1);
            border-radius: 12px;
            bottom: 40px;
            height: 12px;
            left: 80px;
            width: 350px;
            z-index: -1;
            animation: shadow-anima 1.2s infinite cubic-bezier(.55, .01, .16, 1.34);
            animation-delay: 0.1s;
        }

        .caveman {
            height: 300px;
            position: absolute;
            width: 250px;
        }

        .caveman:nth-child(1) {
            right: 20px;
        }

        .caveman:nth-child(2) {
            left: 20px;
            transform: rotateY(180deg);
        }

        .head {
            position: absolute;
            background-color: #13242C;
            border-radius: 50px;
            height: 140px;
            left: 60px;
            top: 25px;
            width: 65px;
            animation: head-anima 1.2s infinite cubic-bezier(.55, .01, .16, 1.34);
        }

        .caveman:nth-child(1) .head {
            animation-delay: 0.6s;
        }

        .head::after,
        .head::before {
            content: "";
            position: absolute;
            background-color: #13242C;
            border-radius: 10px;
            height: 20px;
            width: 7px;
        }

        .head::after {
            left: 35px;
            top: -8px;
            transform: rotate(20deg);
        }

        .head::before {
            left: 30px;
            top: -8px;
            transform: rotate(-20deg);
        }

        .eye {
            position: absolute;
            background-color: #EAB08C;
            border-radius: 50px;
            height: 16px;
            left: 45%;
            top: 40px;
            width: 48px;
        }

        .eye::after,
        .eye::before {
            content: "";
            position: absolute;
            background-color: #13242C;
            border-radius: 50%;
            height: 5px;
            width: 5px;
            top: 50%;
            transform: translateY(-50%);
            animation: eye-anima 1.2s infinite cubic-bezier(.55, .01, .16, 1.34);
        }

        .eye::after {
            left: 5px;
        }

        .eye::before {
            right: 9px;
        }

        .caveman:nth-child(1) .eye::after,
        .caveman:nth-child(1) .eye::before {
            animation-delay: 0.6s;
        }

        .nose {
            position: absolute;
            background-color: #D9766C;
            border-left: 8px solid rgba(19, 36, 44, 0.1);
            border-radius: 10px;
            box-sizing: border-box;
            height: 35px;
            left: 45%;
            top: 12px;
            width: 15px;
            transform: translate(-50%, -50%);
        }

        .shape {
            position: absolute;
            left: 50%;
            top: 70px;
            transform: translateX(-50%);
            border-radius: 50%;
            height: 140px;
            width: 140px;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            height: 60px;
            width: 60px;
        }

        .circle::after,
        .circle::before {
            content: "";
            position: absolute;
            border-radius: 50%;
            height: 20px;
            width: 20px;
        }

        .circle:nth-child(1) {
            left: -12px;
            top: 80px;
        }

        .circle:nth-child(1)::after {
            left: 50px;
            top: 10px;
            background-color: #932422;
        }

        .circle:nth-child(1)::before {
            left: 60px;
            top: 45px;
            background-color: #932422;
        }

        .circle:nth-child(2) {
            right: 10px;
            top: 0;
            transform: rotate(90deg);
            background-color: #932422;
        }

        .circle:nth-child(2)::after {
            left: 65px;
            top: 10px;
            background-color: #932422;
        }

        .circle:nth-child(2)::before {
            display: none;
        }

        .caveman:nth-child(1) .shape {
            background-color: #D13433;
        }

        .caveman:nth-child(2) .shape {
            background-color: #932422;
        }

        .arm-right {
            position: absolute;
            background-color: #EAB08C;
            border-left: 8px solid rgba(19, 36, 44, 0.1);
            border-radius: 50px;
            box-sizing: border-box;
            height: 180px;
            left: 135px;
            top: 80px;
            transform-origin: 30px 30px;
            width: 60px;
            z-index: 1;
            animation: arm-anima 1.2s infinite cubic-bezier(.55, .01, .16, 1.34);
        }

        .caveman:nth-child(1) .arm-right {
            animation-delay: 0.6s;
        }

        .club {
            position: absolute;
            border-bottom: 110px solid #601513;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            height: 0;
            left: -60px;
            top: 120px;
            transform: rotate(70deg);
            width: 20px;
        }

        .club::after {
            content: "";
            position: absolute;
            background-color: #601513;
            border-radius: 50%;
            height: 20px;
            width: 20px;
            top: -10px;
            left: 0;
        }

        .club::before {
            content: "";
            position: absolute;
            background-color: #601513;
            border-radius: 50%;
            height: 40px;
            width: 40px;
            top: 90px;
            left: -10px;
        }

        .leg {
            position: absolute;
            border-radius: 10px;
            height: 55px;
            top: 200px;
            width: 10px;
        }

        .leg::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            height: 10px;
            left: -5px;
            top: 15px;
            width: 10px;
        }

        .foot {
            position: absolute;
            border-radius: 25px 25px 0 0;
            height: 25px;
            left: -38px;
            top: 30px;
            width: 50px;
        }

        .foot::after,
        .foot::before,
        .fingers,
        .fingers::after {
            position: absolute;
            background-color: #EAB08C;
            border-radius: 50%;
            bottom: 0;
            height: 15px;
            width: 15px;
            transform-origin: bottom;
        }

        .foot::after {
            left: -6px;
            content: "";
        }

        .foot::before {
            left: 8px;
            transform: scale(0.6);
            content: "";
        }

        .fingers {
            left: 15px;
            transform: scale(0.6);
        }

        .fingers::after {
            left: 11px;
            content: "";
        }

        .leg:nth-child(1) {
            background-color: #B2524D;
            left: 95px;
        }

        .leg:nth-child(1)::after {
            background-color: #B2524D;
        }

        .leg:nth-child(1) .foot {
            background-color: #B2524D;
        }

        .leg:nth-child(1) .foot::after {
            background-color: #B2524D;
        }

        .leg:nth-child(1) .foot::before {
            display: none;
        }

        .leg:nth-child(2) {
            background-color: #D9766C;
            left: 115px;
        }

        .leg:nth-child(2)::after {
            background-color: #D9766C;
        }

        .leg:nth-child(2) .foot {
            background-color: #D9766C;
        }

        @keyframes arm-anima {
            0% {
                transform: rotate(0);
            }

            100% {
                transform: rotate(-360deg);
            }
        }

        @keyframes head-anima {

            0%,
            42% {
                top: 25px;
            }

            45% {
                top: 50px;
            }

            100% {
                top: 25px;
            }
        }

        @keyframes eye-anima {

            0%,
            42% {
                height: 5px;
            }

            45% {
                height: 1px;
            }

            100% {
                height: 5px;
            }
        }

        @keyframes shadow-anima {
            0% {
                width: 350px;
                left: 80px;
            }

            25% {
                width: 450px;
                left: 80px;
            }

            50% {
                width: 350px;
                left: 80px;
            }

            75% {
                width: 450px;
                left: 0px;
            }

            100% {
                width: 350px;
                left: 80px;
            }
        }

        #link {
            bottom: 20px;
            color: #000;
            opacity: 0.2;
            display: flex;
            align-items: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        #link:hover {
            opacity: 1;
        }

        #link p {
            margin: 0;
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <div class="text">
        <p>404</p>
    </div>
    <a href="{{ url('/') }}" class="back-home">Quay về trang chủ</a>

    <div class="container">
        <div class="caveman">
            <div class="leg">
                <div class="foot">
                    <div class="fingers"></div>
                </div>
            </div>
            <div class="leg">
                <div class="foot">
                    <div class="fingers"></div>
                </div>
            </div>
            <div class="shape">
                <div class="circle"></div>
                <div class="circle"></div>
            </div>
            <div class="head">
                <div class="eye">
                    <div class="nose"></div>
                </div>
                <div class="mouth"></div>
            </div>
            <div class="arm-right">
                <div class="club"></div>
            </div>
        </div>
        <div class="caveman">
            <div class="leg">
                <div class="foot">
                    <div class="fingers"></div>
                </div>
            </div>
            <div class="leg">
                <div class="foot">
                    <div class="fingers"></div>
                </div>
            </div>
            <div class="shape">
                <div class="circle"></div>
                <div class="circle"></div>
            </div>
            <div class="head">
                <div class="eye">
                    <div class="nose"></div>
                </div>
                <div class="mouth"></div>
            </div>
            <div class="arm-right">
                <div class="club"></div>
            </div>
        </div>
    </div>

  

</body>

</html>
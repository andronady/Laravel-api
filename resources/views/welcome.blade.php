<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif


<select onchange="findPost()" id="valFind"> </select>

<div id="searchFind"> </div>

<ul> </ul>
        <form enctype="multipart/form-data">
            <input type="text" id="title" placeholder="title">
            <input type="text" id="body" placeholder="body">
            <input type="file" id="input_img" >
            <button onclick="createPost()">add</button>
        </form>
        <div class="content">
            <div class="title m-b-md" id="ajaxSubmit">

            </div>


        </div>
    </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>


    // API GET all posts
        $.ajax({
            url: 'http://127.0.0.1:8000/api/posts',
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                for (var i = 1; i < data.data[0].length; i++) {
                    $('ul').append('<li>title : ' + data.data[0][i].title + '</li>')
                    $('ul').append('<p> Body :' + data.data[0][i].body + '</p>')
                    $('ul').append('<img width="50" height="50" src="images/'+ data.data[0][i].input_img + '"/>')
                    $('#valFind').append('<option>' + data.data[0][i].id + '</option>')
                }

            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
                alert(errorThrown);
            }
        })





    // API CREATE New Post
        function createPost() {

            var title  =  $('#title').val();
            var body  =  $('#body').val();
            var file  =  $('#input_img').val();


            var form = new FormData();
            form.append("title", title);
            form.append("body", body);
            form.append("input_img", $('input[type=file]')[0].files[0], file);

            var settings = {
            "url": "http://127.0.0.1:8000/api/posts",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
            };

            $.ajax(settings).done(function (response) {
            console.log(response);
            });
        }


    // API [GET] find post by id
        function findPost(){
            var id = document.getElementById("valFind").value;
            $.ajax({
                url: 'http://127.0.0.1:8000/api/posts/'+ id,
                dataType: 'json',
                contentType: "application/json",
                type: 'GET',
                cache: false,
                async: true,
                success: function (data) {

                $('#searchFind').html('<div>' + data.data.id + '</div>')

                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                    alert(errorThrown);
                }
            })
        }

    </script>

</body>

</html>

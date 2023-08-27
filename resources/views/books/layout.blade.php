<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Document</title>
</head>

<body>
    <nav class="navbar bg-primary postion-fixed" data-bs-theme="dark">
        <h2 class="navbar-brand m-7">مكتبة الكتب الأدبية العربية</h2>
    </nav>




    <div class="container">
        @yield('content')
    </div>


    <div class="w-100 text-center mt-4 mb-4">
        <button type="button" id="show-books" class="btn btn-danger w-75">ShowMore</button>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $i = 0;
            $('body').on('click', '#show-books', function() {
                console.log('show books');
                $i+=8;
                $.ajax({
                    url: "{{ URL::to('book') }}/" + $i,
                    type: "GET",
                    success: function(data) {
                        console.log('success');
                        console.log(data[23]['title']);
                        var books = data;
                        console.log(books);
                        $nn = 7;
                        while($nn > 0){
                            console.log(data[-$nn]);
                            document.getElementById('content').innerHTML += '<div class="col mt-5" id="cards-all"><div id="cards"> <div class="card" style="width: 18rem;"><img src="'+$data[-$nn]['img_src']+'" class="card-img-top" alt="..." height="300px"><div class="card-body" style="height: 5rem;"><h5 class="card-title m-0 display-inline overflow-hidden">'+$data[-$nn]['title']+'</h5></div><ul class="list-group list-group-flush"><li class="list-group-item">'+$data[-$nn]['pages_count']+'</li><li class="list-group-item">'+$data[-$nn]['author']+'</li><li class="list-group-item">'+$data[-$nn]['publisher']+'</li></ul><div class="card-body bg-danger"><a href="'+$data[-$nn]['pdf_src']+'" class="card-link" style="text-decoration: none; color:white; font-weight: bold;">Download</a></div></div></div></div>';
                            $nn--;
                        }
                      //  for(var book of books) {
                            console.log(book);
                            //console.log(item);
                           // document.getElementById('content').innerHTML += '<div class="col mt-5" id="cards-all"><div id="cards"> <div class="card" style="width: 18rem;"><img src="'+element.img_src+'" class="card-img-top" alt="..." height="300px"><div class="card-body" style="height: 5rem;"><h5 class="card-title m-0 display-inline overflow-hidden">'+element.title+'</h5></div><ul class="list-group list-group-flush"><li class="list-group-item">'+element.pages_count+'</li><li class="list-group-item">'+element.author+'</li><li class="list-group-item">'+element.publisher+'</li></ul><div class="card-body bg-danger"><a href="'+element.pdf_src+'" class="card-link" style="text-decoration: none; color:white; font-weight: bold;">Download</a></div></div></div></div>';
                       // }
                    },
                });
            });
            //$(document).getElementById("spinner").style.display = "block";
            var num = 4;


        });
        //function clicked(){
        /*  $(document).ready(function);
          var x = document.getElementById("cards");
          document.getElementById("spinner").style.display = "block";
          $.ajax({
                url: "{{ URL::to('offer_data') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                  document.getElementById("spinner").style.display = "none";
                },
            });*/
        //}
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        $(document).ready(function(){
            var id_computer;
            var range_hours;


            //au changement du select "ordinateur"
            $('#id_computer').on('change',function(){
                
                
                //récupère le ID de l'ordinateur selectionner
                id_computer = $('#id_computer').val();
                // console.log(id_computer);

                get_hours_1(id_computer);
            })

            //au changement du range_hours
            $('#range_hours').on('change',function(){
                
                $('#screener_range_hours').remove();
                $('#hidden_range_hours').remove();
                
                //récupère le temps choisie avec le range
                range_hours = $(this).val();
                screen_range_hours(range_hours);
            })


        
            //Ajouter un trigger
            $('#id_computer').trigger('change');
            $('#range_hours').trigger('change');
            
            
            })

            //AJAX -- Récupère la première heure disponible pour un Ordinateur
            function get_hours_1(id_computer){
                $.ajax({
                    type:"POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"home/id_computer",
                    dataType:"json",
                    data:{
                        'id_computer': id_computer},
                        'success': function(data){
                            show_value_of_filter(data);
                        },
                        'error': function(){
                        }
                });
            }


            function show_value_of_filter(data){
                
                    $.each(data,function(idx,el){
                        $( "#input_hours" ).remove();
                        $('#heure').append('<input type="text" class="form-control" name="hours" value="'+el+'" id="input_hours" placeholder="00h00">');
                    });
            }

            //affiche le temps selectionner
            function screen_range_hours(range_hours){
                if(range_hours < 60){
                    // $('#screen_range_hours').remove();

                    $('#screen_range_hours').append('<input type="hidden" id="hidden_range_hours" name="range_hours" value="'+range_hours+'">');
                    $('#screen_range_hours').append('<h4><p id="screener_range_hours">'+range_hours+'min</p></h4>');

                }else if(range_hours >= 240){
                    $('#screen_range_hours').append('<input type="hidden" id="hidden_range_hours" name="range_hours" value="'+range_hours+'"></h4>');
                    range_hours = range_hours - 240;
                    if(range_hours == 60){
                        range_hours = 0;
                    }
                    $('#screen_range_hours').append('<h4><p id="screener_range_hours">4H'+range_hours+'</p></h4>');
                    

                }else if(range_hours >= 180){
                    $('#screen_range_hours').append('<input type="hidden" id="hidden_range_hours" name="range_hours" value="'+range_hours+'">');
                    range_hours = range_hours - 180;
                    if(range_hours == 60){
                        range_hours = 0;
                    }
                    $('#screen_range_hours').append('<h4><p id="screener_range_hours">3H'+range_hours+'</p></h4>');                    
                
                }else if(range_hours >= 120){
                    $('#screen_range_hours').append('<input type="hidden" id="hidden_range_hours" name="range_hours" value="'+range_hours+'">');
                    range_hours = range_hours - 120;
                    if(range_hours == 60){
                        range_hours = 0;
                    }
                    $('#screen_range_hours').append('<h4><p id="screener_range_hours">2H'+range_hours+'</p></h4>');
                
                }else if(range_hours >= 60){
                    $('#screen_range_hours').append('<input type="hidden" id="hidden_range_hours" name="range_hours" value="'+range_hours+'">');
                    range_hours = range_hours - 60;
                    if(range_hours == 60){
                        range_hours = 0;
                    }
                    $('#screen_range_hours').append('<h4><p id="screener_range_hours">1H'+range_hours+'</p></h4>');
                
                }

            }

        


    </script>
    

</body>
</html>

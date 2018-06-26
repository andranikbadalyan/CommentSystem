<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Comment System') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container p-0" id="app">
            <div class="container bg-yellow  rounded-bottom pt-2 pb-3 mb-3">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ac porttitor purus. Nulla pretium libero vitae libero suscipit, a euismod augue ornare. Suspendisse potenti. Suspendisse lectus magna, eleifend a eros sed, bibendum iaculis ante. Vestibulum volutpat tristique sodales.</p>

                <h2 class="text-center p-4 mt-5 m-4" v-if="!comments.length">
                    Be the first to comment <i class="fa fa-smile-o"></i>
                </h2>
                <div class="text-center" v-else>
                    <a href="#" class="text-center" @click.prevent="truncate">Truncate</a>
                    <h2>Start commenting below...</h2>
                </div>
            </div>



            <comment-form></comment-form>




            <div class="comments" v-if="comments.length">
                <show-comments :comments="comments"></show-comments>
            </div>

        </div>
    </body>
</html>

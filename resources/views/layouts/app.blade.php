<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('js/tagsinput/tagsinput.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .tag{
            padding-left:5px!important;
            margin: 1px;
        }
        .document-editor {
            border: 1px solid var(--ck-color-base-border);
            border-radius: var(--ck-border-radius);

            /* Set vertical boundaries for the document editor. */
            max-height: 700px;

            /* This element is a flex container for easier rendering. */
            display: flex;
            flex-flow: column nowrap;
        }
        .document-editor__toolbar {
            /* Make sure the toolbar container is always above the editable. */
            z-index: 1;

            /* Create the illusion of the toolbar floating over the editable. */
            box-shadow: 0 0 5px hsla( 0,0%,0%,.2 );

            /* Use the CKEditor CSS variables to keep the UI consistent. */
            border-bottom: 1px solid var(--ck-color-toolbar-border);
        }

        /* Adjust the look of the toolbar inside the container. */
        .document-editor__toolbar .ck-toolbar {
            border: 0;
            border-radius: 0;
        }
        /* Make the editable container look like the inside of a native word processor application. */
        .document-editor__editable-container {
            padding: calc( 2 * var(--ck-spacing-large) );
            background: var(--ck-color-base-foreground);

            /* Make it possible to scroll the "page" of the edited content. */
            overflow-y: scroll;
        }

        .document-editor__editable-container .ck-editor__editable {
            /* Set the dimensions of the "page". */
            width: 15.8cm;
            min-height: 21cm;

            /* Keep the "page" off the boundaries of the container. */
            padding: 1cm 2cm 2cm;

            border: 1px hsl( 0,0%,82.7% ) solid;
            border-radius: var(--ck-border-radius);
            background: white;

            /* The "page" should cast a slight shadow (3D illusion). */
            box-shadow: 0 0 5px hsla( 0,0%,0%,.1 );

            /* Center the "page". */
            margin: 0 auto;
        }
        /* Set the default font for the "page" of the content. */
        .document-editor .ck-content,
        .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
            font: 16px/1.6 "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        /* Adjust the headings dropdown to host some larger heading styles. */
        .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
            line-height: calc( 1.7 * var(--ck-line-height-base) * var(--ck-font-size-base) );
            min-width: 6em;
        }

        /* Scale down all heading previews because they are way too big to be presented in the UI.
        Preserve the relative scale, though. */
        .document-editor .ck-heading-dropdown .ck-list .ck-button:not(.ck-heading_paragraph) .ck-button__label {
            transform: scale(0.8);
            transform-origin: left;
        }

        /* Set the styles for "Heading 1". */
        .document-editor .ck-content h2,
        .document-editor .ck-heading-dropdown .ck-heading_heading1 .ck-button__label {
            font-size: 2.18em;
            font-weight: normal;
        }

        .document-editor .ck-content h2 {
            line-height: 1.37em;
            padding-top: .342em;
            margin-bottom: .142em;
        }

        /* Set the styles for "Heading 2". */
        .document-editor .ck-content h3,
        .document-editor .ck-heading-dropdown .ck-heading_heading2 .ck-button__label {
            font-size: 1.75em;
            font-weight: normal;
            color: hsl( 203, 100%, 50% );
        }

        .document-editor .ck-heading-dropdown .ck-heading_heading2.ck-on .ck-button__label {
            color: var(--ck-color-list-button-on-text);
        }

        /* Set the styles for "Heading 2". */
        .document-editor .ck-content h3 {
            line-height: 1.86em;
            padding-top: .171em;
            margin-bottom: .357em;
        }

        /* Set the styles for "Heading 3". */
        .document-editor .ck-content h4,
        .document-editor .ck-heading-dropdown .ck-heading_heading3 .ck-button__label {
            font-size: 1.31em;
            font-weight: bold;
        }

        .document-editor .ck-content h4 {
            line-height: 1.24em;
            padding-top: .286em;
            margin-bottom: .952em;
        }

        /* Set the styles for "Paragraph". */
        .document-editor .ck-content p {
            font-size: 1em;
            line-height: 1.63em;
            padding-top: .5em;
            margin-bottom: 1.13em;
        }
        /* Make the block quoted text serif with some additional spacing. */
        .document-editor .ck-content blockquote {
            font-family: Georgia, serif;
            margin-left: calc( 2 * var(--ck-spacing-large) );
            margin-right: calc( 2 * var(--ck-spacing-large) );
        }
        #snippet-autosave-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--ck-color-toolbar-background);
            border: 1px solid var(--ck-color-toolbar-border);
            padding: 10px;
            border-radius: var(--ck-border-radius);
            margin-top: -0.5em;
            margin-bottom: 1.5em;
            border-top: 0;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        #snippet-autosave-status.busy #snippet-autosave-status_spinner-label::after {
            content: 'Sauvegarde en cours...';
            color: red;
        }
        #snippet-autosave-status_spinner {
            display: flex;
            align-items: center;
            position: relative;
        }
        #snippet-autosave-status_spinner-label::after {
            content: 'Sauvegardé !';
            color: green;
            display: inline-block;
            margin-right: var(--ck-spacing-medium);
        }
        #snippet-autosave-status_spinner-label {
            position: relative;
        }
        #snippet-autosave-status_label {
            font-weight: bold;
            margin-right: var(--ck-spacing-medium);
        }
        #snippet-autosave-status, #snippet-autosave-server {
            display: flex;
            align-items: center;
        }
        .page-header {
            padding-bottom: 9px;
            border-bottom: 1px solid #eee;
        }
        .info {
            margin-bottom: .5em;
            color: #a0a0a0;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                            <li class="nav-item active">
                                <a class="nav-link" href="/">Articles </a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="/faq">FAQ</a>
                            </li>
                        @else
                            <li class="nav-item active">
                                <a class="nav-link" href="/">Articles </a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="/drafts">Drafts</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="/faq">FAQ</a>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="/users/{{ Auth::user()->id }}">
                                        Mes préférences
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @yield('content')    
            </div>
        </main>
    </div>
    <script src="{{ asset('js/ckeditor5/ckeditor.js') }}" defer></script>
    <script src="{{ asset('js/tagsinput/tagsinput.js') }}" defer></script>
    <script>
    if(document.querySelector( '.document-editor__editable' ))
    document.addEventListener("DOMContentLoaded", function(event) {
        if(document.querySelector('[name="title"]')){ // save on blur title and heading
            document.querySelector('[name="title"]').addEventListener("blur", throttle(saveData, 500))
            document.querySelector('[name="heading"]').addEventListener("blur", throttle(saveData, 500))
            document.querySelector('[name="tags"]').addEventListener("blur", throttle(saveData, 500))
        }
        ClassicEditor
            .create( document.querySelector( '.document-editor__editable' ),{
                autosave: window.location.pathname.startsWith('/articles/') ? {} : {
                    waitingTime: 2000,
                    save( editor ) {
                        return saveData( editor.getData() );
                    }
                },
            })
            .then( editor => {
                if(window.location.pathname.startsWith('/articles/')){
                    editor.isReadOnly = true;
                    document.querySelector('.ck-editor__top').style.visibility = "hidden";
                    editor.config._config.autosave = {}
                }else{
                    const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                    displayStatus( editor );
                    handleBeforeunload( editor );
                }             

                const wordCountPlugin = editor.plugins.get( 'WordCount' );
                const wordCountWrapper = document.getElementById( 'word-count' );
                wordCountWrapper.appendChild( wordCountPlugin.wordCountContainer );
             

                window.editor = editor;
            } )
            .catch( error => {
                console.error( error );
            } );
    });
        
    function displayStatus( editor ) {
        const pendingActions = editor.plugins.get( 'PendingActions' );
        const statusIndicator = document.querySelector( '#snippet-autosave-status' );
        const spinner =  document.querySelector( '#snippet-autosave-status_spinner-loader')

        pendingActions.on( 'change:hasAny', ( evt, propertyName, newValue ) => {
            if ( newValue ) {
                statusIndicator.classList.add( 'busy' );
                spinner.classList.add('text-danger')
                spinner.classList.add('spinner-border')
                
            } else {
                statusIndicator.classList.remove( 'busy' );
                spinner.classList.remove('text-danger')
                spinner.classList.remove( 'spinner-border' );
                
            }
        } );
    }
    
    function handleBeforeunload( editor ) {
        const pendingActions = editor.plugins.get( 'PendingActions' );

        window.addEventListener( 'beforeunload', evt => {
            if ( pendingActions.hasAny ) {
                evt.preventDefault();
            }
        } );
    }

    function saveData( data ) {
        let form = document.querySelector( '#form-editor')
        if(!form)
            return
        let formdata = new FormData(form)
        formdata.set('body', editor.getData())
        return new Promise( (resolve, reject) => {
            window.axios.post(`${form.action}`, formdata).then( () =>{
                resolve();
            }).catch( (error) =>{
                console.log(error)
                reject();
            })
        } );
    }

    function throttle (callback, limit) {
        var wait = false;                  // Initially, we're not waiting
        return function () {               // We return a throttled function
            if (!wait) {                   // If we're not waiting
                callback.call();           // Execute users function
                wait = true;               // Prevent future invocations
                setTimeout(function () {   // After a period of time
                    wait = false;          // And allow future invocations
                }, limit);
            }
        }
    }
    
        
</script>
</body>
</html>

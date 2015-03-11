({
    appDir: '.',
    baseUrl: '.',
    dir: '../admin-build',
    'paths': {
        'jquery': 'com/ext/jquery/jquery-1.8.3',
        'jqueryui': 'com/ext/jquery/jquery-ui.min',
        'underscore': 'com/ext/underscore/underscore-min-1.6.0',
        'backbone': 'com/ext/backbone/backbone-min-1.1.2',
        'bootstrap': 'com/ext/bootstrap/js/bootstrap',
        'text': 'com/ext/require/text',
        'jquery.qtip': 'com/ext/jquery/qtip/jquery.qtip.min',
        'jquery.ui.widget': 'com/ext/jquery/jquery.ui.widget',
        'noty': 'com/ext/jquery/noty/jquery.noty',
        'notyLayout': 'com/ext/jquery/noty/layouts/top',
        'notyInline': 'com/ext/jquery/noty/layouts/inline',
        'notyTheme': 'com/ext/jquery/noty/themes/default',
        // 'iframetransport'			: 'com/ext/jquery.iframe-transport',
        'tagit': 'com/ext/jquery/tagit/tag-it',
        'tagselect': 'com/ext/jquery/tagselect/chosen.jquery',
        'appendGrid': 'com/ext/jquery/appendGrid/jquery.appendGrid-1.3.1.min',
        'tagmanager': 'com/ext/jquery/tagsManager/tagmanager',
        'jquery.fileupload': 'com/ext/jquery/jquery.fileupload',
        'jquery.custom.ui': 'com/ext/jquery-ui-1.8.16.custom.min',
        'paginate': 'com/ext/jquery/jquery.paginate',
        'ckeditor': 'com/ext/ckeditor/ckeditor',
        'jqckadapter': 'com/ext/ckeditor/adapters/jquery',
        'jquery.validate'           : 'com/ext/jquery/jquery.validate.min',
        'jquery.tablescroll': 'com/ext/jquery/jquery.tableScroll/jquery.tablescroll',
        'multiselect'                : 'com/ext/jquery/multiselect/jquery.multiselect',
        'filter'                  : 'com/ext/jquery/multiselect/filter'
        // 'jquery.ui.core'				: 'com/ext/dragndrop/jquery.ui.core',
        // 'jquery.ui.mouse'				: 'com/ext/dragndrop/jquery.ui.mouse',
        // 'jquery.ui.sortable'			: 'com/ext/dragndrop/jquery.ui.sortable',
        // 'jquery.jqplot'				: 'com/ext/jqplot/jquery.jqplot.min',
        // 'shcore'						: 'com/ext/jqplot/shCore.min',
        // 'shbrushjscript'				: 'com/ext/jqplot/shBrushJScript.min',
        // 'shbrushxml'					: 'com/ext/jqplot/shBrushXml.min',
        // 'jqplot.dateaxisrenderer'		: 'com/ext/jqplot/jqplot.dateAxisRenderer.min',
        // 'jqplot.highlighter'			: 'com/ext/jqplot/jqplot.highlighter.min',
        // 'jqplot.cursor'				: 'com/ext/jqplot/jqplot.cursor.min',
    },
    'shim': {
        'backbone': {
            deps: ['underscore', 'jquery'],
            exports: 'backbone'
        },
        'bootstrap': {
            deps: ['jquery'],
            exports: 'bootstrap'
        },
        'jquery.custom.ui': {
            deps: ['jquery']
        },
        'tagit': {
            deps: ['jquery', 'jqueryui'],
            exports: 'tagit'
        },
        'tagselect': {
            deps: ['jquery', 'jqueryui'],
            exports: 'tagselect'
        },
        'appendGrid': {
            deps: ['jquery', 'jqueryui'],
            exports: 'appendGrid'
        },
        'tagmanager': {
            deps: ['jquery', 'jqueryui'],
            exports: 'tagmanager'
        },
        'jquery.ui.widget': {
            deps: ['jquery']
        },
        'paginate': {
            deps: ['jquery']
        },
        'jquery.fileupload': {
            deps: ['jquery', 'jquery.ui.widget']
        },
        'noty': {
            deps: ['jquery', 'jqueryui'],
            exports: 'noty'
        },
        'notyTheme': {
            deps: ['noty'],
            exports: 'notyTheme'
        },
        'notyLayout': {
            deps: ['noty'],
            exports: 'notyLayout'
        },
        'notyInline': {
            deps: ['noty'],
            exports: 'notyInline'
        },
        'ckeditor': {
            deps: ['jquery'],
            exports: 'CKEDITOR'
        },
        'jqckadapter': {
            deps: ['jquery', 'ckeditor'],
            exports: 'jqckadapter'
        },
        'jquery.validate': {
            deps: ['jquery']
        },
        'jquery.tablescroll': {
            deps: ['jquery', 'jqueryui']
        },
        'multiselect': {
            deps: ['jquery', 'jqueryui'],
            exports: 'multiselect'
        },
        'filter': {
            deps: ['jquery', 'jqueryui'],
            exports: 'filter'
        }
    },
    modules: [{
        name: 'main'
    }],
    preserveLicenseComments: false,
    optimizeAllPluginResources: true,
    findNestedDependencies: true,
    removeCombined: true
    /*
	cssIn: "assets/css/main.css",
    out: "./assets/css/main-min.css"
	*/
})
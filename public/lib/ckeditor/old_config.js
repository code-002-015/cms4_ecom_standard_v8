/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.dtd.$removeEmpty['span'] = false;
CKEDITOR.dtd.$removeEmpty['i'] = false;
CKEDITOR.dtd.$removeEmpty['a'] = false;
CKEDITOR.editorConfig = function(config) {

    // %REMOVE_START%
    // The configuration options below are needed when running CKEditor from source files.
    config.plugins = 'dialogui,dialog,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,notification,button,toolbar,clipboard,panelbutton,panel,floatpanel,colorbutton,colordialog,templates,menu,contextmenu,copyformatting,resize,elementspath,enterkey,entities,popup,filetools,filebrowser,find,fakeobjects,floatingspace,listblock,richcombo,font,format,horizontalrule,htmlwriter,iframe,wysiwygarea,image,indent,indentblock,indentlist,justify,menubutton,language,link,list,liststyle,magicline,maximize,pagebreak,pastetext,pastefromword,preview,print,removeformat,selectall,showblocks,showborders,sourcearea,scayt,stylescombo,tab,table,tabletools,tableselection,undo,lineutils,widgetselection,widget,notificationaggregator,uploadwidget,uploadimage,wsc,imagebrowser';
    config.extraPlugins = 'justify';
    config.removeButtons = 'Save,NewPage,Form,Templates,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Flash,Smiley,About,Language';
    config.skin = 'moono-lisa';
    config.toolbar=[
    { name: 'document', items : ['Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates'] },
    { name: 'clipboard', items : ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'] },
    { name: 'editing', items : ['Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt'] },
    { name: 'forms', items : ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
    { name: 'basicstyles', items : ['Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'] },
    { name: 'links', items : ['Link','Unlink','Anchor'] },
    { name: 'colors', items : ['TextColor','BGColor'] },
    '/',
    { name: 'insert', items : ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'] },
    { name: 'paragraph', items : ['NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'] },
    { name: 'styles', items : ['Styles','Format','Font','FontSize'] },
    ];
    // config.toolbarGroups = [
    //     { name: 'document', groups: ['mode', 'document', 'doctools'] },
    //     { name: 'clipboard', groups: ['clipboard', 'undo'] },
    //     { name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
    //     { name: 'forms', groups: ['forms'] },
    //     { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
    //     { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'justify', 'bidi', 'paragraph' ] },
    //     { name: 'links', groups: ['links'] },
    //     { name: 'insert', groups: ['insert'] },
    //     { name: 'styles', groups: ['styles'] },
    //     { name: 'colors', groups: ['colors'] },
    //     { name: 'tools', groups: ['tools'] },
    //     { name: 'others', groups: ['others'] },
    //     { name: 'about', groups: ['about'] }
    // ];
    // %REMOVE_END%

    // For laravel file manager upload to server
    config.filebrowserUploadMethod = 'form';

    config.allowedContent = true;
    config.protectedSource.push(/<i[^>]*><\/i>/g);
    config.protectedSource.push(/<span[^>]*><\/span>/g);
    config.protectedSource.push(/<a[^>]*><\/a>/g);

    let prefix = '';
    if (window.location.origin.includes('cms4.webfocusprod.wsiph2.com')) {
        prefix = '/sysup2/public/theme/sysu/';
    } else {
        prefix = '/theme/sysu/';
    }

    config.contentsCss = [window.location.origin + prefix + 'plugins/bootstrap/css/bootstrap.css',
        window.location.origin + prefix + 'plugins/fontawesome/css/all.min.css',
        window.location.origin + prefix + 'plugins/linearicon/linearicon.min.css',
        window.location.origin + prefix + 'plugins/responsive-tabs/css/responsive-tabs.css',
        window.location.origin + prefix + 'plugins/slick/slick.css',
        window.location.origin + prefix + 'plugins/slick/slick-theme.css',
        window.location.origin + prefix + 'css/tagsinput.min.css',
        window.location.origin + prefix + 'plugins/rd-navbar/rd-navbar.css',
        window.location.origin + prefix + 'plugins/aos/dist/aos.min.css',
        window.location.origin + prefix + 'css/animate.min.css',
        window.location.origin + prefix + 'css/style.css'];

    config.filebrowserImageBrowseUrl = window.location.origin + '/laravel-filemanager?type=Images';
    config.filebrowserImageUpload = window.location.origin + '/laravel-filemanager/upload?type=Images';
    config.filebrowserBrowseUrl = window.location.origin + '/laravel-filemanager?type=Files';
    config.filebrowserUploadUrl = window.location.origin + '/laravel-filemanager/upload?type=Files';

    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
};
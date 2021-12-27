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
    // config.plugins = 'dialogui,dialog,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,notification,button,toolbar,clipboard,panelbutton,panel,floatpanel,colorbutton,colordialog,templates,menu,contextmenu,copyformatting,resize,elementspath,enterkey,entities,popup,filetools,filebrowser,find,fakeobjects,floatingspace,listblock,richcombo,font,format,horizontalrule,htmlwriter,iframe,wysiwygarea,image,indent,indentblock,indentlist,justify,menubutton,language,link,list,liststyle,magicline,maximize,pagebreak,pastetext,pastefromword,preview,print,removeformat,selectall,showblocks,showborders,sourcearea,scayt,stylescombo,tab,table,tabletools,tableselection,undo,lineutils,widgetselection,widget,notificationaggregator,uploadwidget,uploadimage,wsc,imagebrowser';
    config.removeButtons = 'Save,NewPage,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Flash,Smiley,SpecialChar,About';

    config.skin = 'moono-lisa';
    config.toolbarGroups = [
        { name: 'document', groups: ['mode', 'document', 'doctools'] },
        { name: 'clipboard', groups: ['clipboard', 'undo'] },
        { name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
        { name: 'forms', groups: ['forms'] },
        { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
        { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph'] },
        { name: 'links', groups: ['links'] },
        { name: 'insert', groups: ['insert'] },
        { name: 'styles', groups: ['styles'] },
        { name: 'colors', groups: ['colors'] },
        { name: 'tools', groups: ['tools'] },
        { name: 'others', groups: ['others'] },
        { name: 'about', groups: ['about'] }
    ];
    // %REMOVE_END%

    // For laravel file manager upload to server
    config.filebrowserUploadMethod = 'form';

    config.allowedContent = true;
    config.protectedSource.push(/<i[^>]*><\/i>/g);
    config.protectedSource.push(/<span[^>]*><\/span>/g);
    config.protectedSource.push(/<a[^>]*><\/a>/g);

    let prefix = '';
    if (window.location.origin.includes('cms4.webfocusprod.wsiph2.com')) {
        prefix = '/stpaul/public/theme/stpaul/';
    } else {
        prefix = '/theme/stpaul/';
    }

    config.contentsCss = [window.location.origin + prefix + 'plugins/bootstrap/css/bootstrap.css',
        window.location.origin + prefix + 'plugins/font-awesome/css/all.min.css',
        window.location.origin + prefix + 'plugins/linearicon/css/linearicons.min.css',
        window.location.origin + prefix + 'plugins/responsive-tabs/css/responsive-tabs.css',
        window.location.origin + prefix + 'plugins/slick/slick.css',
        window.location.origin + prefix + 'plugins/slick/slick-theme.css',
        window.location.origin + prefix + 'css/tagsinput.min.css',
        window.location.origin + prefix + 'plugins/rd-navbar/rd-navbar.css',
        window.location.origin + prefix + 'plugins/aos/dist/aos.min.css',
        window.location.origin + prefix + 'css/animate.min.css',
        window.location.origin + prefix + 'css/style.css'];

    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
};

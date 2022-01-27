var editorgjs = grapesjs.init({
    height: "100%",
    container: "#gjs",
    fromElement: 1,
    showOffsets: 1,
    colorPicker: { appendTo: "parent", offset: { top: 20, left: -175 } },
    storageManager: {
        id: "gjs-", // Prefix identifier that will be used on parameters
        type: "remote", //type: 'local', type: 'remote',Type of the storage
        autosave: false, // Store data automatically
        autoload: true, // Autoload stored data on init
        urlStore: "store.php?id=<?php echo $id; ?>",
        urlLoad: "load.php?id=<?php echo $id; ?>",
        contentTypeJson: false,
        storeComponents: true,
        storeStyles: true,
        storeHtml: true,
        storeCss: true,

        //stepsBeforeSave: 1 // If autosave enabled, indicates how many changes are necessary before store method is triggered
    },
    plugins: [
        PB4,
        "grapesjs-custom-code",
        "grapesjs-parser-postcss",
        "grapesjs-tooltip",
        "grapesjs-tui-image-editor",
        "grapesjs-style-bg",
        "grapesjs-style-gradient",
        "grapesjs-plugin-ckeditor",
        "grapesjs-plugin-export",
        "grapesjs-blocks-bootstrap4",
        PB4CustomBlocks,
    ],
    pluginsOpts: {
        "grapesjs-blocks-bootstrap4": {
            blocks: {
                image: false,
            },
            blockCategories: {
                components: false,
            },
        },
        "grapesjs-tabs": {
            tabsBlock: {
                category: "Extra",
            },
        },
        "grapesjs-style-gradient": {},
        "gjs-plugin-ckeditor": {
            options: {
                language: "en",
                toolbar: [
                    {
                        name: "document",
                        groups: ["mode", "document", "doctools"],
                    },
                    { name: "clipboard", groups: ["clipboard", "undo"] },
                    {
                        name: "editing",
                        groups: [
                            "find",
                            "selection",
                            "spellchecker",
                            "editing",
                        ],
                    },
                    { name: "forms", groups: ["forms"] },
                    "/",
                    { name: "basicstyles", groups: ["basicstyles", "cleanup"] },
                    {
                        name: "paragraph",
                        groups: [
                            "list",
                            "indent",
                            "blocks",
                            "align",
                            "bidi",
                            "paragraph",
                        ],
                    },
                    { name: "links", groups: ["links"] },
                    { name: "insert", groups: ["insert"] },
                    "/",
                    { name: "styles", groups: ["styles"] },
                    { name: "colors", groups: ["colors"] },
                    { name: "tools", groups: ["tools"] },
                    { name: "others", groups: ["others"] },
                    { name: "about", groups: ["about"] },
                ],
                removeButtons:
                    "Source,Save,NewPage,Preview,Templates,Print,ExportPdf,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField",
            },
        },
    },
    canvas: {
        styles: [
            '{{ env('APP_URL') }}/theme/cms4/css/bootstrap.css',
            '{{ env('APP_URL') }}theme/cms4/css/style-vars.css'
            // "{{ asset('theme/cms4/css/dark.css') }}",
            // "{{ asset('theme/cms4/css/font-icons.css') }}",
            // "{{ asset('theme/cms4/css/et-line.css') }}",
            // "{{ asset('theme/cms4/css/animate.css') }}",
            // "{{ asset('theme/cms4/css/magnific-popup.css') }}",
            // "{{ asset('theme/cms4/include/cookie-alert/cookiealert.css') }}",
            // "{{ asset('theme/cms4/include/slick/slick.css') }}",
            // "{{ asset('theme/cms4/include/slick/slick-theme.css') }}",
            // "{{ asset('theme/cms4/css/responsive.css') }}",
            // "{{ asset('theme/cms4/css/custom.css') }}",
        ],
        scripts: [
            "https://code.jquery.com/jquery-3.3.1.slim.min.js",
            "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js",
            "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js",
        ],
    },
});

editorgjs.I18n.addMessages({
    en: {
        styleManager: {
            properties: {
                "background-repeat": "Repeat",
                "background-position": "Position",
                "background-attachment": "Attachment",
                "background-size": "Size",
            },
        },
    },
});

var pn = editorgjs.Panels;
var modal = editorgjs.Modal;
var cmdm = editorgjs.Commands;

cmdm.add("update-page", {
    run: function (em, sender) {
        sender.set("active", true);
        updateContent();
    },
});

function updateContent() {
    var idp = "<?php echo $id; ?>";
    var content = editorgjs.getHtml(); //get html content of document
    var style = editorgjs.getCss(); //get css content of document
    // Get edit field value
    $.ajax({
        url: "update.php",
        type: "post",
        data: { idp: idp, content: content, style: style },
    }).done(function (rsp) {
        alert(rsp);
    });
}

editorgjs.StyleManager.addProperty("decorations", {
    name: "Gradient",
    property: "background-image",
    type: "gradient",
    defaults: "none",
});

// Simple warn notifier
var origWarn = console.warn;
toastr.options = {
    closeButton: true,
    preventDuplicates: true,
    showDuration: 250,
    hideDuration: 150,
};
console.warn = function (msg) {
    if (msg.indexOf("[undefined]") == -1) {
        toastr.warning(msg);
    }
    origWarn(msg);
};

var titles = document.querySelectorAll("*[title]");

for (var i = 0; i < titles.length; i++) {
    var el = titles[i];
    var title = el.getAttribute("title");
    title = title ? title.trim() : "";
    if (!title) break;
    el.setAttribute("data-tooltip", title);
    el.setAttribute("title", "");
}

// Add and beautify tooltips

[
    ["sw-visibility", "Show Borders"],
    ["preview", "Preview"],
    ["fullscreen", "Fullscreen"],
    ["export-template", "View Code"],
    ["undo", "Undo"],
    ["redo", "Redo"],
].forEach(function (item) {
    pn.getButton("options", item[0]).set("attributes", {
        title: item[1],
        "data-tooltip": item[1],
        "data-tooltip-pos": "bottom",
    });
});

[
    ["open-sm", "Style Manager"],
    ["open-tm", "Trait Manager"],
    ["open-layers", "Layers"],
    ["open-blocks", "Blocks"],
].forEach(function (item) {
    pn.getButton("views", item[0]).set("attributes", {
        title: item[1],
        "data-tooltip": item[1],
        "data-tooltip-pos": "bottom",
    });
});

// Show borders by default
pn.getButton("options", "sw-visibility").set("active", 1);

// Store and load events
editorgjs.on("storage:load", function (e) {
    console.log("Loaded ", e);
});
editorgjs.on("storage:store", function (e) {
    console.log("Stored ", e);
});

// Do stuff on load
editorgjs.on("load", function () {
    var $ = grapesjs.$;

    // Load and show settings and style manager
    var openBlkBtn = pn.getButton("views", "open-blocks");
    openBlkBtn && openBlkBtn.set("active", 1);
});

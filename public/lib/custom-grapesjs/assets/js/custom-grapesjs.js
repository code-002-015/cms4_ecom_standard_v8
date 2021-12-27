window.onerror = null;
const CodeMirror_config = {
	export: {
		readOnly: 1,
		theme: "hopscotch",
		autoBeautify: true,
		lineWrapping: true,
		smartIndent: true,
		indentWithTabs: true,
	},
	import: {
		readOnly: 0,
		theme: "hopscotch",
		autoBeautify: true,
		autoCloseTags: true,
		autoCloseBrackets: true,
		lineWrapping: true,
		styleActiveLine: true,
		smartIndent: true,
		indentWithTabs: true,
	},
};

const editor = grapesjs.init({
    height: "100%",
    showOffsets: 1,
    avoidDefaults: 1,
    noticeOnUnload: 0,
    container: "#gjs",
    fromElement: 0,
    storageManager: {
        type: "simpleStorage",
        autoload: true,
    },
    plugins: [
        PB4,
        "grapesjs-blocks-basic",
        "grapesjs-parser-postcss",
        "grapesjs-tooltip",
        "grapesjs-style-bg",
        "grapesjs-plugin-export",
        "grapesjs-blocks-bootstrap4",
        PB4CustomBlocks,
        "grapesjs-plugin-ckeditor",
        gjsAnimation,
    ],
    pluginsOpts: {
        "grapesjs-blocks-basic": {
            blocks: ["text", "image", "video", "map"],
        },
        "grapesjs-blocks-bootstrap4": {
            blocks: {
                image: false,
                // container: false,
                map: false,
                video: false,
                link: false,
            },
            blockCategories: {
                components: false,
                forms: false,
            },
        },
        "grapesjs-style-bg": {},
        "grapesjs-plugin-ckeditor": {
            options: {
                language: "en",
                toolbar: [
                    {
                        name: "basicstyles",
                        groups: ["basicstyles", "cleanup"],
                        items: ["Bold", "Italic", "Underline", "Strike"],
                    },
                    {
                        name: "paragraph",
                        items: [
                            // "JustifyLeft",
                            // "JustifyCenter",
                            // "JustifyRight",
                            // "JustifyBlock",
                            "NumberedList",
                            "BulletedList",
                        ],
                    },
                    { name: "links", items: ["Link", "Unlink"] },
                    { name: "colors", items: ["TextColor", "BGColor"] },
                ],
            },
        },
    },

    canvas: {
        styles: [
            app_url + "/theme/sysu/css/fonts/default.css",
            app_url + "/theme/sysu/css/bootstrap.css",
            app_url + "/theme/sysu/css/style-vars.css",
            app_url + "/theme/sysu/css/dark.css",
            app_url + "/theme/sysu/css/font-icons.css",
            app_url + "/theme/sysu/css/et-line.css",
            app_url + "/theme/sysu/css/medical-icons.css",
            app_url + "/theme/sysu/css/realestate-icons.css",
            app_url + "/theme/sysu/css/animate.css",
            app_url + "/theme/sysu/css/magnific-popup.css",
            app_url + "/theme/sysu/include/cookie-alert/cookiealert.css",
            app_url + "/theme/sysu/include/slick/slick.css",
            app_url + "/theme/sysu/include/slick/slick-theme.css",
            app_url + "/theme/sysu/css/responsive.css",
            app_url + "/theme/sysu/css/custom.css",
        ],
        scripts: [
            app_url + "/theme/sysu/js/jquery.js",
            app_url + "/theme/sysu/js/plugins.js",
            app_url + "/theme/sysu/include/slick/slick.js",
            app_url + "/theme/sysu/include/cookie-alert/cookiealert.js",
            app_url + "/theme/sysu/js/functions.js",
        ],
    },

    layerManager: {
        appendTo: ".layers-container",
    },

    deviceManager: {
        devices: [
            {
                name: "Desktop",
                width: "",
            },
            {
                name: "Tablet",
                width: "768px",
                widthMedia: "992px",
            },
            {
                name: "Mobile",
                width: "320px",
                widthMedia: "480px",
            },
        ],
    },

    selectorManager: {
        appendTo: "#selector-mgr",
        componentFirst: true,
    },

    blockManager: {
        appendTo: ".blocks-mgr",
    },

    styleManager: {
        appendTo: "#styles-or-traits-mgr #styles-mgr",
        sectors: [
            {
                name: "General",
                open: false,
                buildProps: [
                    "float",
                    "display",
                    "position",
                    "top",
                    "right",
                    "left",
                    "bottom",
                ],
            },
            {
                name: "Dimension",
                open: false,
                buildProps: [
                    "visibility",
                    "width",
                    "height",
                    "max-width",
                    "min-height",
                    "margin",
                    "padding",
                ],
                properties: [
                    {
                        name: "Visibility",
                        property: "visibility",
                        type: "radio",
                        defaults: "visible",
                        list: [{ value: "visible" }, { value: "hidden" }],
                    },
                ],
            },
            {
                name: "Typography",
                open: false,
                buildProps: [
                    "font-family",
                    "font-size",
                    "font-weight",
                    "letter-spacing",
                    "color",
                    "line-height",
                    "text-transform",
                    "font-style",
                    "text-align",
                    "text-shadow",
                ],
                properties: [
                    {
                        name: "Text Transform",
                        property: "text-transform",
                        type: "select",
                        defaults: "none",
                        list: [
                            { value: "none" },
                            { value: "capitalize" },
                            { value: "uppercase" },
                            { value: "lowercase" },
                        ],
                    },
                    {
                        name: "Text Transform",
                        property: "text-transform",
                        type: "select",
                        defaults: "none",
                        list: [
                            { value: "none" },
                            { value: "capitalize" },
                            { value: "uppercase" },
                            { value: "lowercase" },
                        ],
                    },
                ],
            },
            {
                name: "Decorations",
                open: false,
                buildProps: [
                    "border-radius-c",
                    "border-radius",
                    "border",
                    "box-shadow",
                    "background-bg",
                    "background-color",
                ],
                properties: [
                    {
                        id: "background-bg",
                        property: "background",
                        type: "bg",
                    },
                ],
            },
            {
                name: "Extra",
                open: false,
                buildProps: [
                    "opacity",
                    "transition",
                    "perspective",
                    "transform",
                ],
                properties: [
                    {
                        type: "slider",
                        property: "opacity",
                        defaults: 1,
                        step: 0.01,
                        max: 1,
                        min: 0,
                    },
                ],
            },
        ],
    },

    traitManager: {
        appendTo: document.querySelector("#styles-or-traits-mgr #traits-mgr"),
    },

    panels: {
        defaults: [
            {
                id: "options",
                buttons: [
                    {
                        active: true,
                        id: "sw-visibility",
                        className: "swv",
                        command: "sw-visibility",
                        context: "sw-visibility",
                    },
                ],
            },
        ],
    },
    colorPicker: { appendTo: "parent", offset: { top: 30, left: -174 } },
});

editor.StorageManager.add("simpleStorage", {
    store(data, clb, clbErr) {
		$("#json").val(JSON.stringify(data));
    },
});

editor.Commands.add("set-device-desktop", {
	run: (editor) => editor.setDevice("Desktop"),
});
editor.Commands.add("set-device-tablet", {
	run: (editor) => editor.setDevice("Tablet"),
});
editor.Commands.add("set-device-mobile", {
	run: (editor) => editor.setDevice("Mobile"),
});

window.addEventListener("load", () => {
	setTimeout(function() {
		const categories = editor.BlockManager.getCategories();
        categories.each((category) => {
            category.set("open", false).on("change:open", (opened) => {
                opened.get("open") &&
                    categories.each((category) => {
                        category !== opened && category.set("open", false);
                    });
            });
        });
	}, 1500);

	if(jsComponents != "" && jsComponents != "[]") {
		editor.addComponents(JSON.parse(jsComponents));
        editor.setStyle(JSON.parse(jsStyles));
	}

	$("#desktop-view").on("click", (event) => {
		editor.Commands.run("set-device-desktop");
	});

	$("#tablet-view").on("click", (event) => {
		editor.Commands.run("set-device-tablet");
	});

	$("#mobile-view").on("click", (event) => {
		editor.Commands.run("set-device-mobile");
	});

	$("#editor-undo").on("click", (event) => {
		editor.Commands.run("core:undo");
	});
	$("#editor-redo").on("click", (event) => {
		editor.Commands.run("core:redo");
	});

	$("#layers-view-btn").on("click", (event) => {
		if ($("#layers-view-btn").hasClass("layers-open")) {
			$("#layers-view-btn").removeClass("layers-open");
			$("#layers").css("margin-left", "-275px");
			$("#layers-view-btn").attr("data-original-title", "Show Layers");
		} else {
			$("#layers-view-btn").addClass("layers-open");
			$("#layers").css("margin-left", "0px");
			$("#layers-view-btn").attr("data-original-title", "Hide Layers");
		}
		setTimeout(function () {
            editor.refresh();
        }, 1000);
	});

	$("#styles-view-btn").on("click", (event) => {
		if ($("#styles-view-btn").hasClass("styles-open")) {
			$("#styles-view-btn").removeClass("styles-open");
			$("#styles-or-traits-mgr").css("margin-right", "-280px");
			$("#styles-view-btn").attr(
				"data-original-title",
				"Show Styles & Properties"
			);
		} else {
			$("#styles-view-btn").addClass("styles-open");
			$("#styles-or-traits-mgr").css("margin-right", "0px");
			$("#styles-view-btn").attr(
				"data-original-title",
				"Hide Styles & Properties"
			);
		}
    setTimeout(function() {
      editor.refresh();
    }, 1000);
	});

	$("#add-blocks-btn").on("click", (event) => {
    blockSelect();
		if ($(".panel-blocks").hasClass("panel-blocks-open")) {
			$(".panel-blocks").removeClass("panel-blocks-open");
		} else {
			$(".panel-blocks").addClass("panel-blocks-open");
		}
		setTimeout(function () {
            editor.refresh();
            $(".gjs-block").attr("ondrag", "dragging(event)");
            $(".gjs-built-in-block").css("width", "95%");
        }, 500);
	});

	$("#sw-visibility").on("click", (event) => {
		let status = editor.Commands.isActive("sw-visibility");

		if (status) {
			editor.Commands.stop("sw-visibility");
		} else {
			editor.Commands.run("sw-visibility");
		}
	});

	$("#editor-preview").on("click", (event) => {
		let status = editor.Commands.isActive("core:preview");

		if (status) {
			editor.Commands.stop("core:preview");
		} else {
			editor.Commands.run("core:preview");
		}
	});

	$("#editor-add").on("click", (event) => {
		$("#sidebar-inner-2")[0].classList.add("visible");
	});
	$("#editor-close-bm").on("click", (event) => {
		$("#sidebar-inner-2")[0].classList.remove("visible");
	});

	$("#editor-styles").on("click", (event) => {
		$("#sidebar-inner-3")[0].classList.add("visible");
	});
	$("#editor-close-stmgr").on("click", (event) => {
		$("#sidebar-inner-3")[0].classList.remove("visible");
	});

	$("#editor-fullscreen").on("click", (event) => {
		let element = document.querySelector("#editor-area");

		if (document.fullscreenElement) {
			if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.cancelFullScreen) {
				document.cancelFullScreen();
			} else if (document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			}
		} else {
			if (element.requestFullscreen) {
				element.requestFullscreen();
			} else if (element.webkitRequestFullScreen) {
				element.webkitRequestFullScreen();
			} else if (element.mozRequestFullScreen) {
				element.mozRequestFullScreen();
			} else if (element.requestFullscreen) {
				element.requestFullscreen();
			}
		}
	});

	$("#canvas-clear").on("click", (event) => {
		var cc = confirm("Are you sure you want to clear the canvas?");
		if (cc == true) {
			editor.Commands.run("core:canvas-clear");
			$("#contents").val(editor.getHtml().replace(/(bounce|fadeIn)\sanimated/g, ""));
			$("#styles").val(editor.getCss());
		}
	});

	$("#gjs-export-zip").on("click", (event) => {
		editor.Commands.run("gjs-export-zip");
	});

	$("#editor-export").on("shown.bs.modal", () => {
		$("#html-export-tab").tab("show");
		$("#html-export").tab("show");
	});

	$("#editor-export").on("hidden.bs.modal", () => {
		$("#html-export-tab")[0].classList.remove("active");
		document.querySelector("#editor-export #html-export").innerHTML = "";
		document.querySelector("#editor-export #css-export").innerHTML = "";
	});

	$("#html-export-tab").on("shown.bs.tab", () => {
		document.querySelector("#editor-export #html-export").innerHTML = "";

		let txtarea_html = document.createElement("textarea");
		document
			.querySelector("#editor-export #html-export")
			.appendChild(txtarea_html);
		txtarea_html.value = editor.getHtml();

		var codeViewer_html = editor.CodeManager.getViewer("CodeMirror")
			.clone()
			.set({
				...CodeMirror_config.export,

				codeName: "htmlmixed",
				input: txtarea_html,
			});

		codeViewer_html.init(txtarea_html);
		codeViewer_html.setContent(editor.getHtml());
		codeViewer_html.editor.refresh();
	});

	$("#css-export-tab").on("shown.bs.tab", () => {
		document.querySelector("#editor-export #css-export").innerHTML = "";
		let txtarea_css = document.createElement("textarea");
		document
			.querySelector("#editor-export #css-export")
			.appendChild(txtarea_css);

		var codeViewer_css = editor.CodeManager.getViewer("CodeMirror")
			.clone()
			.set({
				...CodeMirror_config.export,

				codeName: "css",
				input: txtarea_css,
			});

		codeViewer_css.init(txtarea_css);
		codeViewer_css.setContent(editor.getCss());
		codeViewer_css.editor.refresh();
	});

	$("#editor-import").on("shown.bs.modal", () => {
		document.querySelector("#editor-import .modal-body div").innerHTML = "";
		let txtarea_html = document.createElement("textarea");
		document
			.querySelector("#editor-import .modal-body div")
			.appendChild(txtarea_html);
		var codeViewer_html = editor.CodeManager.getViewer("CodeMirror")
			.clone()
			.set({
				...CodeMirror_config.import,

				codeName: "htmlmixed",
				input: txtarea_html,
			});

		codeViewer_html.init(txtarea_html);
		codeViewer_html.setContent("");
		codeViewer_html.editor.refresh();

		$("#import-component")[0].onclick = (e) => {
			editor.addComponents(codeViewer_html.editor.getValue().trim());
			$("#editor-import").modal("hide");
			document.querySelector("#editor-import .modal-body div").innerHTML = "";
		};
	});

	setTimeout(function () {
		$(".gjs-block").attr("ondrag", "dragging(event)");
    	$(".gjs-built-in-block").css("width", "95%");
	}, 1000);
});

editor.on("component:selected", (component) => {
	// editor.addComponents(JSON.parse(jsPage)["gjs-components"][0]);

	const commandToAdd = (e) => {
    $("#styles-view-btn").addClass("styles-open");
		$("#styles-or-traits-mgr").css("margin-right", "0px");
		$("#styles-view-btn").attr(
			"data-original-title",
			"Hide Styles & Properties"
		);
    editor.refresh();
  };
	const commandIcon = "fa fa-paint-brush";

	const selectedComponent = editor.getSelected();
	const defaultToolbar = selectedComponent.get("toolbar");



	if (selectedComponent.attributes.classes.models.id == "container") {
        selectedComponent.attributes.type = "Container";
		editor.refresh();
    }

	const commandExists = defaultToolbar.some(
		(item) => item.attributes.class === commandIcon
	);

	defaultToolbar.map((item) => {
		if(item.attributes.class == "fa fa-arrow-up") {
			item.attributes.title = "Select Parent";
		}else if(item.command == "tlb-move") {
			item.attributes.title = "Drag to Move";
		}else if(item.command == "tlb-clone") {
			item.attributes.title = "Clone";
		}else if(item.command == "tlb-delete") {
			item.attributes.title = "Delete";
		}else if(item.command == "table-insert-row-above") {
			item.attributes.title = "Insert Row Above";
		}
	})

	if (!commandExists) {
		selectedComponent.set({
			toolbar: [
				...defaultToolbar,
				{ attributes: { class: commandIcon, title: "Styles & Properties" }, command: commandToAdd },
			],
		});
	}

	if(component.attributes.type == "parallax") {
		const styleManager = editor.StyleManager;
		const sectors = document.querySelectorAll(".gjs-sm-sector");
		styleManager.addSector('parallax',{
			name: 'Background Image',
			open: false,
			buildProps: [
				"background-image",
			],
		});
		setTimeout(() => {
			for (i = 0; i < sectors.length; i++) {
				sectors[i].style.display = "none";
			}
			document.querySelector(".gjs-sm-sector__parallax").style.display = "block";
		}, 1000);
	}
});

editor.on('component:deselected', (component) => {
  if(component.attributes.type == "parallax") {
    const styleManager = editor.StyleManager;
    styleManager.removeSector('parallax');
  }
})

editor.on("component:remove", (e) => {
    $("#contents").val(editor.getHtml().replace(/(bounce|fadeIn)\sanimated/g, ""));
	$("#styles").val(editor.getCss());
});

editor.on("component:update", (e) => {
    $("#contents").val(editor.getHtml().replace(/(bounce|fadeIn)\sanimated/g, ""));
	$("#styles").val(editor.getCss());
});

editor.on("component:styleUpdate", () => {
	$("#contents").val(editor.getHtml().replace(/(bounce|fadeIn)\sanimated/g, ""));
    $("#styles").val(editor.getCss());
});

// editor.on("storage:start:load", function (e) {
// 	editor.setComponents(JSON.parse(jsPage)["gjs-components"]);
// 	editor.setStyle(JSON.parse(jsPage)["gjs-styles"]);
//     console.log("Loaded ", e);
// });
editor.on("storage:store", function (e) {
    console.log("Stored ", e);
});

editor.on("change:device", () => {
	document
		.querySelector(".device-type.bg-neutral-first")
		.classList.remove("bg-neutral-first");

	// console.log(editor.getDevice());

	switch (editor.getDevice()) {
		case "Tablet":
			document
				.querySelector(".device-type#tablet-view")
				.classList.add("bg-neutral-first");
			break;
		case "Mobile":
			document
				.querySelector(".device-type#mobile-view")
				.classList.add("bg-neutral-first");
			break;
		case "Desktop":
			document
				.querySelector(".device-type#desktop-view")
				.classList.add("bg-neutral-first");
			break;
		default:
	}
});

editor.on("run:sw-visibility", () => {
	document.querySelector("#sw-visibility").classList.add("active");
});
editor.on("stop:sw-visibility", () => {
	document.querySelector("#sw-visibility").classList.remove("active");
});

window.addEventListener("fullscreenchange", fullScreenChange);
window.addEventListener("mozfullscreenchange", fullScreenChange);
window.addEventListener("webkitfullscreenchange", fullScreenChange);
window.addEventListener("msfullscreenchange", fullScreenChange);

function fullScreenChange() {
	console.log("fullscreen");
	if (
		!(
			document.fullscreenElement ||
			document.webkitFullscreenElement ||
			document.mozFullScreenElement ||
			document.msFullscreenElement
		)
	) {
		document.querySelector("#editor-fullscreen").classList.remove("active");
		document.querySelector("#editor-area").classList.remove("fullscreen");
	} else {
		document.querySelector("#editor-fullscreen").classList.add("active");
		document.querySelector("#editor-area").classList.add("fullscreen");
	}
}

function dragging(event) {
	$(".panel-blocks").removeClass("panel-blocks-open");
}

var cmdm = editor.Commands;

//media assets
cmdm.add('open-assets', {
	run(editor, sender, opts = {}) {
		var type = "image";
		var route_prefix =
            app_url + "/laravel-filemanager";;
		var target = $("#" + opts.target.ccid);
		window.open(
			route_prefix + "?type=" + type,
			"FileManager",
			"width=900,height=600"
		);
		window.SetUrl = function (url) {
			var img = new Image();
			img.onload = function () {
				opts.target.set('src', url);
				const fakeAsset = { get: () => url };
				opts.onSelect(fakeAsset);
			};
			img.src = url;
		};
		return false;
	}
});

var builtInBlocks = ["featured", "welcome", "about", "services", "testimonials"];

for(let block in builtInBlocks) {
	fetch(app_url + "/lib/custom-grapesjs/assets/js/json/" + builtInBlocks[block] + ".json", {
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((json) => {
            for (let key in json) {
                editor.BlockManager.add(json[key].name, {
                    label:
                        "<img class='w-100 mb-2 pointer-events-none' src='" +
                        app_url +
                        "/lib/custom-grapesjs/assets/js/img/" +
                        json[key].image +
                        "' />" +
                        json[key].label,
                    content: json[key].content,
                    category: {
						label: json[key].category,
						order: block,
					},
                    attributes: json[key].attributes,
                });
            }
        });
}

function blockSelect() {
  $this = $("#block-select");
  if ($this.val() == 1) {
    $(".gjs-block-category").show();
    $(".gjs-built-in-block").parent().parent().hide();
  } else {
    $(".gjs-block-category").hide();
    $(".gjs-built-in-block").parent().parent().show();
  }
};

$(document).ready(function (event) {
	$("#block-select").change(function () {
		blockSelect();
	});

	$('[data-toggle="tooltip"]').tooltip({
        trigger: "hover",
    });
});
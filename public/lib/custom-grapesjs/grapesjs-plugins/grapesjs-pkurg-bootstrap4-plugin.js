function PB4(editor){



//Bacic Blocks

// editor.BlockManager.add('b4-block-box', {
//   label: 'Box',
//   content: `<div class="box" ></div>
//   <style> div.box {min-height: 40px;}</style>`,
//   category: 'Layout',
//   attributes: { class: 'fa fa-square-o' },
// });

editor.BlockManager.add("divider", {
    label: "Divider",
    content: `<div data-gjs-type="divider" class="gpd-divider gjs-selected"></div>
    <style>
    .gpd-divider {
        height: 3px;
        margin: 10px 0px 10px 0px;
        background-color: rgba(0,0,0,0.05);
    }
    </style>
    `,
    category: "Basic",
    attributes: { class: "fa fa-minus-square-o" },
});

editor.DomComponents.addType('divider', {
  isComponent: el => el.tagName === 'DIV',
  model: {  },
  view: {  }, // Will extend the view from 'other-defined-component'
});

editor.BlockManager.add("icon", {
    label: "Icon",
    content: `<i data-gjs-type="icon" class="icon-line-help icon-2x"></i>`,
    category: "Basic",
    attributes: { class: "fa fa-diamond" },
});

editor.DomComponents.addType("icon", {
    isComponent: (el) => el.tagName === "I",
    model: {}, // Will extend the model from 'other-defined-component'
    view: {
        events: {
            dblclick: function () {
                const modal = editor.Modal;
			          modal.open({
                          title: "Select Icon",
                          content: `
                            <div class="position-relative clearfix">

                              <div class="input-group w-100 mg-b-15">
                                <span class="input-group-text search-btn">
                                  <i class="icon-line-search"></i>
                                </span>
                                <input type="text" id="icons-filter" class="form-control" value="" placeholder="Search Icons">
                              </div>

                              <ul class="icons-list topmargin clearfix">
                                <li><i class="icon-line-open"></i><span>icon-line-open</span></li>
                                <li><i class="icon-line-help"></i><span>icon-line-help</span></li>
                                <li><i class="icon-line-bag"></i><span>icon-line-bag</span></li>
                                <li><i class="icon-line-grid-2"></i><span>icon-line-grid-2</span></li>
                                <li><i class="icon-line-content-left"></i><span>icon-line-content-left</span></li>
                                <li><i class="icon-line-content-right"></i><span>icon-line-content-right</span></li>
                                <li><i class="icon-line-esc"></i><span>icon-line-esc</span></li>
                                <li><i class="icon-line-alt"></i><span>icon-line-alt</span></li>
                                <li><i class="icon-line-marquee-plus"></i><span>icon-line-marquee-plus</span></li>
                                <li><i class="icon-line-marquee-minus"></i><span>icon-line-marquee-minus</span></li>
                                <li><i class="icon-line-marquee"></i><span>icon-line-marquee</span></li>
                                <li><i class="icon-line-reload"></i><span>icon-line-reload</span></li>
                                <li><i class="icon-line-square-check"></i><span>icon-line-square-check</span></li>
                                <li><i class="icon-line-paragraph"></i><span>icon-line-paragraph</span></li>
                                <li><i class="icon-line-ribbon"></i><span>icon-line-ribbon</span></li>
                                <li><i class="icon-line-location-2"></i><span>icon-line-location-2</span></li>
                                <li><i class="icon-line-circle-check"></i><span>icon-line-circle-check</span></li>
                                <li><i class="icon-line-circle-cross1"></i><span>icon-line-circle-cross1</span></li>
                                <li><i class="icon-line-reply"></i><span>icon-line-reply</span></li>
                                <li><i class="icon-line-paper-stack"></i><span>icon-line-paper-stack</span></li>
                                <li><i class="icon-line-stack-2"></i><span>icon-line-stack-2</span></li>
                                <li><i class="icon-line-stack"></i><span>icon-line-stack</span></li>
                                <li><i class="icon-line-activity"></i><span>icon-line-activity</span></li>
                                <li><i class="icon-line-air-play"></i><span>icon-line-air-play</span></li>
                                <li><i class="icon-line-alert-circle"></i><span>icon-line-alert-circle</span></li>
                                <li><i class="icon-line-alert-octagon"></i><span>icon-line-alert-octagon</span></li>
                                <li><i class="icon-line-alert-triangle"></i><span>icon-line-alert-triangle</span></li>
                                <li><i class="icon-line-align-center"></i><span>icon-line-align-center</span></li>
                                <li><i class="icon-line-align-justify"></i><span>icon-line-align-justify</span></li>
                                <li><i class="icon-line-align-left"></i><span>icon-line-align-left</span></li>
                                <li><i class="icon-line-align-right"></i><span>icon-line-align-right</span></li>
                                <li><i class="icon-line-anchor"></i><span>icon-line-anchor</span></li>
                                <li><i class="icon-line-aperture"></i><span>icon-line-aperture</span></li>
                                <li><i class="icon-line-archive"></i><span>icon-line-archive</span></li>
                                <li><i class="icon-line-arrow-down"></i><span>icon-line-arrow-down</span></li>
                                <li><i class="icon-line-arrow-down-circle"></i><span>icon-line-arrow-down-circle</span></li>
                                <li><i class="icon-line-arrow-down-left"></i><span>icon-line-arrow-down-left</span></li>
                                <li><i class="icon-line-arrow-down-right"></i><span>icon-line-arrow-down-right</span></li>
                                <li><i class="icon-line-arrow-left"></i><span>icon-line-arrow-left</span></li>
                                <li><i class="icon-line-arrow-left-circle"></i><span>icon-line-arrow-left-circle</span></li>
                                <li><i class="icon-line-arrow-right"></i><span>icon-line-arrow-right</span></li>
                                <li><i class="icon-line-arrow-right-circle"></i><span>icon-line-arrow-right-circle</span></li>
                                <li><i class="icon-line-arrow-up"></i><span>icon-line-arrow-up</span></li>
                                <li><i class="icon-line-arrow-up-circle"></i><span>icon-line-arrow-up-circle</span></li>
                                <li><i class="icon-line-arrow-up-left"></i><span>icon-line-arrow-up-left</span></li>
                                <li><i class="icon-line-arrow-up-right"></i><span>icon-line-arrow-up-right</span></li>
                                <li><i class="icon-line-at-sign"></i><span>icon-line-at-sign</span></li>
                                <li><i class="icon-line-award"></i><span>icon-line-award</span></li>
                                <li><i class="icon-line-bar-graph"></i><span>icon-line-bar-graph</span></li>
                                <li><i class="icon-line-bar-graph-2"></i><span>icon-line-bar-graph-2</span></li>
                                <li><i class="icon-line-battery"></i><span>icon-line-battery</span></li>
                                <li><i class="icon-line-battery-charging"></i><span>icon-line-battery-charging</span></li>
                                <li><i class="icon-line-bell"></i><span>icon-line-bell</span></li>
                                <li><i class="icon-line-bell-off"></i><span>icon-line-bell-off</span></li>
                                <li><i class="icon-line-bluetooth"></i><span>icon-line-bluetooth</span></li>
                                <li><i class="icon-line-bold"></i><span>icon-line-bold</span></li>
                                <li><i class="icon-line-book"></i><span>icon-line-book</span></li>
                                <li><i class="icon-line-book-open"></i><span>icon-line-book-open</span></li>
                                <li><i class="icon-line-bookmark"></i><span>icon-line-bookmark</span></li>
                                <li><i class="icon-line-box"></i><span>icon-line-box</span></li>
                                <li><i class="icon-line-briefcase"></i><span>icon-line-briefcase</span></li>
                                <li><i class="icon-line-calendar"></i><span>icon-line-calendar</span></li>
                                <li><i class="icon-line-camera"></i><span>icon-line-camera</span></li>
                                <li><i class="icon-line-camera-off"></i><span>icon-line-camera-off</span></li>
                                <li><i class="icon-line-cast"></i><span>icon-line-cast</span></li>
                                <li><i class="icon-line-check"></i><span>icon-line-check</span></li>
                                <li><i class="icon-line-check-circle"></i><span>icon-line-check-circle</span></li>
                                <li><i class="icon-line-check-square"></i><span>icon-line-check-square</span></li>
                                <li><i class="icon-line-chevron-down"></i><span>icon-line-chevron-down</span></li>
                                <li><i class="icon-line-chevron-left"></i><span>icon-line-chevron-left</span></li>
                                <li><i class="icon-line-chevron-right"></i><span>icon-line-chevron-right</span></li>
                                <li><i class="icon-line-chevron-up"></i><span>icon-line-chevron-up</span></li>
                                <li><i class="icon-line-chevrons-down"></i><span>icon-line-chevrons-down</span></li>
                                <li><i class="icon-line-chevrons-left"></i><span>icon-line-chevrons-left</span></li>
                                <li><i class="icon-line-chevrons-right"></i><span>icon-line-chevrons-right</span></li>
                                <li><i class="icon-line-chevrons-up"></i><span>icon-line-chevrons-up</span></li>
                                <li><i class="icon-line-chrome"></i><span>icon-line-chrome</span></li>
                                <li><i class="icon-line-stop"></i><span>icon-line-stop</span></li>
                                <li><i class="icon-line-record"></i><span>icon-line-record</span></li>
                                <li><i class="icon-line-clipboard"></i><span>icon-line-clipboard</span></li>
                                <li><i class="icon-line-clock"></i><span>icon-line-clock</span></li>
                                <li><i class="icon-line-cloud"></i><span>icon-line-cloud</span></li>
                                <li><i class="icon-line-cloud-drizzle"></i><span>icon-line-cloud-drizzle</span></li>
                                <li><i class="icon-line-cloud-lightning"></i><span>icon-line-cloud-lightning</span></li>
                                <li><i class="icon-line-cloud-off"></i><span>icon-line-cloud-off</span></li>
                                <li><i class="icon-line-cloud-rain"></i><span>icon-line-cloud-rain</span></li>
                                <li><i class="icon-line-cloud-snow"></i><span>icon-line-cloud-snow</span></li>
                                <li><i class="icon-line-code"></i><span>icon-line-code</span></li>
                                <li><i class="icon-line-codepen"></i><span>icon-line-codepen</span></li>
                                <li><i class="icon-line-codesandbox"></i><span>icon-line-codesandbox</span></li>
                                <li><i class="icon-line-coffee"></i><span>icon-line-coffee</span></li>
                                <li><i class="icon-line-columns"></i><span>icon-line-columns</span></li>
                                <li><i class="icon-line-command"></i><span>icon-line-command</span></li>
                                <li><i class="icon-line-compass"></i><span>icon-line-compass</span></li>
                                <li><i class="icon-line-copy"></i><span>icon-line-copy</span></li>
                                <li><i class="icon-line-corner-down-left"></i><span>icon-line-corner-down-left</span></li>
                                <li><i class="icon-line-corner-down-right"></i><span>icon-line-corner-down-right</span></li>
                                <li><i class="icon-line-corner-left-down"></i><span>icon-line-corner-left-down</span></li>
                                <li><i class="icon-line-corner-left-up"></i><span>icon-line-corner-left-up</span></li>
                                <li><i class="icon-line-corner-right-down"></i><span>icon-line-corner-right-down</span></li>
                                <li><i class="icon-line-corner-right-up"></i><span>icon-line-corner-right-up</span></li>
                                <li><i class="icon-line-corner-up-left"></i><span>icon-line-corner-up-left</span></li>
                                <li><i class="icon-line-corner-up-right"></i><span>icon-line-corner-up-right</span></li>
                                <li><i class="icon-line-cpu"></i><span>icon-line-cpu</span></li>
                                <li><i class="icon-line-credit-card"></i><span>icon-line-credit-card</span></li>
                                <li><i class="icon-line-crop"></i><span>icon-line-crop</span></li>
                                <li><i class="icon-line-crosshair"></i><span>icon-line-crosshair</span></li>
                                <li><i class="icon-line-database"></i><span>icon-line-database</span></li>
                                <li><i class="icon-line-delete"></i><span>icon-line-delete</span></li>
                                <li><i class="icon-line-disc"></i><span>icon-line-disc</span></li>
                                <li><i class="icon-line-dollar-sign"></i><span>icon-line-dollar-sign</span></li>
                                <li><i class="icon-line-download"></i><span>icon-line-download</span></li>
                                <li><i class="icon-line-cloud-download"></i><span>icon-line-cloud-download</span></li>
                                <li><i class="icon-line-droplet"></i><span>icon-line-droplet</span></li>
                                <li><i class="icon-line-edit"></i><span>icon-line-edit</span></li>
                                <li><i class="icon-line-edit-2"></i><span>icon-line-edit-2</span></li>
                                <li><i class="icon-line-edit-3"></i><span>icon-line-edit-3</span></li>
                                <li><i class="icon-line-external-link"></i><span>icon-line-external-link</span></li>
                                <li><i class="icon-line-eye"></i><span>icon-line-eye</span></li>
                                <li><i class="icon-line-eye-off"></i><span>icon-line-eye-off</span></li>
                                <li><i class="icon-line-facebook"></i><span>icon-line-facebook</span></li>
                                <li><i class="icon-line-fast-forward"></i><span>icon-line-fast-forward</span></li>
                                <li><i class="icon-line-feather"></i><span>icon-line-feather</span></li>
                                <li><i class="icon-line-figma"></i><span>icon-line-figma</span></li>
                                <li><i class="icon-line-file"></i><span>icon-line-file</span></li>
                                <li><i class="icon-line-file-subtract"></i><span>icon-line-file-subtract</span></li>
                                <li><i class="icon-line-file-add"></i><span>icon-line-file-add</span></li>
                                <li><i class="icon-line-paper"></i><span>icon-line-paper</span></li>
                                <li><i class="icon-line-film"></i><span>icon-line-film</span></li>
                                <li><i class="icon-line-filter"></i><span>icon-line-filter</span></li>
                                <li><i class="icon-line-flag"></i><span>icon-line-flag</span></li>
                                <li><i class="icon-line-folder"></i><span>icon-line-folder</span></li>
                                <li><i class="icon-line-folder-minus"></i><span>icon-line-folder-minus</span></li>
                                <li><i class="icon-line-folder-plus"></i><span>icon-line-folder-plus</span></li>
                                <li><i class="icon-line-framer"></i><span>icon-line-framer</span></li>
                                <li><i class="icon-line-frown"></i><span>icon-line-frown</span></li>
                                <li><i class="icon-line-gift"></i><span>icon-line-gift</span></li>
                                <li><i class="icon-line-git-branch"></i><span>icon-line-git-branch</span></li>
                                <li><i class="icon-line-git-commit"></i><span>icon-line-git-commit</span></li>
                                <li><i class="icon-line-git-merge"></i><span>icon-line-git-merge</span></li>
                                <li><i class="icon-line-git-pull-request"></i><span>icon-line-git-pull-request</span></li>
                                <li><i class="icon-line-github"></i><span>icon-line-github</span></li>
                                <li><i class="icon-line-gitlab"></i><span>icon-line-gitlab</span></li>
                                <li><i class="icon-line-globe"></i><span>icon-line-globe</span></li>
                                <li><i class="icon-line-grid"></i><span>icon-line-grid</span></li>
                                <li><i class="icon-line-hard-drive"></i><span>icon-line-hard-drive</span></li>
                                <li><i class="icon-line-hash"></i><span>icon-line-hash</span></li>
                                <li><i class="icon-line-headphones"></i><span>icon-line-headphones</span></li>
                                <li><i class="icon-line-heart"></i><span>icon-line-heart</span></li>
                                <li><i class="icon-line-help-circle"></i><span>icon-line-help-circle</span></li>
                                <li><i class="icon-line-hexagon"></i><span>icon-line-hexagon</span></li>
                                <li><i class="icon-line-home"></i><span>icon-line-home</span></li>
                                <li><i class="icon-line-image"></i><span>icon-line-image</span></li>
                                <li><i class="icon-line-inbox"></i><span>icon-line-inbox</span></li>
                                <li><i class="icon-line-info"></i><span>icon-line-info</span></li>
                                <li><i class="icon-line-instagram"></i><span>icon-line-instagram</span></li>
                                <li><i class="icon-line-italic"></i><span>icon-line-italic</span></li>
                                <li><i class="icon-line-key"></i><span>icon-line-key</span></li>
                                <li><i class="icon-line-layers"></i><span>icon-line-layers</span></li>
                                <li><i class="icon-line-layout"></i><span>icon-line-layout</span></li>
                                <li><i class="icon-line-link"></i><span>icon-line-link</span></li>
                                <li><i class="icon-line-link-2"></i><span>icon-line-link-2</span></li>
                                <li><i class="icon-line-linkedin"></i><span>icon-line-linkedin</span></li>
                                <li><i class="icon-line-list"></i><span>icon-line-list</span></li>
                                <li><i class="icon-line-loader"></i><span>icon-line-loader</span></li>
                                <li><i class="icon-line-lock"></i><span>icon-line-lock</span></li>
                                <li><i class="icon-line-log-in"></i><span>icon-line-log-in</span></li>
                                <li><i class="icon-line-log-out"></i><span>icon-line-log-out</span></li>
                                <li><i class="icon-line-mail"></i><span>icon-line-mail</span></li>
                                <li><i class="icon-line-map"></i><span>icon-line-map</span></li>
                                <li><i class="icon-line-map-pin"></i><span>icon-line-map-pin</span></li>
                                <li><i class="icon-line-expand"></i><span>icon-line-expand</span></li>
                                <li><i class="icon-line-maximize"></i><span>icon-line-maximize</span></li>
                                <li><i class="icon-line-meh"></i><span>icon-line-meh</span></li>
                                <li><i class="icon-line-menu"></i><span>icon-line-menu</span></li>
                                <li><i class="icon-line-message-circle"></i><span>icon-line-message-circle</span></li>
                                <li><i class="icon-line-speech-bubble"></i><span>icon-line-speech-bubble</span></li>
                                <li><i class="icon-line-microphone"></i><span>icon-line-microphone</span></li>
                                <li><i class="icon-line-microphone-off"></i><span>icon-line-microphone-off</span></li>
                                <li><i class="icon-line-contract"></i><span>icon-line-contract</span></li>
                                <li><i class="icon-line-minimize"></i><span>icon-line-minimize</span></li>
                                <li><i class="icon-line-minus"></i><span>icon-line-minus</span></li>
                                <li><i class="icon-line-circle-minus"></i><span>icon-line-circle-minus</span></li>
                                <li><i class="icon-line-square-minus"></i><span>icon-line-square-minus</span></li>
                                <li><i class="icon-line-monitor"></i><span>icon-line-monitor</span></li>
                                <li><i class="icon-line-moon"></i><span>icon-line-moon</span></li>
                                <li><i class="icon-line-more-horizontal"></i><span>icon-line-more-horizontal</span></li>
                                <li><i class="icon-line-ellipsis"></i><span>icon-line-ellipsis</span></li>
                                <li><i class="icon-line-more-vertical"></i><span>icon-line-more-vertical</span></li>
                                <li><i class="icon-line-mouse-pointer"></i><span>icon-line-mouse-pointer</span></li>
                                <li><i class="icon-line-move"></i><span>icon-line-move</span></li>
                                <li><i class="icon-line-music"></i><span>icon-line-music</span></li>
                                <li><i class="icon-line-location"></i><span>icon-line-location</span></li>
                                <li><i class="icon-line-navigation"></i><span>icon-line-navigation</span></li>
                                <li><i class="icon-line-octagon"></i><span>icon-line-octagon</span></li>
                                <li><i class="icon-line-package"></i><span>icon-line-package</span></li>
                                <li><i class="icon-line-paper-clip"></i><span>icon-line-paper-clip</span></li>
                                <li><i class="icon-line-pause"></i><span>icon-line-pause</span></li>
                                <li><i class="icon-line-pause-circle"></i><span>icon-line-pause-circle</span></li>
                                <li><i class="icon-line-pen-tool"></i><span>icon-line-pen-tool</span></li>
                                <li><i class="icon-line-percent"></i><span>icon-line-percent</span></li>
                                <li><i class="icon-line-phone"></i><span>icon-line-phone</span></li>
                                <li><i class="icon-line-phone-call"></i><span>icon-line-phone-call</span></li>
                                <li><i class="icon-line-phone-forwarded"></i><span>icon-line-phone-forwarded</span></li>
                                <li><i class="icon-line-phone-incoming"></i><span>icon-line-phone-incoming</span></li>
                                <li><i class="icon-line-phone-missed"></i><span>icon-line-phone-missed</span></li>
                                <li><i class="icon-line-phone-off"></i><span>icon-line-phone-off</span></li>
                                <li><i class="icon-line-phone-outgoing"></i><span>icon-line-phone-outgoing</span></li>
                                <li><i class="icon-line-pie-graph"></i><span>icon-line-pie-graph</span></li>
                                <li><i class="icon-line-play"></i><span>icon-line-play</span></li>
                                <li><i class="icon-line-play-circle"></i><span>icon-line-play-circle</span></li>
                                <li><i class="icon-line-plus"></i><span>icon-line-plus</span></li>
                                <li><i class="icon-line-circle-plus"></i><span>icon-line-circle-plus</span></li>
                                <li><i class="icon-line-square-plus"></i><span>icon-line-square-plus</span></li>
                                <li><i class="icon-line-pocket"></i><span>icon-line-pocket</span></li>
                                <li><i class="icon-line-power"></i><span>icon-line-power</span></li>
                                <li><i class="icon-line-printer"></i><span>icon-line-printer</span></li>
                                <li><i class="icon-line-signal"></i><span>icon-line-signal</span></li>
                                <li><i class="icon-line-refresh-cw"></i><span>icon-line-refresh-cw</span></li>
                                <li><i class="icon-line-repeat"></i><span>icon-line-repeat</span></li>
                                <li><i class="icon-line-rewind"></i><span>icon-line-rewind</span></li>
                                <li><i class="icon-line-rotate-cw"></i><span>icon-line-rotate-cw</span></li>
                                <li><i class="icon-line-rss"></i><span>icon-line-rss</span></li>
                                <li><i class="icon-line-save"></i><span>icon-line-save</span></li>
                                <li><i class="icon-line-scissors"></i><span>icon-line-scissors</span></li>
                                <li><i class="icon-line-search"></i><span>icon-line-search</span></li>
                                <li><i class="icon-line-send"></i><span>icon-line-send</span></li>
                                <li><i class="icon-line-server"></i><span>icon-line-server</span></li>
                                <li><i class="icon-line-cog"></i><span>icon-line-cog</span></li>
                                <li><i class="icon-line-outbox"></i><span>icon-line-outbox</span></li>
                                <li><i class="icon-line-share"></i><span>icon-line-share</span></li>
                                <li><i class="icon-line-shield"></i><span>icon-line-shield</span></li>
                                <li><i class="icon-line-shield-off"></i><span>icon-line-shield-off</span></li>
                                <li><i class="icon-line-shopping-bag"></i><span>icon-line-shopping-bag</span></li>
                                <li><i class="icon-line-shopping-cart"></i><span>icon-line-shopping-cart</span></li>
                                <li><i class="icon-line-shuffle"></i><span>icon-line-shuffle</span></li>
                                <li><i class="icon-line-sidebar"></i><span>icon-line-sidebar</span></li>
                                <li><i class="icon-line-skip-back"></i><span>icon-line-skip-back</span></li>
                                <li><i class="icon-line-skip-forward"></i><span>icon-line-skip-forward</span></li>
                                <li><i class="icon-line-slack"></i><span>icon-line-slack</span></li>
                                <li><i class="icon-line-ban"></i><span>icon-line-ban</span></li>
                                <li><i class="icon-line-sliders"></i><span>icon-line-sliders</span></li>
                                <li><i class="icon-line-smartphone"></i><span>icon-line-smartphone</span></li>
                                <li><i class="icon-line-smile"></i><span>icon-line-smile</span></li>
                                <li><i class="icon-line-speaker"></i><span>icon-line-speaker</span></li>
                                <li><i class="icon-line-square"></i><span>icon-line-square</span></li>
                                <li><i class="icon-line-star"></i><span>icon-line-star</span></li>
                                <li><i class="icon-line-stop-circle"></i><span>icon-line-stop-circle</span></li>
                                <li><i class="icon-line-sun"></i><span>icon-line-sun</span></li>
                                <li><i class="icon-line-sunrise"></i><span>icon-line-sunrise</span></li>
                                <li><i class="icon-line-sunset"></i><span>icon-line-sunset</span></li>
                                <li><i class="icon-line-tablet"></i><span>icon-line-tablet</span></li>
                                <li><i class="icon-line-tag"></i><span>icon-line-tag</span></li>
                                <li><i class="icon-line-target"></i><span>icon-line-target</span></li>
                                <li><i class="icon-line-terminal"></i><span>icon-line-terminal</span></li>
                                <li><i class="icon-line-thermometer"></i><span>icon-line-thermometer</span></li>
                                <li><i class="icon-line-thumbs-down"></i><span>icon-line-thumbs-down</span></li>
                                <li><i class="icon-line-thumbs-up"></i><span>icon-line-thumbs-up</span></li>
                                <li><i class="icon-line-toggle"></i><span>icon-line-toggle</span></li>
                                <li><i class="icon-line-toggle-right"></i><span>icon-line-toggle-right</span></li>
                                <li><i class="icon-line-tool"></i><span>icon-line-tool</span></li>
                                <li><i class="icon-line-trash"></i><span>icon-line-trash</span></li>
                                <li><i class="icon-line-trash-2"></i><span>icon-line-trash-2</span></li>
                                <li><i class="icon-line-trello"></i><span>icon-line-trello</span></li>
                                <li><i class="icon-line-trending-down"></i><span>icon-line-trending-down</span></li>
                                <li><i class="icon-line-trending-up"></i><span>icon-line-trending-up</span></li>
                                <li><i class="icon-line-triangle"></i><span>icon-line-triangle</span></li>
                                <li><i class="icon-line-truck"></i><span>icon-line-truck</span></li>
                                <li><i class="icon-line-tv"></i><span>icon-line-tv</span></li>
                                <li><i class="icon-line-twitch"></i><span>icon-line-twitch</span></li>
                                <li><i class="icon-line-twitter"></i><span>icon-line-twitter</span></li>
                                <li><i class="icon-line-type"></i><span>icon-line-type</span></li>
                                <li><i class="icon-line-umbrella"></i><span>icon-line-umbrella</span></li>
                                <li><i class="icon-line-underline"></i><span>icon-line-underline</span></li>
                                <li><i class="icon-line-unlock"></i><span>icon-line-unlock</span></li>
                                <li><i class="icon-line-upload"></i><span>icon-line-upload</span></li>
                                <li><i class="icon-line-cloud-upload"></i><span>icon-line-cloud-upload</span></li>
                                <li><i class="icon-line-head"></i><span>icon-line-head</span></li>
                                <li><i class="icon-line-user-check"></i><span>icon-line-user-check</span></li>
                                <li><i class="icon-line-user-minus"></i><span>icon-line-user-minus</span></li>
                                <li><i class="icon-line-user-plus"></i><span>icon-line-user-plus</span></li>
                                <li><i class="icon-line-user-cross"></i><span>icon-line-user-cross</span></li>
                                <li><i class="icon-line-users"></i><span>icon-line-users</span></li>
                                <li><i class="icon-line-video"></i><span>icon-line-video</span></li>
                                <li><i class="icon-line-video-off"></i><span>icon-line-video-off</span></li>
                                <li><i class="icon-line-voicemail"></i><span>icon-line-voicemail</span></li>
                                <li><i class="icon-line-volume-off"></i><span>icon-line-volume-off</span></li>
                                <li><i class="icon-line-volume-1"></i><span>icon-line-volume-1</span></li>
                                <li><i class="icon-line-volume"></i><span>icon-line-volume</span></li>
                                <li><i class="icon-line-mute"></i><span>icon-line-mute</span></li>
                                <li><i class="icon-line-watch"></i><span>icon-line-watch</span></li>
                                <li><i class="icon-line-wifi"></i><span>icon-line-wifi</span></li>
                                <li><i class="icon-line-wifi-off"></i><span>icon-line-wifi-off</span></li>
                                <li><i class="icon-line-wind"></i><span>icon-line-wind</span></li>
                                <li><i class="icon-line-cross"></i><span>icon-line-cross</span></li>
                                <li><i class="icon-line-circle-cross"></i><span>icon-line-circle-cross</span></li>
                                <li><i class="icon-line-cross-octagon"></i><span>icon-line-cross-octagon</span></li>
                                <li><i class="icon-line-square-cross"></i><span>icon-line-square-cross</span></li>
                                <li><i class="icon-line-youtube"></i><span>icon-line-youtube</span></li>
                                <li><i class="icon-line-zap"></i><span>icon-line-zap</span></li>
                                <li><i class="icon-line-zap-off"></i><span>icon-line-zap-off</span></li>
                                <li><i class="icon-line-zoom-in"></i><span>icon-line-zoom-in</span></li>
                                <li><i class="icon-line-zoom-out"></i><span>icon-line-zoom-out</span></li>
                                <li><i class="icon-type"></i><span>icon-type</span></li>
                                <li><i class="icon-box1"></i><span>icon-box1</span></li>
                                <li><i class="icon-archive1"></i><span>icon-archive1</span></li>
                                <li><i class="icon-envelope2"></i><span>icon-envelope2</span></li>
                                <li><i class="icon-email"></i><span>icon-email</span></li>
                                <li><i class="icon-files"></i><span>icon-files</span></li>
                                <li><i class="icon-printer2"></i><span>icon-printer2</span></li>
                                <li><i class="icon-folder-add"></i><span>icon-folder-add</span></li>
                                <li><i class="icon-folder-settings"></i><span>icon-folder-settings</span></li>
                                <li><i class="icon-folder-check"></i><span>icon-folder-check</span></li>
                                <li><i class="icon-wifi-low"></i><span>icon-wifi-low</span></li>
                                <li><i class="icon-wifi-mid"></i><span>icon-wifi-mid</span></li>
                                <li><i class="icon-wifi-full"></i><span>icon-wifi-full</span></li>
                                <li><i class="icon-connection-empty"></i><span>icon-connection-empty</span></li>
                                <li><i class="icon-battery-full1"></i><span>icon-battery-full1</span></li>
                                <li><i class="icon-settings"></i><span>icon-settings</span></li>
                                <li><i class="icon-arrow-left1"></i><span>icon-arrow-left1</span></li>
                                <li><i class="icon-arrow-up1"></i><span>icon-arrow-up1</span></li>
                                <li><i class="icon-arrow-down1"></i><span>icon-arrow-down1</span></li>
                                <li><i class="icon-arrow-right1"></i><span>icon-arrow-right1</span></li>
                                <li><i class="icon-reload"></i><span>icon-reload</span></li>
                                <li><i class="icon-download1"></i><span>icon-download1</span></li>
                                <li><i class="icon-tag1"></i><span>icon-tag1</span></li>
                                <li><i class="icon-trashcan"></i><span>icon-trashcan</span></li>
                                <li><i class="icon-search1"></i><span>icon-search1</span></li>
                                <li><i class="icon-zoom-in"></i><span>icon-zoom-in</span></li>
                                <li><i class="icon-zoom-out"></i><span>icon-zoom-out</span></li>
                                <li><i class="icon-chat"></i><span>icon-chat</span></li>
                                <li><i class="icon-clock2"></i><span>icon-clock2</span></li>
                                <li><i class="icon-printer"></i><span>icon-printer</span></li>
                                <li><i class="icon-home1"></i><span>icon-home1</span></li>
                                <li><i class="icon-flag2"></i><span>icon-flag2</span></li>
                                <li><i class="icon-meter"></i><span>icon-meter</span></li>
                                <li><i class="icon-switch"></i><span>icon-switch</span></li>
                                <li><i class="icon-forbidden"></i><span>icon-forbidden</span></li>
                                <li><i class="icon-phone-landscape"></i><span>icon-phone-landscape</span></li>
                                <li><i class="icon-tablet1"></i><span>icon-tablet1</span></li>
                                <li><i class="icon-tablet-landscape"></i><span>icon-tablet-landscape</span></li>
                                <li><i class="icon-laptop1"></i><span>icon-laptop1</span></li>
                                <li><i class="icon-camera1"></i><span>icon-camera1</span></li>
                                <li><i class="icon-microwave-oven"></i><span>icon-microwave-oven</span></li>
                                <li><i class="icon-credit-cards"></i><span>icon-credit-cards</span></li>
                                <li><i class="icon-map-marker1"></i><span>icon-map-marker1</span></li>
                                <li><i class="icon-map2"></i><span>icon-map2</span></li>
                                <li><i class="icon-support"></i><span>icon-support</span></li>
                                <li><i class="icon-newspaper2"></i><span>icon-newspaper2</span></li>
                                <li><i class="icon-barbell"></i><span>icon-barbell</span></li>
                                <li><i class="icon-stopwatch1"></i><span>icon-stopwatch1</span></li>
                                <li><i class="icon-atom1"></i><span>icon-atom1</span></li>
                                <li><i class="icon-image2"></i><span>icon-image2</span></li>
                                <li><i class="icon-cube1"></i><span>icon-cube1</span></li>
                                <li><i class="icon-bars1"></i><span>icon-bars1</span></li>
                                <li><i class="icon-chart"></i><span>icon-chart</span></li>
                                <li><i class="icon-pencil"></i><span>icon-pencil</span></li>
                                <li><i class="icon-measure"></i><span>icon-measure</span></li>
                                <li><i class="icon-eyedropper"></i><span>icon-eyedropper</span></li>
                                <li><i class="icon-file-settings"></i><span>icon-file-settings</span></li>
                                <li><i class="icon-file-add"></i><span>icon-file-add</span></li>
                                <li><i class="icon-file2"></i><span>icon-file2</span></li>
                                <li><i class="icon-align-left1"></i><span>icon-align-left1</span></li>
                                <li><i class="icon-align-right1"></i><span>icon-align-right1</span></li>
                                <li><i class="icon-align-center1"></i><span>icon-align-center1</span></li>
                                <li><i class="icon-align-justify1"></i><span>icon-align-justify1</span></li>
                                <li><i class="icon-file-broken"></i><span>icon-file-broken</span></li>
                                <li><i class="icon-browser"></i><span>icon-browser</span></li>
                                <li><i class="icon-windows1"></i><span>icon-windows1</span></li>
                                <li><i class="icon-window"></i><span>icon-window</span></li>
                                <li><i class="icon-folder2"></i><span>icon-folder2</span></li>
                                <li><i class="icon-connection-25"></i><span>icon-connection-25</span></li>
                                <li><i class="icon-connection-50"></i><span>icon-connection-50</span></li>
                                <li><i class="icon-connection-75"></i><span>icon-connection-75</span></li>
                                <li><i class="icon-connection-full"></i><span>icon-connection-full</span></li>
                                <li><i class="icon-list1"></i><span>icon-list1</span></li>
                                <li><i class="icon-grid"></i><span>icon-grid</span></li>
                                <li><i class="icon-stack3"></i><span>icon-stack3</span></li>
                                <li><i class="icon-battery-charging"></i><span>icon-battery-charging</span></li>
                                <li><i class="icon-battery-empty1"></i><span>icon-battery-empty1</span></li>
                                <li><i class="icon-battery-25"></i><span>icon-battery-25</span></li>
                                <li><i class="icon-battery-50"></i><span>icon-battery-50</span></li>
                                <li><i class="icon-battery-75"></i><span>icon-battery-75</span></li>
                                <li><i class="icon-refresh"></i><span>icon-refresh</span></li>
                                <li><i class="icon-volume"></i><span>icon-volume</span></li>
                                <li><i class="icon-volume-increase"></i><span>icon-volume-increase</span></li>
                                <li><i class="icon-volume-decrease"></i><span>icon-volume-decrease</span></li>
                                <li><i class="icon-mute"></i><span>icon-mute</span></li>
                                <li><i class="icon-microphone1"></i><span>icon-microphone1</span></li>
                                <li><i class="icon-microphone-off"></i><span>icon-microphone-off</span></li>
                                <li><i class="icon-book1"></i><span>icon-book1</span></li>
                                <li><i class="icon-checkmark"></i><span>icon-checkmark</span></li>
                                <li><i class="icon-checkbox-checked"></i><span>icon-checkbox-checked</span></li>
                                <li><i class="icon-checkbox"></i><span>icon-checkbox</span></li>
                                <li><i class="icon-paperclip1"></i><span>icon-paperclip1</span></li>
                                <li><i class="icon-chat-1"></i><span>icon-chat-1</span></li>
                                <li><i class="icon-chat-2"></i><span>icon-chat-2</span></li>
                                <li><i class="icon-chat-3"></i><span>icon-chat-3</span></li>
                                <li><i class="icon-comment2"></i><span>icon-comment2</span></li>
                                <li><i class="icon-calendar2"></i><span>icon-calendar2</span></li>
                                <li><i class="icon-bookmark2"></i><span>icon-bookmark2</span></li>
                                <li><i class="icon-email2"></i><span>icon-email2</span></li>
                                <li><i class="icon-heart2"></i><span>icon-heart2</span></li>
                                <li><i class="icon-enter"></i><span>icon-enter</span></li>
                                <li><i class="icon-cloud1"></i><span>icon-cloud1</span></li>
                                <li><i class="icon-book2"></i><span>icon-book2</span></li>
                                <li><i class="icon-star2"></i><span>icon-star2</span></li>
                                <li><i class="icon-lock1"></i><span>icon-lock1</span></li>
                                <li><i class="icon-unlocked"></i><span>icon-unlocked</span></li>
                                <li><i class="icon-unlocked2"></i><span>icon-unlocked2</span></li>
                                <li><i class="icon-users1"></i><span>icon-users1</span></li>
                                <li><i class="icon-user2"></i><span>icon-user2</span></li>
                                <li><i class="icon-users2"></i><span>icon-users2</span></li>
                                <li><i class="icon-user21"></i><span>icon-user21</span></li>
                                <li><i class="icon-bullhorn1"></i><span>icon-bullhorn1</span></li>
                                <li><i class="icon-share1"></i><span>icon-share1</span></li>
                                <li><i class="icon-screen"></i><span>icon-screen</span></li>
                                <li><i class="icon-phone1"></i><span>icon-phone1</span></li>
                                <li><i class="icon-phone-portrait"></i><span>icon-phone-portrait</span></li>
                                <li><i class="icon-calculator1"></i><span>icon-calculator1</span></li>
                                <li><i class="icon-bag"></i><span>icon-bag</span></li>
                                <li><i class="icon-diamond"></i><span>icon-diamond</span></li>
                                <li><i class="icon-drink"></i><span>icon-drink</span></li>
                                <li><i class="icon-shorts"></i><span>icon-shorts</span></li>
                                <li><i class="icon-vcard"></i><span>icon-vcard</span></li>
                                <li><i class="icon-sun2"></i><span>icon-sun2</span></li>
                                <li><i class="icon-bill"></i><span>icon-bill</span></li>
                                <li><i class="icon-coffee1"></i><span>icon-coffee1</span></li>
                                <li><i class="icon-tv2"></i><span>icon-tv2</span></li>
                                <li><i class="icon-newspaper3"></i><span>icon-newspaper3</span></li>
                                <li><i class="icon-stack"></i><span>icon-stack</span></li>
                                <li><i class="icon-syringe1"></i><span>icon-syringe1</span></li>
                                <li><i class="icon-health"></i><span>icon-health</span></li>
                                <li><i class="icon-bolt1"></i><span>icon-bolt1</span></li>
                                <li><i class="icon-pill"></i><span>icon-pill</span></li>
                                <li><i class="icon-bones"></i><span>icon-bones</span></li>
                                <li><i class="icon-lab"></i><span>icon-lab</span></li>
                                <li><i class="icon-clipboard2"></i><span>icon-clipboard2</span></li>
                                <li><i class="icon-mug"></i><span>icon-mug</span></li>
                                <li><i class="icon-bucket"></i><span>icon-bucket</span></li>
                                <li><i class="icon-select"></i><span>icon-select</span></li>
                                <li><i class="icon-graph"></i><span>icon-graph</span></li>
                                <li><i class="icon-crop1"></i><span>icon-crop1</span></li>
                                <li><i class="icon-heart21"></i><span>icon-heart21</span></li>
                                <li><i class="icon-cloud2"></i><span>icon-cloud2</span></li>
                                <li><i class="icon-star21"></i><span>icon-star21</span></li>
                                <li><i class="icon-pen1"></i><span>icon-pen1</span></li>
                                <li><i class="icon-diamond2"></i><span>icon-diamond2</span></li>
                                <li><i class="icon-display"></i><span>icon-display</span></li>
                                <li><i class="icon-paperplane"></i><span>icon-paperplane</span></li>
                                <li><i class="icon-params"></i><span>icon-params</span></li>
                                <li><i class="icon-banknote"></i><span>icon-banknote</span></li>
                                <li><i class="icon-vynil"></i><span>icon-vynil</span></li>
                                <li><i class="icon-truck1"></i><span>icon-truck1</span></li>
                                <li><i class="icon-world"></i><span>icon-world</span></li>
                                <li><i class="icon-tv1"></i><span>icon-tv1</span></li>
                                <li><i class="icon-sound"></i><span>icon-sound</span></li>
                                <li><i class="icon-video1"></i><span>icon-video1</span></li>
                                <li><i class="icon-trash1"></i><span>icon-trash1</span></li>
                                <li><i class="icon-user3"></i><span>icon-user3</span></li>
                                <li><i class="icon-key1"></i><span>icon-key1</span></li>
                                <li><i class="icon-search2"></i><span>icon-search2</span></li>
                                <li><i class="icon-settings2"></i><span>icon-settings2</span></li>
                                <li><i class="icon-camera2"></i><span>icon-camera2</span></li>
                                <li><i class="icon-tag2"></i><span>icon-tag2</span></li>
                                <li><i class="icon-lock2"></i><span>icon-lock2</span></li>
                                <li><i class="icon-bulb"></i><span>icon-bulb</span></li>
                                <li><i class="icon-location"></i><span>icon-location</span></li>
                                <li><i class="icon-eye2"></i><span>icon-eye2</span></li>
                                <li><i class="icon-bubble"></i><span>icon-bubble</span></li>
                                <li><i class="icon-stack2"></i><span>icon-stack2</span></li>
                                <li><i class="icon-cup"></i><span>icon-cup</span></li>
                                <li><i class="icon-phone2"></i><span>icon-phone2</span></li>
                                <li><i class="icon-news"></i><span>icon-news</span></li>
                                <li><i class="icon-mail"></i><span>icon-mail</span></li>
                                <li><i class="icon-like"></i><span>icon-like</span></li>
                                <li><i class="icon-photo"></i><span>icon-photo</span></li>
                                <li><i class="icon-note"></i><span>icon-note</span></li>
                                <li><i class="icon-clock21"></i><span>icon-clock21</span></li>
                                <li><i class="icon-data"></i><span>icon-data</span></li>
                                <li><i class="icon-music1"></i><span>icon-music1</span></li>
                                <li><i class="icon-megaphone"></i><span>icon-megaphone</span></li>
                                <li><i class="icon-study"></i><span>icon-study</span></li>
                                <li><i class="icon-lab2"></i><span>icon-lab2</span></li>
                                <li><i class="icon-food"></i><span>icon-food</span></li>
                                <li><i class="icon-t-shirt"></i><span>icon-t-shirt</span></li>
                                <li><i class="icon-fire1"></i><span>icon-fire1</span></li>
                                <li><i class="icon-clip"></i><span>icon-clip</span></li>
                                <li><i class="icon-shop"></i><span>icon-shop</span></li>
                                <li><i class="icon-calendar21"></i><span>icon-calendar21</span></li>
                                <li><i class="icon-wallet1"></i><span>icon-wallet1</span></li>
                                <li><i class="icon-glass"></i><span>icon-glass</span></li>
                                <li><i class="icon-music2"></i><span>icon-music2</span></li>
                                <li><i class="icon-search3"></i><span>icon-search3</span></li>
                                <li><i class="icon-envelope21"></i><span>icon-envelope21</span></li>
                                <li><i class="icon-heart3"></i><span>icon-heart3</span></li>
                                <li><i class="icon-star3"></i><span>icon-star3</span></li>
                                <li><i class="icon-star-empty"></i><span>icon-star-empty</span></li>
                                <li><i class="icon-user4"></i><span>icon-user4</span></li>
                                <li><i class="icon-film1"></i><span>icon-film1</span></li>
                                <li><i class="icon-th-large1"></i><span>icon-th-large1</span></li>
                                <li><i class="icon-th1"></i><span>icon-th1</span></li>
                                <li><i class="icon-th-list1"></i><span>icon-th-list1</span></li>
                                <li><i class="icon-ok"></i><span>icon-ok</span></li>
                                <li><i class="icon-remove"></i><span>icon-remove</span></li>
                                <li><i class="icon-zoom-in2"></i><span>icon-zoom-in2</span></li>
                                <li><i class="icon-zoom-out2"></i><span>icon-zoom-out2</span></li>
                                <li><i class="icon-off"></i><span>icon-off</span></li>
                                <li><i class="icon-signal1"></i><span>icon-signal1</span></li>
                                <li><i class="icon-cog1"></i><span>icon-cog1</span></li>
                                <li><i class="icon-trash2"></i><span>icon-trash2</span></li>
                                <li><i class="icon-home2"></i><span>icon-home2</span></li>
                                <li><i class="icon-file21"></i><span>icon-file21</span></li>
                                <li><i class="icon-time"></i><span>icon-time</span></li>
                                <li><i class="icon-road1"></i><span>icon-road1</span></li>
                                <li><i class="icon-download-alt"></i><span>icon-download-alt</span></li>
                                <li><i class="icon-download2"></i><span>icon-download2</span></li>
                                <li><i class="icon-upload1"></i><span>icon-upload1</span></li>
                                <li><i class="icon-inbox1"></i><span>icon-inbox1</span></li>
                                <li><i class="icon-play-circle2"></i><span>icon-play-circle2</span></li>
                                <li><i class="icon-repeat"></i><span>icon-repeat</span></li>
                                <li><i class="icon-refresh2"></i><span>icon-refresh2</span></li>
                                <li><i class="icon-list-alt2"></i><span>icon-list-alt2</span></li>
                                <li><i class="icon-lock3"></i><span>icon-lock3</span></li>
                                <li><i class="icon-flag21"></i><span>icon-flag21</span></li>
                                <li><i class="icon-headphones1"></i><span>icon-headphones1</span></li>
                                <li><i class="icon-volume-off1"></i><span>icon-volume-off1</span></li>
                                <li><i class="icon-volume-down1"></i><span>icon-volume-down1</span></li>
                                <li><i class="icon-volume-up1"></i><span>icon-volume-up1</span></li>
                                <li><i class="icon-qrcode1"></i><span>icon-qrcode1</span></li>
                                <li><i class="icon-barcode1"></i><span>icon-barcode1</span></li>
                                <li><i class="icon-tag3"></i><span>icon-tag3</span></li>
                                <li><i class="icon-tags1"></i><span>icon-tags1</span></li>
                                <li><i class="icon-book3"></i><span>icon-book3</span></li>
                                <li><i class="icon-bookmark21"></i><span>icon-bookmark21</span></li>
                                <li><i class="icon-print2"></i><span>icon-print2</span></li>
                                <li><i class="icon-camera3"></i><span>icon-camera3</span></li>
                                <li><i class="icon-font1"></i><span>icon-font1</span></li>
                                <li><i class="icon-bold1"></i><span>icon-bold1</span></li>
                                <li><i class="icon-italic1"></i><span>icon-italic1</span></li>
                                <li><i class="icon-text-height1"></i><span>icon-text-height1</span></li>
                                <li><i class="icon-text-width1"></i><span>icon-text-width1</span></li>
                                <li><i class="icon-align-left2"></i><span>icon-align-left2</span></li>
                                <li><i class="icon-align-center2"></i><span>icon-align-center2</span></li>
                                <li><i class="icon-align-right2"></i><span>icon-align-right2</span></li>
                                <li><i class="icon-align-justify2"></i><span>icon-align-justify2</span></li>
                                <li><i class="icon-list2"></i><span>icon-list2</span></li>
                                <li><i class="icon-indent-left"></i><span>icon-indent-left</span></li>
                                <li><i class="icon-indent-right"></i><span>icon-indent-right</span></li>
                                <li><i class="icon-facetime-video"></i><span>icon-facetime-video</span></li>
                                <li><i class="icon-picture"></i><span>icon-picture</span></li>
                                <li><i class="icon-pencil2"></i><span>icon-pencil2</span></li>
                                <li><i class="icon-map-marker2"></i><span>icon-map-marker2</span></li>
                                <li><i class="icon-adjust1"></i><span>icon-adjust1</span></li>
                                <li><i class="icon-tint1"></i><span>icon-tint1</span></li>
                                <li><i class="icon-edit2"></i><span>icon-edit2</span></li>
                                <li><i class="icon-share2"></i><span>icon-share2</span></li>
                                <li><i class="icon-check1"></i><span>icon-check1</span></li>
                                <li><i class="icon-move"></i><span>icon-move</span></li>
                                <li><i class="icon-step-backward1"></i><span>icon-step-backward1</span></li>
                                <li><i class="icon-fast-backward1"></i><span>icon-fast-backward1</span></li>
                                <li><i class="icon-backward1"></i><span>icon-backward1</span></li>
                                <li><i class="icon-play1"></i><span>icon-play1</span></li>
                                <li><i class="icon-pause1"></i><span>icon-pause1</span></li>
                                <li><i class="icon-stop1"></i><span>icon-stop1</span></li>
                                <li><i class="icon-forward1"></i><span>icon-forward1</span></li>
                                <li><i class="icon-fast-forward1"></i><span>icon-fast-forward1</span></li>
                                <li><i class="icon-step-forward1"></i><span>icon-step-forward1</span></li>
                                <li><i class="icon-eject1"></i><span>icon-eject1</span></li>
                                <li><i class="icon-chevron-left1"></i><span>icon-chevron-left1</span></li>
                                <li><i class="icon-chevron-right1"></i><span>icon-chevron-right1</span></li>
                                <li><i class="icon-plus-sign"></i><span>icon-plus-sign</span></li>
                                <li><i class="icon-minus-sign"></i><span>icon-minus-sign</span></li>
                                <li><i class="icon-remove-sign"></i><span>icon-remove-sign</span></li>
                                <li><i class="icon-ok-sign"></i><span>icon-ok-sign</span></li>
                                <li><i class="icon-question-sign"></i><span>icon-question-sign</span></li>
                                <li><i class="icon-info-sign"></i><span>icon-info-sign</span></li>
                                <li><i class="icon-screenshot"></i><span>icon-screenshot</span></li>
                                <li><i class="icon-remove-circle"></i><span>icon-remove-circle</span></li>
                                <li><i class="icon-ok-circle"></i><span>icon-ok-circle</span></li>
                                <li><i class="icon-ban-circle"></i><span>icon-ban-circle</span></li>
                                <li><i class="icon-arrow-left2"></i><span>icon-arrow-left2</span></li>
                                <li><i class="icon-arrow-right2"></i><span>icon-arrow-right2</span></li>
                                <li><i class="icon-arrow-up2"></i><span>icon-arrow-up2</span></li>
                                <li><i class="icon-arrow-down2"></i><span>icon-arrow-down2</span></li>
                                <li><i class="icon-share-alt1"></i><span>icon-share-alt1</span></li>
                                <li><i class="icon-resize-full"></i><span>icon-resize-full</span></li>
                                <li><i class="icon-resize-small"></i><span>icon-resize-small</span></li>
                                <li><i class="icon-plus1"></i><span>icon-plus1</span></li>
                                <li><i class="icon-minus1"></i><span>icon-minus1</span></li>
                                <li><i class="icon-asterisk1"></i><span>icon-asterisk1</span></li>
                                <li><i class="icon-exclamation-sign"></i><span>icon-exclamation-sign</span></li>
                                <li><i class="icon-gift1"></i><span>icon-gift1</span></li>
                                <li><i class="icon-leaf1"></i><span>icon-leaf1</span></li>
                                <li><i class="icon-fire2"></i><span>icon-fire2</span></li>
                                <li><i class="icon-eye-open"></i><span>icon-eye-open</span></li>
                                <li><i class="icon-eye-close"></i><span>icon-eye-close</span></li>
                                <li><i class="icon-warning-sign"></i><span>icon-warning-sign</span></li>
                                <li><i class="icon-plane1"></i><span>icon-plane1</span></li>
                                <li><i class="icon-calendar3"></i><span>icon-calendar3</span></li>
                                <li><i class="icon-random1"></i><span>icon-random1</span></li>
                                <li><i class="icon-comment21"></i><span>icon-comment21</span></li>
                                <li><i class="icon-magnet1"></i><span>icon-magnet1</span></li>
                                <li><i class="icon-chevron-up1"></i><span>icon-chevron-up1</span></li>
                                <li><i class="icon-chevron-down1"></i><span>icon-chevron-down1</span></li>
                                <li><i class="icon-retweet1"></i><span>icon-retweet1</span></li>
                                <li><i class="icon-shopping-cart1"></i><span>icon-shopping-cart1</span></li>
                                <li><i class="icon-folder-close"></i><span>icon-folder-close</span></li>
                                <li><i class="icon-folder-open2"></i><span>icon-folder-open2</span></li>
                                <li><i class="icon-resize-vertical"></i><span>icon-resize-vertical</span></li>
                                <li><i class="icon-resize-horizontal"></i><span>icon-resize-horizontal</span></li>
                                <li><i class="icon-bar-chart"></i><span>icon-bar-chart</span></li>
                                <li><i class="icon-twitter-sign"></i><span>icon-twitter-sign</span></li>
                                <li><i class="icon-facebook-sign"></i><span>icon-facebook-sign</span></li>
                                <li><i class="icon-camera-retro1"></i><span>icon-camera-retro1</span></li>
                                <li><i class="icon-key2"></i><span>icon-key2</span></li>
                                <li><i class="icon-cogs1"></i><span>icon-cogs1</span></li>
                                <li><i class="icon-comments2"></i><span>icon-comments2</span></li>
                                <li><i class="icon-thumbs-up2"></i><span>icon-thumbs-up2</span></li>
                                <li><i class="icon-thumbs-down2"></i><span>icon-thumbs-down2</span></li>
                                <li><i class="icon-star-half2"></i><span>icon-star-half2</span></li>
                                <li><i class="icon-heart-empty"></i><span>icon-heart-empty</span></li>
                                <li><i class="icon-signout"></i><span>icon-signout</span></li>
                                <li><i class="icon-linkedin-sign"></i><span>icon-linkedin-sign</span></li>
                                <li><i class="icon-pushpin"></i><span>icon-pushpin</span></li>
                                <li><i class="icon-external-link"></i><span>icon-external-link</span></li>
                                <li><i class="icon-signin"></i><span>icon-signin</span></li>
                                <li><i class="icon-trophy1"></i><span>icon-trophy1</span></li>
                                <li><i class="icon-github-sign"></i><span>icon-github-sign</span></li>
                                <li><i class="icon-upload-alt"></i><span>icon-upload-alt</span></li>
                                <li><i class="icon-lemon2"></i><span>icon-lemon2</span></li>
                                <li><i class="icon-phone3"></i><span>icon-phone3</span></li>
                                <li><i class="icon-check-empty"></i><span>icon-check-empty</span></li>
                                <li><i class="icon-bookmark-empty"></i><span>icon-bookmark-empty</span></li>
                                <li><i class="icon-phone-sign"></i><span>icon-phone-sign</span></li>
                                <li><i class="icon-twitter2"></i><span>icon-twitter2</span></li>
                                <li><i class="icon-facebook2"></i><span>icon-facebook2</span></li>
                                <li><i class="icon-github2"></i><span>icon-github2</span></li>
                                <li><i class="icon-unlock1"></i><span>icon-unlock1</span></li>
                                <li><i class="icon-credit"></i><span>icon-credit</span></li>
                                <li><i class="icon-rss2"></i><span>icon-rss2</span></li>
                                <li><i class="icon-hdd2"></i><span>icon-hdd2</span></li>
                                <li><i class="icon-bullhorn2"></i><span>icon-bullhorn2</span></li>
                                <li><i class="icon-bell2"></i><span>icon-bell2</span></li>
                                <li><i class="icon-certificate1"></i><span>icon-certificate1</span></li>
                                <li><i class="icon-hand-right"></i><span>icon-hand-right</span></li>
                                <li><i class="icon-hand-left"></i><span>icon-hand-left</span></li>
                                <li><i class="icon-hand-up"></i><span>icon-hand-up</span></li>
                                <li><i class="icon-hand-down"></i><span>icon-hand-down</span></li>
                                <li><i class="icon-circle-arrow-left"></i><span>icon-circle-arrow-left</span></li>
                                <li><i class="icon-circle-arrow-right"></i><span>icon-circle-arrow-right</span></li>
                                <li><i class="icon-circle-arrow-up"></i><span>icon-circle-arrow-up</span></li>
                                <li><i class="icon-circle-arrow-down"></i><span>icon-circle-arrow-down</span></li>
                                <li><i class="icon-globe1"></i><span>icon-globe1</span></li>
                                <li><i class="icon-wrench1"></i><span>icon-wrench1</span></li>
                                <li><i class="icon-tasks1"></i><span>icon-tasks1</span></li>
                                <li><i class="icon-filter1"></i><span>icon-filter1</span></li>
                                <li><i class="icon-briefcase1"></i><span>icon-briefcase1</span></li>
                                <li><i class="icon-fullscreen"></i><span>icon-fullscreen</span></li>
                                <li><i class="icon-group"></i><span>icon-group</span></li>
                                <li><i class="icon-link1"></i><span>icon-link1</span></li>
                                <li><i class="icon-cloud3"></i><span>icon-cloud3</span></li>
                                <li><i class="icon-beaker"></i><span>icon-beaker</span></li>
                                <li><i class="icon-cut1"></i><span>icon-cut1</span></li>
                                <li><i class="icon-copy2"></i><span>icon-copy2</span></li>
                                <li><i class="icon-paper-clip"></i><span>icon-paper-clip</span></li>
                                <li><i class="icon-save2"></i><span>icon-save2</span></li>
                                <li><i class="icon-sign-blank"></i><span>icon-sign-blank</span></li>
                                <li><i class="icon-reorder"></i><span>icon-reorder</span></li>
                                <li><i class="icon-list-ul1"></i><span>icon-list-ul1</span></li>
                                <li><i class="icon-list-ol1"></i><span>icon-list-ol1</span></li>
                                <li><i class="icon-strikethrough1"></i><span>icon-strikethrough1</span></li>
                                <li><i class="icon-underline1"></i><span>icon-underline1</span></li>
                                <li><i class="icon-table1"></i><span>icon-table1</span></li>
                                <li><i class="icon-magic1"></i><span>icon-magic1</span></li>
                                <li><i class="icon-truck2"></i><span>icon-truck2</span></li>
                                <li><i class="icon-pinterest2"></i><span>icon-pinterest2</span></li>
                                <li><i class="icon-pinterest-sign"></i><span>icon-pinterest-sign</span></li>
                                <li><i class="icon-google-plus-sign"></i><span>icon-google-plus-sign</span></li>
                                <li><i class="icon-google-plus1"></i><span>icon-google-plus1</span></li>
                                <li><i class="icon-money"></i><span>icon-money</span></li>
                                <li><i class="icon-caret-down1"></i><span>icon-caret-down1</span></li>
                                <li><i class="icon-caret-up1"></i><span>icon-caret-up1</span></li>
                                <li><i class="icon-caret-left1"></i><span>icon-caret-left1</span></li>
                                <li><i class="icon-caret-right1"></i><span>icon-caret-right1</span></li>
                                <li><i class="icon-columns1"></i><span>icon-columns1</span></li>
                                <li><i class="icon-sort1"></i><span>icon-sort1</span></li>
                                <li><i class="icon-sort-down1"></i><span>icon-sort-down1</span></li>
                                <li><i class="icon-sort-up1"></i><span>icon-sort-up1</span></li>
                                <li><i class="icon-envelope-alt"></i><span>icon-envelope-alt</span></li>
                                <li><i class="icon-linkedin2"></i><span>icon-linkedin2</span></li>
                                <li><i class="icon-undo1"></i><span>icon-undo1</span></li>
                                <li><i class="icon-legal"></i><span>icon-legal</span></li>
                                <li><i class="icon-dashboard"></i><span>icon-dashboard</span></li>
                                <li><i class="icon-comment-alt2"></i><span>icon-comment-alt2</span></li>
                                <li><i class="icon-comments-alt"></i><span>icon-comments-alt</span></li>
                                <li><i class="icon-bolt2"></i><span>icon-bolt2</span></li>
                                <li><i class="icon-sitemap1"></i><span>icon-sitemap1</span></li>
                                <li><i class="icon-umbrella1"></i><span>icon-umbrella1</span></li>
                                <li><i class="icon-paste1"></i><span>icon-paste1</span></li>
                                <li><i class="icon-lightbulb2"></i><span>icon-lightbulb2</span></li>
                                <li><i class="icon-exchange"></i><span>icon-exchange</span></li>
                                <li><i class="icon-cloud-download"></i><span>icon-cloud-download</span></li>
                                <li><i class="icon-cloud-upload"></i><span>icon-cloud-upload</span></li>
                                <li><i class="icon-user-md1"></i><span>icon-user-md1</span></li>
                                <li><i class="icon-stethoscope1"></i><span>icon-stethoscope1</span></li>
                                <li><i class="icon-suitcase1"></i><span>icon-suitcase1</span></li>
                                <li><i class="icon-bell-alt"></i><span>icon-bell-alt</span></li>
                                <li><i class="icon-coffee2"></i><span>icon-coffee2</span></li>
                                <li><i class="icon-food2"></i><span>icon-food2</span></li>
                                <li><i class="icon-file-alt2"></i><span>icon-file-alt2</span></li>
                                <li><i class="icon-building2"></i><span>icon-building2</span></li>
                                <li><i class="icon-hospital2"></i><span>icon-hospital2</span></li>
                                <li><i class="icon-ambulance1"></i><span>icon-ambulance1</span></li>
                                <li><i class="icon-medkit1"></i><span>icon-medkit1</span></li>
                                <li><i class="icon-fighter-jet1"></i><span>icon-fighter-jet1</span></li>
                                <li><i class="icon-beer1"></i><span>icon-beer1</span></li>
                                <li><i class="icon-h-sign"></i><span>icon-h-sign</span></li>
                                <li><i class="icon-plus-sign2"></i><span>icon-plus-sign2</span></li>
                                <li><i class="icon-double-angle-left"></i><span>icon-double-angle-left</span></li>
                                <li><i class="icon-double-angle-right"></i><span>icon-double-angle-right</span></li>
                                <li><i class="icon-double-angle-up"></i><span>icon-double-angle-up</span></li>
                                <li><i class="icon-double-angle-down"></i><span>icon-double-angle-down</span></li>
                                <li><i class="icon-angle-left1"></i><span>icon-angle-left1</span></li>
                                <li><i class="icon-angle-right1"></i><span>icon-angle-right1</span></li>
                                <li><i class="icon-angle-up1"></i><span>icon-angle-up1</span></li>
                                <li><i class="icon-angle-down1"></i><span>icon-angle-down1</span></li>
                                <li><i class="icon-desktop1"></i><span>icon-desktop1</span></li>
                                <li><i class="icon-laptop2"></i><span>icon-laptop2</span></li>
                                <li><i class="icon-tablet2"></i><span>icon-tablet2</span></li>
                                <li><i class="icon-mobile1"></i><span>icon-mobile1</span></li>
                                <li><i class="icon-circle-blank"></i><span>icon-circle-blank</span></li>
                                <li><i class="icon-quote-left1"></i><span>icon-quote-left1</span></li>
                                <li><i class="icon-quote-right1"></i><span>icon-quote-right1</span></li>
                                <li><i class="icon-spinner1"></i><span>icon-spinner1</span></li>
                                <li><i class="icon-circle2"></i><span>icon-circle2</span></li>
                                <li><i class="icon-reply1"></i><span>icon-reply1</span></li>
                                <li><i class="icon-github-alt1"></i><span>icon-github-alt1</span></li>
                                <li><i class="icon-folder-close-alt"></i><span>icon-folder-close-alt</span></li>
                                <li><i class="icon-folder-open-alt"></i><span>icon-folder-open-alt</span></li>
                                <li><i class="icon-expand-alt"></i><span>icon-expand-alt</span></li>
                                <li><i class="icon-collapse-alt"></i><span>icon-collapse-alt</span></li>
                                <li><i class="icon-smile2"></i><span>icon-smile2</span></li>
                                <li><i class="icon-frown2"></i><span>icon-frown2</span></li>
                                <li><i class="icon-meh2"></i><span>icon-meh2</span></li>
                                <li><i class="icon-gamepad1"></i><span>icon-gamepad1</span></li>
                                <li><i class="icon-keyboard2"></i><span>icon-keyboard2</span></li>
                                <li><i class="icon-flag-alt"></i><span>icon-flag-alt</span></li>
                                <li><i class="icon-flag-checkered1"></i><span>icon-flag-checkered1</span></li>
                                <li><i class="icon-terminal1"></i><span>icon-terminal1</span></li>
                                <li><i class="icon-code1"></i><span>icon-code1</span></li>
                                <li><i class="icon-reply-all1"></i><span>icon-reply-all1</span></li>
                                <li><i class="icon-star-half-full"></i><span>icon-star-half-full</span></li>
                                <li><i class="icon-location-arrow1"></i><span>icon-location-arrow1</span></li>
                                <li><i class="icon-crop2"></i><span>icon-crop2</span></li>
                                <li><i class="icon-code-fork"></i><span>icon-code-fork</span></li>
                                <li><i class="icon-unlink1"></i><span>icon-unlink1</span></li>
                                <li><i class="icon-question1"></i><span>icon-question1</span></li>
                                <li><i class="icon-info1"></i><span>icon-info1</span></li>
                                <li><i class="icon-exclamation1"></i><span>icon-exclamation1</span></li>
                                <li><i class="icon-superscript1"></i><span>icon-superscript1</span></li>
                                <li><i class="icon-subscript1"></i><span>icon-subscript1</span></li>
                                <li><i class="icon-eraser1"></i><span>icon-eraser1</span></li>
                                <li><i class="icon-puzzle"></i><span>icon-puzzle</span></li>
                                <li><i class="icon-microphone2"></i><span>icon-microphone2</span></li>
                                <li><i class="icon-microphone-off2"></i><span>icon-microphone-off2</span></li>
                                <li><i class="icon-shield"></i><span>icon-shield</span></li>
                                <li><i class="icon-calendar-empty"></i><span>icon-calendar-empty</span></li>
                                <li><i class="icon-fire-extinguisher1"></i><span>icon-fire-extinguisher1</span></li>
                                <li><i class="icon-rocket1"></i><span>icon-rocket1</span></li>
                                <li><i class="icon-maxcdn1"></i><span>icon-maxcdn1</span></li>
                                <li><i class="icon-chevron-sign-left"></i><span>icon-chevron-sign-left</span></li>
                                <li><i class="icon-chevron-sign-right"></i><span>icon-chevron-sign-right</span></li>
                                <li><i class="icon-chevron-sign-up"></i><span>icon-chevron-sign-up</span></li>
                                <li><i class="icon-chevron-sign-down"></i><span>icon-chevron-sign-down</span></li>
                                <li><i class="icon-html52"></i><span>icon-html52</span></li>
                                <li><i class="icon-css31"></i><span>icon-css31</span></li>
                                <li><i class="icon-anchor1"></i><span>icon-anchor1</span></li>
                                <li><i class="icon-unlock-alt1"></i><span>icon-unlock-alt1</span></li>
                                <li><i class="icon-bullseye1"></i><span>icon-bullseye1</span></li>
                                <li><i class="icon-ellipsis-horizontal"></i><span>icon-ellipsis-horizontal</span></li>
                                <li><i class="icon-ellipsis-vertical"></i><span>icon-ellipsis-vertical</span></li>
                                <li><i class="icon-rss-sign"></i><span>icon-rss-sign</span></li>
                                <li><i class="icon-play-sign"></i><span>icon-play-sign</span></li>
                                <li><i class="icon-ticket"></i><span>icon-ticket</span></li>
                                <li><i class="icon-minus-sign-alt"></i><span>icon-minus-sign-alt</span></li>
                                <li><i class="icon-check-minus"></i><span>icon-check-minus</span></li>
                                <li><i class="icon-level-up"></i><span>icon-level-up</span></li>
                                <li><i class="icon-level-down"></i><span>icon-level-down</span></li>
                                <li><i class="icon-check-sign"></i><span>icon-check-sign</span></li>
                                <li><i class="icon-edit-sign"></i><span>icon-edit-sign</span></li>
                                <li><i class="icon-external-link-sign"></i><span>icon-external-link-sign</span></li>
                                <li><i class="icon-share-sign"></i><span>icon-share-sign</span></li>
                                <li><i class="icon-compass2"></i><span>icon-compass2</span></li>
                                <li><i class="icon-collapse"></i><span>icon-collapse</span></li>
                                <li><i class="icon-collapse-top"></i><span>icon-collapse-top</span></li>
                                <li><i class="icon-expand1"></i><span>icon-expand1</span></li>
                                <li><i class="icon-euro"></i><span>icon-euro</span></li>
                                <li><i class="icon-gbp"></i><span>icon-gbp</span></li>
                                <li><i class="icon-dollar"></i><span>icon-dollar</span></li>
                                <li><i class="icon-rupee"></i><span>icon-rupee</span></li>
                                <li><i class="icon-yen"></i><span>icon-yen</span></li>
                                <li><i class="icon-renminbi"></i><span>icon-renminbi</span></li>
                                <li><i class="icon-won"></i><span>icon-won</span></li>
                                <li><i class="icon-bitcoin2"></i><span>icon-bitcoin2</span></li>
                                <li><i class="icon-file3"></i><span>icon-file3</span></li>
                                <li><i class="icon-file-text"></i><span>icon-file-text</span></li>
                                <li><i class="icon-sort-by-alphabet"></i><span>icon-sort-by-alphabet</span></li>
                                <li><i class="icon-sort-by-alphabet-alt"></i><span>icon-sort-by-alphabet-alt</span></li>
                                <li><i class="icon-sort-by-attributes"></i><span>icon-sort-by-attributes</span></li>
                                <li><i class="icon-sort-by-attributes-alt"></i><span>icon-sort-by-attributes-alt</span></li>
                                <li><i class="icon-sort-by-order"></i><span>icon-sort-by-order</span></li>
                                <li><i class="icon-sort-by-order-alt"></i><span>icon-sort-by-order-alt</span></li>
                                <li><i class="icon-thumbs-up21"></i><span>icon-thumbs-up21</span></li>
                                <li><i class="icon-thumbs-down21"></i><span>icon-thumbs-down21</span></li>
                                <li><i class="icon-youtube-sign"></i><span>icon-youtube-sign</span></li>
                                <li><i class="icon-youtube2"></i><span>icon-youtube2</span></li>
                                <li><i class="icon-xing2"></i><span>icon-xing2</span></li>
                                <li><i class="icon-xing-sign"></i><span>icon-xing-sign</span></li>
                                <li><i class="icon-youtube-play"></i><span>icon-youtube-play</span></li>
                                <li><i class="icon-dropbox2"></i><span>icon-dropbox2</span></li>
                                <li><i class="icon-stackexchange"></i><span>icon-stackexchange</span></li>
                                <li><i class="icon-instagram2"></i><span>icon-instagram2</span></li>
                                <li><i class="icon-flickr2"></i><span>icon-flickr2</span></li>
                                <li><i class="icon-adn1"></i><span>icon-adn1</span></li>
                                <li><i class="icon-bitbucket2"></i><span>icon-bitbucket2</span></li>
                                <li><i class="icon-bitbucket-sign"></i><span>icon-bitbucket-sign</span></li>
                                <li><i class="icon-tumblr2"></i><span>icon-tumblr2</span></li>
                                <li><i class="icon-tumblr-sign"></i><span>icon-tumblr-sign</span></li>
                                <li><i class="icon-long-arrow-down"></i><span>icon-long-arrow-down</span></li>
                                <li><i class="icon-long-arrow-up"></i><span>icon-long-arrow-up</span></li>
                                <li><i class="icon-long-arrow-left"></i><span>icon-long-arrow-left</span></li>
                                <li><i class="icon-long-arrow-right"></i><span>icon-long-arrow-right</span></li>
                                <li><i class="icon-apple1"></i><span>icon-apple1</span></li>
                                <li><i class="icon-windows3"></i><span>icon-windows3</span></li>
                                <li><i class="icon-android2"></i><span>icon-android2</span></li>
                                <li><i class="icon-linux1"></i><span>icon-linux1</span></li>
                                <li><i class="icon-dribbble2"></i><span>icon-dribbble2</span></li>
                                <li><i class="icon-skype2"></i><span>icon-skype2</span></li>
                                <li><i class="icon-foursquare2"></i><span>icon-foursquare2</span></li>
                                <li><i class="icon-trello1"></i><span>icon-trello1</span></li>
                                <li><i class="icon-female1"></i><span>icon-female1</span></li>
                                <li><i class="icon-male1"></i><span>icon-male1</span></li>
                                <li><i class="icon-gittip"></i><span>icon-gittip</span></li>
                                <li><i class="icon-sun21"></i><span>icon-sun21</span></li>
                                <li><i class="icon-moon2"></i><span>icon-moon2</span></li>
                                <li><i class="icon-archive2"></i><span>icon-archive2</span></li>
                                <li><i class="icon-bug1"></i><span>icon-bug1</span></li>
                                <li><i class="icon-renren1"></i><span>icon-renren1</span></li>
                                <li><i class="icon-weibo2"></i><span>icon-weibo2</span></li>
                                <li><i class="icon-vk2"></i><span>icon-vk2</span></li>
                                <li><i class="icon-duckduckgo"></i><span>icon-duckduckgo</span></li>
                                <li><i class="icon-aim"></i><span>icon-aim</span></li>
                                <li><i class="icon-delicious1"></i><span>icon-delicious1</span></li>
                                <li><i class="icon-paypal1"></i><span>icon-paypal1</span></li>
                                <li><i class="icon-flattr"></i><span>icon-flattr</span></li>
                                <li><i class="icon-android1"></i><span>icon-android1</span></li>
                                <li><i class="icon-eventful"></i><span>icon-eventful</span></li>
                                <li><i class="icon-smashmag"></i><span>icon-smashmag</span></li>
                                <li><i class="icon-gplus"></i><span>icon-gplus</span></li>
                                <li><i class="icon-wikipedia"></i><span>icon-wikipedia</span></li>
                                <li><i class="icon-lanyrd"></i><span>icon-lanyrd</span></li>
                                <li><i class="icon-calendar-1"></i><span>icon-calendar-1</span></li>
                                <li><i class="icon-stumbleupon1"></i><span>icon-stumbleupon1</span></li>
                                <li><i class="icon-fivehundredpx"></i><span>icon-fivehundredpx</span></li>
                                <li><i class="icon-pinterest1"></i><span>icon-pinterest1</span></li>
                                <li><i class="icon-bitcoin1"></i><span>icon-bitcoin1</span></li>
                                <li><i class="icon-w3c"></i><span>icon-w3c</span></li>
                                <li><i class="icon-foursquare1"></i><span>icon-foursquare1</span></li>
                                <li><i class="icon-html51"></i><span>icon-html51</span></li>
                                <li><i class="icon-ie"></i><span>icon-ie</span></li>
                                <li><i class="icon-call"></i><span>icon-call</span></li>
                                <li><i class="icon-grooveshark"></i><span>icon-grooveshark</span></li>
                                <li><i class="icon-ninetyninedesigns"></i><span>icon-ninetyninedesigns</span></li>
                                <li><i class="icon-forrst"></i><span>icon-forrst</span></li>
                                <li><i class="icon-digg1"></i><span>icon-digg1</span></li>
                                <li><i class="icon-spotify1"></i><span>icon-spotify1</span></li>
                                <li><i class="icon-reddit1"></i><span>icon-reddit1</span></li>
                                <li><i class="icon-guest"></i><span>icon-guest</span></li>
                                <li><i class="icon-gowalla"></i><span>icon-gowalla</span></li>
                                <li><i class="icon-appstore"></i><span>icon-appstore</span></li>
                                <li><i class="icon-blogger1"></i><span>icon-blogger1</span></li>
                                <li><i class="icon-cc"></i><span>icon-cc</span></li>
                                <li><i class="icon-dribbble1"></i><span>icon-dribbble1</span></li>
                                <li><i class="icon-evernote"></i><span>icon-evernote</span></li>
                                <li><i class="icon-flickr1"></i><span>icon-flickr1</span></li>
                                <li><i class="icon-google1"></i><span>icon-google1</span></li>
                                <li><i class="icon-viadeo1"></i><span>icon-viadeo1</span></li>
                                <li><i class="icon-instapaper"></i><span>icon-instapaper</span></li>
                                <li><i class="icon-weibo1"></i><span>icon-weibo1</span></li>
                                <li><i class="icon-klout"></i><span>icon-klout</span></li>
                                <li><i class="icon-linkedin1"></i><span>icon-linkedin1</span></li>
                                <li><i class="icon-meetup1"></i><span>icon-meetup1</span></li>
                                <li><i class="icon-vk1"></i><span>icon-vk1</span></li>
                                <li><i class="icon-plancast"></i><span>icon-plancast</span></li>
                                <li><i class="icon-disqus"></i><span>icon-disqus</span></li>
                                <li><i class="icon-rss1"></i><span>icon-rss1</span></li>
                                <li><i class="icon-skype1"></i><span>icon-skype1</span></li>
                                <li><i class="icon-twitter1"></i><span>icon-twitter1</span></li>
                                <li><i class="icon-youtube1"></i><span>icon-youtube1</span></li>
                                <li><i class="icon-vimeo1"></i><span>icon-vimeo1</span></li>
                                <li><i class="icon-windows2"></i><span>icon-windows2</span></li>
                                <li><i class="icon-xing1"></i><span>icon-xing1</span></li>
                                <li><i class="icon-yahoo1"></i><span>icon-yahoo1</span></li>
                                <li><i class="icon-chrome1"></i><span>icon-chrome1</span></li>
                                <li><i class="icon-email3"></i><span>icon-email3</span></li>
                                <li><i class="icon-macstore"></i><span>icon-macstore</span></li>
                                <li><i class="icon-myspace"></i><span>icon-myspace</span></li>
                                <li><i class="icon-podcast1"></i><span>icon-podcast1</span></li>
                                <li><i class="icon-amazon1"></i><span>icon-amazon1</span></li>
                                <li><i class="icon-steam1"></i><span>icon-steam1</span></li>
                                <li><i class="icon-cloudapp"></i><span>icon-cloudapp</span></li>
                                <li><i class="icon-dropbox1"></i><span>icon-dropbox1</span></li>
                                <li><i class="icon-ebay1"></i><span>icon-ebay1</span></li>
                                <li><i class="icon-facebook1"></i><span>icon-facebook1</span></li>
                                <li><i class="icon-github1"></i><span>icon-github1</span></li>
                                <li><i class="icon-github-circled"></i><span>icon-github-circled</span></li>
                                <li><i class="icon-googleplay"></i><span>icon-googleplay</span></li>
                                <li><i class="icon-itunes1"></i><span>icon-itunes1</span></li>
                                <li><i class="icon-plurk"></i><span>icon-plurk</span></li>
                                <li><i class="icon-songkick"></i><span>icon-songkick</span></li>
                                <li><i class="icon-lastfm1"></i><span>icon-lastfm1</span></li>
                                <li><i class="icon-gmail"></i><span>icon-gmail</span></li>
                                <li><i class="icon-pinboard"></i><span>icon-pinboard</span></li>
                                <li><i class="icon-openid1"></i><span>icon-openid1</span></li>
                                <li><i class="icon-quora1"></i><span>icon-quora1</span></li>
                                <li><i class="icon-soundcloud1"></i><span>icon-soundcloud1</span></li>
                                <li><i class="icon-tumblr1"></i><span>icon-tumblr1</span></li>
                                <li><i class="icon-eventasaurus"></i><span>icon-eventasaurus</span></li>
                                <li><i class="icon-wordpress1"></i><span>icon-wordpress1</span></li>
                                <li><i class="icon-yelp1"></i><span>icon-yelp1</span></li>
                                <li><i class="icon-intensedebate"></i><span>icon-intensedebate</span></li>
                                <li><i class="icon-eventbrite"></i><span>icon-eventbrite</span></li>
                                <li><i class="icon-scribd1"></i><span>icon-scribd1</span></li>
                                <li><i class="icon-posterous"></i><span>icon-posterous</span></li>
                                <li><i class="icon-stripe1"></i><span>icon-stripe1</span></li>
                                <li><i class="icon-opentable"></i><span>icon-opentable</span></li>
                                <li><i class="icon-cart"></i><span>icon-cart</span></li>
                                <li><i class="icon-print1"></i><span>icon-print1</span></li>
                                <li><i class="icon-angellist1"></i><span>icon-angellist1</span></li>
                                <li><i class="icon-instagram1"></i><span>icon-instagram1</span></li>
                                <li><i class="icon-dwolla"></i><span>icon-dwolla</span></li>
                                <li><i class="icon-appnet"></i><span>icon-appnet</span></li>
                                <li><i class="icon-statusnet"></i><span>icon-statusnet</span></li>
                                <li><i class="icon-acrobat"></i><span>icon-acrobat</span></li>
                                <li><i class="icon-drupal1"></i><span>icon-drupal1</span></li>
                                <li><i class="icon-buffer"></i><span>icon-buffer</span></li>
                                <li><i class="icon-pocket"></i><span>icon-pocket</span></li>
                                <li><i class="icon-bitbucket1"></i><span>icon-bitbucket1</span></li>
                                <li><i class="icon-lego"></i><span>icon-lego</span></li>
                                <li><i class="icon-login"></i><span>icon-login</span></li>
                                <li><i class="icon-stackoverflow"></i><span>icon-stackoverflow</span></li>
                                <li><i class="icon-hackernews"></i><span>icon-hackernews</span></li>
                                <li><i class="icon-lkdto"></i><span>icon-lkdto</span></li>
                                <li><i class="icon-ad"></i><span>icon-ad</span></li>
                                <li><i class="icon-address-book"></i><span>icon-address-book</span></li>
                                <li><i class="icon-address-card"></i><span>icon-address-card</span></li>
                                <li><i class="icon-adjust"></i><span>icon-adjust</span></li>
                                <li><i class="icon-air-freshener"></i><span>icon-air-freshener</span></li>
                                <li><i class="icon-align-center"></i><span>icon-align-center</span></li>
                                <li><i class="icon-align-justify"></i><span>icon-align-justify</span></li>
                                <li><i class="icon-align-left"></i><span>icon-align-left</span></li>
                                <li><i class="icon-align-right"></i><span>icon-align-right</span></li>
                                <li><i class="icon-allergies"></i><span>icon-allergies</span></li>
                                <li><i class="icon-ambulance"></i><span>icon-ambulance</span></li>
                                <li><i class="icon-american-sign-language-interpreting"></i><span>icon-american-sign-language-interpreting</span></li>
                                <li><i class="icon-anchor"></i><span>icon-anchor</span></li>
                                <li><i class="icon-angle-double-down"></i><span>icon-angle-double-down</span></li>
                                <li><i class="icon-angle-double-left"></i><span>icon-angle-double-left</span></li>
                                <li><i class="icon-angle-double-right"></i><span>icon-angle-double-right</span></li>
                                <li><i class="icon-angle-double-up"></i><span>icon-angle-double-up</span></li>
                                <li><i class="icon-angle-down"></i><span>icon-angle-down</span></li>
                                <li><i class="icon-angle-left"></i><span>icon-angle-left</span></li>
                                <li><i class="icon-angle-right"></i><span>icon-angle-right</span></li>
                                <li><i class="icon-angle-up"></i><span>icon-angle-up</span></li>
                                <li><i class="icon-angry"></i><span>icon-angry</span></li>
                                <li><i class="icon-ankh"></i><span>icon-ankh</span></li>
                                <li><i class="icon-apple-alt"></i><span>icon-apple-alt</span></li>
                                <li><i class="icon-archive"></i><span>icon-archive</span></li>
                                <li><i class="icon-archway"></i><span>icon-archway</span></li>
                                <li><i class="icon-arrow-alt-circle-down"></i><span>icon-arrow-alt-circle-down</span></li>
                                <li><i class="icon-arrow-alt-circle-left"></i><span>icon-arrow-alt-circle-left</span></li>
                                <li><i class="icon-arrow-alt-circle-right"></i><span>icon-arrow-alt-circle-right</span></li>
                                <li><i class="icon-arrow-alt-circle-up"></i><span>icon-arrow-alt-circle-up</span></li>
                                <li><i class="icon-arrow-circle-down"></i><span>icon-arrow-circle-down</span></li>
                                <li><i class="icon-arrow-circle-left"></i><span>icon-arrow-circle-left</span></li>
                                <li><i class="icon-arrow-circle-right"></i><span>icon-arrow-circle-right</span></li>
                                <li><i class="icon-arrow-circle-up"></i><span>icon-arrow-circle-up</span></li>
                                <li><i class="icon-arrow-down"></i><span>icon-arrow-down</span></li>
                                <li><i class="icon-arrow-left"></i><span>icon-arrow-left</span></li>
                                <li><i class="icon-arrow-right"></i><span>icon-arrow-right</span></li>
                                <li><i class="icon-arrow-up"></i><span>icon-arrow-up</span></li>
                                <li><i class="icon-arrows-alt-h"></i><span>icon-arrows-alt-h</span></li>
                                <li><i class="icon-arrows-alt-v"></i><span>icon-arrows-alt-v</span></li>
                                <li><i class="icon-arrows-alt"></i><span>icon-arrows-alt</span></li>
                                <li><i class="icon-assistive-listening-systems"></i><span>icon-assistive-listening-systems</span></li>
                                <li><i class="icon-asterisk"></i><span>icon-asterisk</span></li>
                                <li><i class="icon-at"></i><span>icon-at</span></li>
                                <li><i class="icon-atlas"></i><span>icon-atlas</span></li>
                                <li><i class="icon-atom"></i><span>icon-atom</span></li>
                                <li><i class="icon-audio-description"></i><span>icon-audio-description</span></li>
                                <li><i class="icon-award"></i><span>icon-award</span></li>
                                <li><i class="icon-backspace"></i><span>icon-backspace</span></li>
                                <li><i class="icon-backward"></i><span>icon-backward</span></li>
                                <li><i class="icon-balance-scale"></i><span>icon-balance-scale</span></li>
                                <li><i class="icon-ban"></i><span>icon-ban</span></li>
                                <li><i class="icon-band-aid"></i><span>icon-band-aid</span></li>
                                <li><i class="icon-barcode"></i><span>icon-barcode</span></li>
                                <li><i class="icon-bars"></i><span>icon-bars</span></li>
                                <li><i class="icon-baseball-ball"></i><span>icon-baseball-ball</span></li>
                                <li><i class="icon-basketball-ball"></i><span>icon-basketball-ball</span></li>
                                <li><i class="icon-bath"></i><span>icon-bath</span></li>
                                <li><i class="icon-battery-empty"></i><span>icon-battery-empty</span></li>
                                <li><i class="icon-battery-full"></i><span>icon-battery-full</span></li>
                                <li><i class="icon-battery-half"></i><span>icon-battery-half</span></li>
                                <li><i class="icon-battery-quarter"></i><span>icon-battery-quarter</span></li>
                                <li><i class="icon-battery-three-quarters"></i><span>icon-battery-three-quarters</span></li>
                                <li><i class="icon-bed"></i><span>icon-bed</span></li>
                                <li><i class="icon-beer"></i><span>icon-beer</span></li>
                                <li><i class="icon-bell-slash"></i><span>icon-bell-slash</span></li>
                                <li><i class="icon-bell"></i><span>icon-bell</span></li>
                                <li><i class="icon-bezier-curve"></i><span>icon-bezier-curve</span></li>
                                <li><i class="icon-bible"></i><span>icon-bible</span></li>
                                <li><i class="icon-bicycle"></i><span>icon-bicycle</span></li>
                                <li><i class="icon-binoculars"></i><span>icon-binoculars</span></li>
                                <li><i class="icon-birthday-cake"></i><span>icon-birthday-cake</span></li>
                                <li><i class="icon-blender"></i><span>icon-blender</span></li>
                                <li><i class="icon-blind"></i><span>icon-blind</span></li>
                                <li><i class="icon-bold"></i><span>icon-bold</span></li>
                                <li><i class="icon-bolt"></i><span>icon-bolt</span></li>
                                <li><i class="icon-bomb"></i><span>icon-bomb</span></li>
                                <li><i class="icon-bone"></i><span>icon-bone</span></li>
                                <li><i class="icon-bong"></i><span>icon-bong</span></li>
                                <li><i class="icon-book-open"></i><span>icon-book-open</span></li>
                                <li><i class="icon-book-reader"></i><span>icon-book-reader</span></li>
                                <li><i class="icon-book"></i><span>icon-book</span></li>
                                <li><i class="icon-bookmark"></i><span>icon-bookmark</span></li>
                                <li><i class="icon-bowling-ball"></i><span>icon-bowling-ball</span></li>
                                <li><i class="icon-box-open"></i><span>icon-box-open</span></li>
                                <li><i class="icon-box"></i><span>icon-box</span></li>
                                <li><i class="icon-boxes"></i><span>icon-boxes</span></li>
                                <li><i class="icon-braille"></i><span>icon-braille</span></li>
                                <li><i class="icon-brain"></i><span>icon-brain</span></li>
                                <li><i class="icon-briefcase-medical"></i><span>icon-briefcase-medical</span></li>
                                <li><i class="icon-briefcase"></i><span>icon-briefcase</span></li>
                                <li><i class="icon-broadcast-tower"></i><span>icon-broadcast-tower</span></li>
                                <li><i class="icon-broom"></i><span>icon-broom</span></li>
                                <li><i class="icon-brush"></i><span>icon-brush</span></li>
                                <li><i class="icon-bug"></i><span>icon-bug</span></li>
                                <li><i class="icon-building"></i><span>icon-building</span></li>
                                <li><i class="icon-bullhorn"></i><span>icon-bullhorn</span></li>
                                <li><i class="icon-bullseye"></i><span>icon-bullseye</span></li>
                                <li><i class="icon-burn"></i><span>icon-burn</span></li>
                                <li><i class="icon-bus-alt"></i><span>icon-bus-alt</span></li>
                                <li><i class="icon-bus"></i><span>icon-bus</span></li>
                                <li><i class="icon-business-time"></i><span>icon-business-time</span></li>
                                <li><i class="icon-calculator"></i><span>icon-calculator</span></li>
                                <li><i class="icon-calendar-alt"></i><span>icon-calendar-alt</span></li>
                                <li><i class="icon-calendar-check"></i><span>icon-calendar-check</span></li>
                                <li><i class="icon-calendar-minus"></i><span>icon-calendar-minus</span></li>
                                <li><i class="icon-calendar-plus"></i><span>icon-calendar-plus</span></li>
                                <li><i class="icon-calendar-times"></i><span>icon-calendar-times</span></li>
                                <li><i class="icon-calendar"></i><span>icon-calendar</span></li>
                                <li><i class="icon-camera-retro"></i><span>icon-camera-retro</span></li>
                                <li><i class="icon-camera"></i><span>icon-camera</span></li>
                                <li><i class="icon-cannabis"></i><span>icon-cannabis</span></li>
                                <li><i class="icon-capsules"></i><span>icon-capsules</span></li>
                                <li><i class="icon-car-alt"></i><span>icon-car-alt</span></li>
                                <li><i class="icon-car-battery"></i><span>icon-car-battery</span></li>
                                <li><i class="icon-car-crash"></i><span>icon-car-crash</span></li>
                                <li><i class="icon-car-side"></i><span>icon-car-side</span></li>
                                <li><i class="icon-car"></i><span>icon-car</span></li>
                                <li><i class="icon-caret-down"></i><span>icon-caret-down</span></li>
                                <li><i class="icon-caret-left"></i><span>icon-caret-left</span></li>
                                <li><i class="icon-caret-right"></i><span>icon-caret-right</span></li>
                                <li><i class="icon-caret-square-down"></i><span>icon-caret-square-down</span></li>
                                <li><i class="icon-caret-square-left"></i><span>icon-caret-square-left</span></li>
                                <li><i class="icon-caret-square-right"></i><span>icon-caret-square-right</span></li>
                                <li><i class="icon-caret-square-up"></i><span>icon-caret-square-up</span></li>
                                <li><i class="icon-caret-up"></i><span>icon-caret-up</span></li>
                                <li><i class="icon-cart-arrow-down"></i><span>icon-cart-arrow-down</span></li>
                                <li><i class="icon-cart-plus"></i><span>icon-cart-plus</span></li>
                                <li><i class="icon-certificate"></i><span>icon-certificate</span></li>
                                <li><i class="icon-chalkboard-teacher"></i><span>icon-chalkboard-teacher</span></li>
                                <li><i class="icon-chalkboard"></i><span>icon-chalkboard</span></li>
                                <li><i class="icon-charging-station"></i><span>icon-charging-station</span></li>
                                <li><i class="icon-chart-area"></i><span>icon-chart-area</span></li>
                                <li><i class="icon-chart-bar"></i><span>icon-chart-bar</span></li>
                                <li><i class="icon-chart-line"></i><span>icon-chart-line</span></li>
                                <li><i class="icon-chart-pie"></i><span>icon-chart-pie</span></li>
                                <li><i class="icon-check-circle"></i><span>icon-check-circle</span></li>
                                <li><i class="icon-check-double"></i><span>icon-check-double</span></li>
                                <li><i class="icon-check-square"></i><span>icon-check-square</span></li>
                                <li><i class="icon-check"></i><span>icon-check</span></li>
                                <li><i class="icon-chess-bishop"></i><span>icon-chess-bishop</span></li>
                                <li><i class="icon-chess-board"></i><span>icon-chess-board</span></li>
                                <li><i class="icon-chess-king"></i><span>icon-chess-king</span></li>
                                <li><i class="icon-chess-knight"></i><span>icon-chess-knight</span></li>
                                <li><i class="icon-chess-pawn"></i><span>icon-chess-pawn</span></li>
                                <li><i class="icon-chess-queen"></i><span>icon-chess-queen</span></li>
                                <li><i class="icon-chess-rook"></i><span>icon-chess-rook</span></li>
                                <li><i class="icon-chess"></i><span>icon-chess</span></li>
                                <li><i class="icon-chevron-circle-down"></i><span>icon-chevron-circle-down</span></li>
                                <li><i class="icon-chevron-circle-left"></i><span>icon-chevron-circle-left</span></li>
                                <li><i class="icon-chevron-circle-right"></i><span>icon-chevron-circle-right</span></li>
                                <li><i class="icon-chevron-circle-up"></i><span>icon-chevron-circle-up</span></li>
                                <li><i class="icon-chevron-down"></i><span>icon-chevron-down</span></li>
                                <li><i class="icon-chevron-left"></i><span>icon-chevron-left</span></li>
                                <li><i class="icon-chevron-right"></i><span>icon-chevron-right</span></li>
                                <li><i class="icon-chevron-up"></i><span>icon-chevron-up</span></li>
                                <li><i class="icon-child"></i><span>icon-child</span></li>
                                <li><i class="icon-church"></i><span>icon-church</span></li>
                                <li><i class="icon-circle-notch"></i><span>icon-circle-notch</span></li>
                                <li><i class="icon-circle"></i><span>icon-circle</span></li>
                                <li><i class="icon-city"></i><span>icon-city</span></li>
                                <li><i class="icon-clipboard-check"></i><span>icon-clipboard-check</span></li>
                                <li><i class="icon-clipboard-list"></i><span>icon-clipboard-list</span></li>
                                <li><i class="icon-clipboard"></i><span>icon-clipboard</span></li>
                                <li><i class="icon-clock"></i><span>icon-clock</span></li>
                                <li><i class="icon-clone"></i><span>icon-clone</span></li>
                                <li><i class="icon-closed-captioning"></i><span>icon-closed-captioning</span></li>
                                <li><i class="icon-cloud-download-alt"></i><span>icon-cloud-download-alt</span></li>
                                <li><i class="icon-cloud-upload-alt"></i><span>icon-cloud-upload-alt</span></li>
                                <li><i class="icon-cloud"></i><span>icon-cloud</span></li>
                                <li><i class="icon-cocktail"></i><span>icon-cocktail</span></li>
                                <li><i class="icon-code-branch"></i><span>icon-code-branch</span></li>
                                <li><i class="icon-code"></i><span>icon-code</span></li>
                                <li><i class="icon-coffee"></i><span>icon-coffee</span></li>
                                <li><i class="icon-cog"></i><span>icon-cog</span></li>
                                <li><i class="icon-cogs"></i><span>icon-cogs</span></li>
                                <li><i class="icon-coins"></i><span>icon-coins</span></li>
                                <li><i class="icon-columns"></i><span>icon-columns</span></li>
                                <li><i class="icon-comment-alt"></i><span>icon-comment-alt</span></li>
                                <li><i class="icon-comment-dollar"></i><span>icon-comment-dollar</span></li>
                                <li><i class="icon-comment-dots"></i><span>icon-comment-dots</span></li>
                                <li><i class="icon-comment-slash"></i><span>icon-comment-slash</span></li>
                                <li><i class="icon-comment"></i><span>icon-comment</span></li>
                                <li><i class="icon-comments-dollar"></i><span>icon-comments-dollar</span></li>
                                <li><i class="icon-comments"></i><span>icon-comments</span></li>
                                <li><i class="icon-compact-disc"></i><span>icon-compact-disc</span></li>
                                <li><i class="icon-compass"></i><span>icon-compass</span></li>
                                <li><i class="icon-compress"></i><span>icon-compress</span></li>
                                <li><i class="icon-concierge-bell"></i><span>icon-concierge-bell</span></li>
                                <li><i class="icon-cookie-bite"></i><span>icon-cookie-bite</span></li>
                                <li><i class="icon-cookie"></i><span>icon-cookie</span></li>
                                <li><i class="icon-copy"></i><span>icon-copy</span></li>
                                <li><i class="icon-copyright"></i><span>icon-copyright</span></li>
                                <li><i class="icon-couch"></i><span>icon-couch</span></li>
                                <li><i class="icon-credit-card"></i><span>icon-credit-card</span></li>
                                <li><i class="icon-crop-alt"></i><span>icon-crop-alt</span></li>
                                <li><i class="icon-crop"></i><span>icon-crop</span></li>
                                <li><i class="icon-cross"></i><span>icon-cross</span></li>
                                <li><i class="icon-crosshairs"></i><span>icon-crosshairs</span></li>
                                <li><i class="icon-crow"></i><span>icon-crow</span></li>
                                <li><i class="icon-crown"></i><span>icon-crown</span></li>
                                <li><i class="icon-cube"></i><span>icon-cube</span></li>
                                <li><i class="icon-cubes"></i><span>icon-cubes</span></li>
                                <li><i class="icon-cut"></i><span>icon-cut</span></li>
                                <li><i class="icon-database"></i><span>icon-database</span></li>
                                <li><i class="icon-deaf"></i><span>icon-deaf</span></li>
                                <li><i class="icon-desktop"></i><span>icon-desktop</span></li>
                                <li><i class="icon-dharmachakra"></i><span>icon-dharmachakra</span></li>
                                <li><i class="icon-diagnoses"></i><span>icon-diagnoses</span></li>
                                <li><i class="icon-dice-five"></i><span>icon-dice-five</span></li>
                                <li><i class="icon-dice-four"></i><span>icon-dice-four</span></li>
                                <li><i class="icon-dice-one"></i><span>icon-dice-one</span></li>
                                <li><i class="icon-dice-six"></i><span>icon-dice-six</span></li>
                                <li><i class="icon-dice-three"></i><span>icon-dice-three</span></li>
                                <li><i class="icon-dice-two"></i><span>icon-dice-two</span></li>
                                <li><i class="icon-dice"></i><span>icon-dice</span></li>
                                <li><i class="icon-digital-tachograph"></i><span>icon-digital-tachograph</span></li>
                                <li><i class="icon-directions"></i><span>icon-directions</span></li>
                                <li><i class="icon-divide"></i><span>icon-divide</span></li>
                                <li><i class="icon-dizzy"></i><span>icon-dizzy</span></li>
                                <li><i class="icon-dna"></i><span>icon-dna</span></li>
                                <li><i class="icon-dollar-sign"></i><span>icon-dollar-sign</span></li>
                                <li><i class="icon-dolly-flatbed"></i><span>icon-dolly-flatbed</span></li>
                                <li><i class="icon-dolly"></i><span>icon-dolly</span></li>
                                <li><i class="icon-donate"></i><span>icon-donate</span></li>
                                <li><i class="icon-door-closed"></i><span>icon-door-closed</span></li>
                                <li><i class="icon-door-open"></i><span>icon-door-open</span></li>
                                <li><i class="icon-dot-circle"></i><span>icon-dot-circle</span></li>
                                <li><i class="icon-dove"></i><span>icon-dove</span></li>
                                <li><i class="icon-download"></i><span>icon-download</span></li>
                                <li><i class="icon-drafting-compass"></i><span>icon-drafting-compass</span></li>
                                <li><i class="icon-draw-polygon"></i><span>icon-draw-polygon</span></li>
                                <li><i class="icon-drum-steelpan"></i><span>icon-drum-steelpan</span></li>
                                <li><i class="icon-drum"></i><span>icon-drum</span></li>
                                <li><i class="icon-dumbbell"></i><span>icon-dumbbell</span></li>
                                <li><i class="icon-edit"></i><span>icon-edit</span></li>
                                <li><i class="icon-eject"></i><span>icon-eject</span></li>
                                <li><i class="icon-ellipsis-h"></i><span>icon-ellipsis-h</span></li>
                                <li><i class="icon-ellipsis-v"></i><span>icon-ellipsis-v</span></li>
                                <li><i class="icon-envelope-open-text"></i><span>icon-envelope-open-text</span></li>
                                <li><i class="icon-envelope-open"></i><span>icon-envelope-open</span></li>
                                <li><i class="icon-envelope-square"></i><span>icon-envelope-square</span></li>
                                <li><i class="icon-envelope"></i><span>icon-envelope</span></li>
                                <li><i class="icon-equals"></i><span>icon-equals</span></li>
                                <li><i class="icon-eraser"></i><span>icon-eraser</span></li>
                                <li><i class="icon-euro-sign"></i><span>icon-euro-sign</span></li>
                                <li><i class="icon-exchange-alt"></i><span>icon-exchange-alt</span></li>
                                <li><i class="icon-exclamation-circle"></i><span>icon-exclamation-circle</span></li>
                                <li><i class="icon-exclamation-triangle"></i><span>icon-exclamation-triangle</span></li>
                                <li><i class="icon-exclamation"></i><span>icon-exclamation</span></li>
                                <li><i class="icon-expand-arrows-alt"></i><span>icon-expand-arrows-alt</span></li>
                                <li><i class="icon-expand"></i><span>icon-expand</span></li>
                                <li><i class="icon-external-link-alt"></i><span>icon-external-link-alt</span></li>
                                <li><i class="icon-external-link-square-alt"></i><span>icon-external-link-square-alt</span></li>
                                <li><i class="icon-eye-dropper"></i><span>icon-eye-dropper</span></li>
                                <li><i class="icon-eye-slash"></i><span>icon-eye-slash</span></li>
                                <li><i class="icon-eye"></i><span>icon-eye</span></li>
                                <li><i class="icon-fast-backward"></i><span>icon-fast-backward</span></li>
                                <li><i class="icon-fast-forward"></i><span>icon-fast-forward</span></li>
                                <li><i class="icon-fax"></i><span>icon-fax</span></li>
                                <li><i class="icon-feather-alt"></i><span>icon-feather-alt</span></li>
                                <li><i class="icon-feather"></i><span>icon-feather</span></li>
                                <li><i class="icon-female"></i><span>icon-female</span></li>
                                <li><i class="icon-fighter-jet"></i><span>icon-fighter-jet</span></li>
                                <li><i class="icon-file-alt"></i><span>icon-file-alt</span></li>
                                <li><i class="icon-file-archive"></i><span>icon-file-archive</span></li>
                                <li><i class="icon-file-audio"></i><span>icon-file-audio</span></li>
                                <li><i class="icon-file-code"></i><span>icon-file-code</span></li>
                                <li><i class="icon-file-contract"></i><span>icon-file-contract</span></li>
                                <li><i class="icon-file-download"></i><span>icon-file-download</span></li>
                                <li><i class="icon-file-excel"></i><span>icon-file-excel</span></li>
                                <li><i class="icon-file-export"></i><span>icon-file-export</span></li>
                                <li><i class="icon-file-image"></i><span>icon-file-image</span></li>
                                <li><i class="icon-file-import"></i><span>icon-file-import</span></li>
                                <li><i class="icon-file-invoice-dollar"></i><span>icon-file-invoice-dollar</span></li>
                                <li><i class="icon-file-invoice"></i><span>icon-file-invoice</span></li>
                                <li><i class="icon-file-medical-alt"></i><span>icon-file-medical-alt</span></li>
                                <li><i class="icon-file-medical"></i><span>icon-file-medical</span></li>
                                <li><i class="icon-file-pdf"></i><span>icon-file-pdf</span></li>
                                <li><i class="icon-file-powerpoint"></i><span>icon-file-powerpoint</span></li>
                                <li><i class="icon-file-prescription"></i><span>icon-file-prescription</span></li>
                                <li><i class="icon-file-signature"></i><span>icon-file-signature</span></li>
                                <li><i class="icon-file-upload"></i><span>icon-file-upload</span></li>
                                <li><i class="icon-file-video"></i><span>icon-file-video</span></li>
                                <li><i class="icon-file-word"></i><span>icon-file-word</span></li>
                                <li><i class="icon-file"></i><span>icon-file</span></li>
                                <li><i class="icon-fill-drip"></i><span>icon-fill-drip</span></li>
                                <li><i class="icon-fill"></i><span>icon-fill</span></li>
                                <li><i class="icon-film"></i><span>icon-film</span></li>
                                <li><i class="icon-filter"></i><span>icon-filter</span></li>
                                <li><i class="icon-fingerprint"></i><span>icon-fingerprint</span></li>
                                <li><i class="icon-fire-extinguisher"></i><span>icon-fire-extinguisher</span></li>
                                <li><i class="icon-fire"></i><span>icon-fire</span></li>
                                <li><i class="icon-first-aid"></i><span>icon-first-aid</span></li>
                                <li><i class="icon-fish"></i><span>icon-fish</span></li>
                                <li><i class="icon-flag-checkered"></i><span>icon-flag-checkered</span></li>
                                <li><i class="icon-flag"></i><span>icon-flag</span></li>
                                <li><i class="icon-flask"></i><span>icon-flask</span></li>
                                <li><i class="icon-flushed"></i><span>icon-flushed</span></li>
                                <li><i class="icon-folder-minus"></i><span>icon-folder-minus</span></li>
                                <li><i class="icon-folder-open"></i><span>icon-folder-open</span></li>
                                <li><i class="icon-folder-plus"></i><span>icon-folder-plus</span></li>
                                <li><i class="icon-folder"></i><span>icon-folder</span></li>
                                <li><i class="icon-font-awesome-logo-full"></i><span>icon-font-awesome-logo-full</span></li>
                                <li><i class="icon-font"></i><span>icon-font</span></li>
                                <li><i class="icon-football-ball"></i><span>icon-football-ball</span></li>
                                <li><i class="icon-forward"></i><span>icon-forward</span></li>
                                <li><i class="icon-frog"></i><span>icon-frog</span></li>
                                <li><i class="icon-frown-open"></i><span>icon-frown-open</span></li>
                                <li><i class="icon-frown"></i><span>icon-frown</span></li>
                                <li><i class="icon-funnel-dollar"></i><span>icon-funnel-dollar</span></li>
                                <li><i class="icon-futbol"></i><span>icon-futbol</span></li>
                                <li><i class="icon-gamepad"></i><span>icon-gamepad</span></li>
                                <li><i class="icon-gas-pump"></i><span>icon-gas-pump</span></li>
                                <li><i class="icon-gavel"></i><span>icon-gavel</span></li>
                                <li><i class="icon-gem"></i><span>icon-gem</span></li>
                                <li><i class="icon-genderless"></i><span>icon-genderless</span></li>
                                <li><i class="icon-gift"></i><span>icon-gift</span></li>
                                <li><i class="icon-glass-martini-alt"></i><span>icon-glass-martini-alt</span></li>
                                <li><i class="icon-glass-martini"></i><span>icon-glass-martini</span></li>
                                <li><i class="icon-glasses"></i><span>icon-glasses</span></li>
                                <li><i class="icon-globe-africa"></i><span>icon-globe-africa</span></li>
                                <li><i class="icon-globe-americas"></i><span>icon-globe-americas</span></li>
                                <li><i class="icon-globe-asia"></i><span>icon-globe-asia</span></li>
                                <li><i class="icon-globe"></i><span>icon-globe</span></li>
                                <li><i class="icon-golf-ball"></i><span>icon-golf-ball</span></li>
                                <li><i class="icon-gopuram"></i><span>icon-gopuram</span></li>
                                <li><i class="icon-graduation-cap"></i><span>icon-graduation-cap</span></li>
                                <li><i class="icon-greater-than-equal"></i><span>icon-greater-than-equal</span></li>
                                <li><i class="icon-greater-than"></i><span>icon-greater-than</span></li>
                                <li><i class="icon-grimace"></i><span>icon-grimace</span></li>
                                <li><i class="icon-grin-alt"></i><span>icon-grin-alt</span></li>
                                <li><i class="icon-grin-beam-sweat"></i><span>icon-grin-beam-sweat</span></li>
                                <li><i class="icon-grin-beam"></i><span>icon-grin-beam</span></li>
                                <li><i class="icon-grin-hearts"></i><span>icon-grin-hearts</span></li>
                                <li><i class="icon-grin-squint-tears"></i><span>icon-grin-squint-tears</span></li>
                                <li><i class="icon-grin-squint"></i><span>icon-grin-squint</span></li>
                                <li><i class="icon-grin-stars"></i><span>icon-grin-stars</span></li>
                                <li><i class="icon-grin-tears"></i><span>icon-grin-tears</span></li>
                                <li><i class="icon-grin-tongue-squint"></i><span>icon-grin-tongue-squint</span></li>
                                <li><i class="icon-grin-tongue-wink"></i><span>icon-grin-tongue-wink</span></li>
                                <li><i class="icon-grin-tongue"></i><span>icon-grin-tongue</span></li>
                                <li><i class="icon-grin-wink"></i><span>icon-grin-wink</span></li>
                                <li><i class="icon-grin"></i><span>icon-grin</span></li>
                                <li><i class="icon-grip-horizontal"></i><span>icon-grip-horizontal</span></li>
                                <li><i class="icon-grip-vertical"></i><span>icon-grip-vertical</span></li>
                                <li><i class="icon-h-square"></i><span>icon-h-square</span></li>
                                <li><i class="icon-hamsa"></i><span>icon-hamsa</span></li>
                                <li><i class="icon-hand-holding-heart"></i><span>icon-hand-holding-heart</span></li>
                                <li><i class="icon-hand-holding-usd"></i><span>icon-hand-holding-usd</span></li>
                                <li><i class="icon-hand-holding"></i><span>icon-hand-holding</span></li>
                                <li><i class="icon-hand-lizard"></i><span>icon-hand-lizard</span></li>
                                <li><i class="icon-hand-paper"></i><span>icon-hand-paper</span></li>
                                <li><i class="icon-hand-peace"></i><span>icon-hand-peace</span></li>
                                <li><i class="icon-hand-point-down"></i><span>icon-hand-point-down</span></li>
                                <li><i class="icon-hand-point-left"></i><span>icon-hand-point-left</span></li>
                                <li><i class="icon-hand-point-right"></i><span>icon-hand-point-right</span></li>
                                <li><i class="icon-hand-point-up"></i><span>icon-hand-point-up</span></li>
                                <li><i class="icon-hand-pointer"></i><span>icon-hand-pointer</span></li>
                                <li><i class="icon-hand-rock"></i><span>icon-hand-rock</span></li>
                                <li><i class="icon-hand-scissors"></i><span>icon-hand-scissors</span></li>
                                <li><i class="icon-hand-spock"></i><span>icon-hand-spock</span></li>
                                <li><i class="icon-hands-helping"></i><span>icon-hands-helping</span></li>
                                <li><i class="icon-hands"></i><span>icon-hands</span></li>
                                <li><i class="icon-handshake"></i><span>icon-handshake</span></li>
                                <li><i class="icon-hashtag"></i><span>icon-hashtag</span></li>
                                <li><i class="icon-haykal"></i><span>icon-haykal</span></li>
                                <li><i class="icon-hdd"></i><span>icon-hdd</span></li>
                                <li><i class="icon-heading"></i><span>icon-heading</span></li>
                                <li><i class="icon-headphones-alt"></i><span>icon-headphones-alt</span></li>
                                <li><i class="icon-headphones"></i><span>icon-headphones</span></li>
                                <li><i class="icon-headset"></i><span>icon-headset</span></li>
                                <li><i class="icon-heart"></i><span>icon-heart</span></li>
                                <li><i class="icon-heartbeat"></i><span>icon-heartbeat</span></li>
                                <li><i class="icon-helicopter"></i><span>icon-helicopter</span></li>
                                <li><i class="icon-highlighter"></i><span>icon-highlighter</span></li>
                                <li><i class="icon-history"></i><span>icon-history</span></li>
                                <li><i class="icon-hockey-puck"></i><span>icon-hockey-puck</span></li>
                                <li><i class="icon-home"></i><span>icon-home</span></li>
                                <li><i class="icon-hospital-alt"></i><span>icon-hospital-alt</span></li>
                                <li><i class="icon-hospital-symbol"></i><span>icon-hospital-symbol</span></li>
                                <li><i class="icon-hospital"></i><span>icon-hospital</span></li>
                                <li><i class="icon-hot-tub"></i><span>icon-hot-tub</span></li>
                                <li><i class="icon-hotel"></i><span>icon-hotel</span></li>
                                <li><i class="icon-hourglass-end"></i><span>icon-hourglass-end</span></li>
                                <li><i class="icon-hourglass-half"></i><span>icon-hourglass-half</span></li>
                                <li><i class="icon-hourglass-start"></i><span>icon-hourglass-start</span></li>
                                <li><i class="icon-hourglass"></i><span>icon-hourglass</span></li>
                                <li><i class="icon-i-cursor"></i><span>icon-i-cursor</span></li>
                                <li><i class="icon-id-badge"></i><span>icon-id-badge</span></li>
                                <li><i class="icon-id-card-alt"></i><span>icon-id-card-alt</span></li>
                                <li><i class="icon-id-card"></i><span>icon-id-card</span></li>
                                <li><i class="icon-image"></i><span>icon-image</span></li>
                                <li><i class="icon-images"></i><span>icon-images</span></li>
                                <li><i class="icon-inbox"></i><span>icon-inbox</span></li>
                                <li><i class="icon-indent"></i><span>icon-indent</span></li>
                                <li><i class="icon-industry"></i><span>icon-industry</span></li>
                                <li><i class="icon-infinity"></i><span>icon-infinity</span></li>
                                <li><i class="icon-info-circle"></i><span>icon-info-circle</span></li>
                                <li><i class="icon-info"></i><span>icon-info</span></li>
                                <li><i class="icon-italic"></i><span>icon-italic</span></li>
                                <li><i class="icon-jedi"></i><span>icon-jedi</span></li>
                                <li><i class="icon-joint"></i><span>icon-joint</span></li>
                                <li><i class="icon-journal-whills"></i><span>icon-journal-whills</span></li>
                                <li><i class="icon-kaaba"></i><span>icon-kaaba</span></li>
                                <li><i class="icon-key"></i><span>icon-key</span></li>
                                <li><i class="icon-keyboard"></i><span>icon-keyboard</span></li>
                                <li><i class="icon-khanda"></i><span>icon-khanda</span></li>
                                <li><i class="icon-kiss-beam"></i><span>icon-kiss-beam</span></li>
                                <li><i class="icon-kiss-wink-heart"></i><span>icon-kiss-wink-heart</span></li>
                                <li><i class="icon-kiss"></i><span>icon-kiss</span></li>
                                <li><i class="icon-kiwi-bird"></i><span>icon-kiwi-bird</span></li>
                                <li><i class="icon-landmark"></i><span>icon-landmark</span></li>
                                <li><i class="icon-language"></i><span>icon-language</span></li>
                                <li><i class="icon-laptop-code"></i><span>icon-laptop-code</span></li>
                                <li><i class="icon-laptop"></i><span>icon-laptop</span></li>
                                <li><i class="icon-laugh-beam"></i><span>icon-laugh-beam</span></li>
                                <li><i class="icon-laugh-squint"></i><span>icon-laugh-squint</span></li>
                                <li><i class="icon-laugh-wink"></i><span>icon-laugh-wink</span></li>
                                <li><i class="icon-laugh"></i><span>icon-laugh</span></li>
                                <li><i class="icon-layer-group"></i><span>icon-layer-group</span></li>
                                <li><i class="icon-leaf"></i><span>icon-leaf</span></li>
                                <li><i class="icon-lemon"></i><span>icon-lemon</span></li>
                                <li><i class="icon-less-than-equal"></i><span>icon-less-than-equal</span></li>
                                <li><i class="icon-less-than"></i><span>icon-less-than</span></li>
                                <li><i class="icon-level-down-alt"></i><span>icon-level-down-alt</span></li>
                                <li><i class="icon-level-up-alt"></i><span>icon-level-up-alt</span></li>
                                <li><i class="icon-life-ring"></i><span>icon-life-ring</span></li>
                                <li><i class="icon-lightbulb"></i><span>icon-lightbulb</span></li>
                                <li><i class="icon-link"></i><span>icon-link</span></li>
                                <li><i class="icon-lira-sign"></i><span>icon-lira-sign</span></li>
                                <li><i class="icon-list-alt"></i><span>icon-list-alt</span></li>
                                <li><i class="icon-list-ol"></i><span>icon-list-ol</span></li>
                                <li><i class="icon-list-ul"></i><span>icon-list-ul</span></li>
                                <li><i class="icon-list"></i><span>icon-list</span></li>
                                <li><i class="icon-location-arrow"></i><span>icon-location-arrow</span></li>
                                <li><i class="icon-lock-open"></i><span>icon-lock-open</span></li>
                                <li><i class="icon-lock"></i><span>icon-lock</span></li>
                                <li><i class="icon-long-arrow-alt-down"></i><span>icon-long-arrow-alt-down</span></li>
                                <li><i class="icon-long-arrow-alt-left"></i><span>icon-long-arrow-alt-left</span></li>
                                <li><i class="icon-long-arrow-alt-right"></i><span>icon-long-arrow-alt-right</span></li>
                                <li><i class="icon-long-arrow-alt-up"></i><span>icon-long-arrow-alt-up</span></li>
                                <li><i class="icon-low-vision"></i><span>icon-low-vision</span></li>
                                <li><i class="icon-luggage-cart"></i><span>icon-luggage-cart</span></li>
                                <li><i class="icon-magic"></i><span>icon-magic</span></li>
                                <li><i class="icon-magnet"></i><span>icon-magnet</span></li>
                                <li><i class="icon-mail-bulk"></i><span>icon-mail-bulk</span></li>
                                <li><i class="icon-male"></i><span>icon-male</span></li>
                                <li><i class="icon-map-marked-alt"></i><span>icon-map-marked-alt</span></li>
                                <li><i class="icon-map-marked"></i><span>icon-map-marked</span></li>
                                <li><i class="icon-map-marker-alt"></i><span>icon-map-marker-alt</span></li>
                                <li><i class="icon-map-marker"></i><span>icon-map-marker</span></li>
                                <li><i class="icon-map-pin"></i><span>icon-map-pin</span></li>
                                <li><i class="icon-map-signs"></i><span>icon-map-signs</span></li>
                                <li><i class="icon-map"></i><span>icon-map</span></li>
                                <li><i class="icon-marker"></i><span>icon-marker</span></li>
                                <li><i class="icon-mars-double"></i><span>icon-mars-double</span></li>
                                <li><i class="icon-mars-stroke-h"></i><span>icon-mars-stroke-h</span></li>
                                <li><i class="icon-mars-stroke-v"></i><span>icon-mars-stroke-v</span></li>
                                <li><i class="icon-mars-stroke"></i><span>icon-mars-stroke</span></li>
                                <li><i class="icon-mars"></i><span>icon-mars</span></li>
                                <li><i class="icon-medal"></i><span>icon-medal</span></li>
                                <li><i class="icon-medkit"></i><span>icon-medkit</span></li>
                                <li><i class="icon-meh-blank"></i><span>icon-meh-blank</span></li>
                                <li><i class="icon-meh-rolling-eyes"></i><span>icon-meh-rolling-eyes</span></li>
                                <li><i class="icon-meh"></i><span>icon-meh</span></li>
                                <li><i class="icon-memory"></i><span>icon-memory</span></li>
                                <li><i class="icon-menorah"></i><span>icon-menorah</span></li>
                                <li><i class="icon-mercury"></i><span>icon-mercury</span></li>
                                <li><i class="icon-microchip"></i><span>icon-microchip</span></li>
                                <li><i class="icon-microphone-alt-slash"></i><span>icon-microphone-alt-slash</span></li>
                                <li><i class="icon-microphone-alt"></i><span>icon-microphone-alt</span></li>
                                <li><i class="icon-microphone-slash"></i><span>icon-microphone-slash</span></li>
                                <li><i class="icon-microphone"></i><span>icon-microphone</span></li>
                                <li><i class="icon-microscope"></i><span>icon-microscope</span></li>
                                <li><i class="icon-minus-circle"></i><span>icon-minus-circle</span></li>
                                <li><i class="icon-minus-square"></i><span>icon-minus-square</span></li>
                                <li><i class="icon-minus"></i><span>icon-minus</span></li>
                                <li><i class="icon-mobile-alt"></i><span>icon-mobile-alt</span></li>
                                <li><i class="icon-mobile"></i><span>icon-mobile</span></li>
                                <li><i class="icon-money-bill-alt"></i><span>icon-money-bill-alt</span></li>
                                <li><i class="icon-money-bill-wave-alt"></i><span>icon-money-bill-wave-alt</span></li>
                                <li><i class="icon-money-bill-wave"></i><span>icon-money-bill-wave</span></li>
                                <li><i class="icon-money-bill"></i><span>icon-money-bill</span></li>
                                <li><i class="icon-money-check-alt"></i><span>icon-money-check-alt</span></li>
                                <li><i class="icon-money-check"></i><span>icon-money-check</span></li>
                                <li><i class="icon-monument"></i><span>icon-monument</span></li>
                                <li><i class="icon-moon"></i><span>icon-moon</span></li>
                                <li><i class="icon-mortar-pestle"></i><span>icon-mortar-pestle</span></li>
                                <li><i class="icon-mosque"></i><span>icon-mosque</span></li>
                                <li><i class="icon-motorcycle"></i><span>icon-motorcycle</span></li>
                                <li><i class="icon-mouse-pointer"></i><span>icon-mouse-pointer</span></li>
                                <li><i class="icon-music"></i><span>icon-music</span></li>
                                <li><i class="icon-neuter"></i><span>icon-neuter</span></li>
                                <li><i class="icon-newspaper"></i><span>icon-newspaper</span></li>
                                <li><i class="icon-not-equal"></i><span>icon-not-equal</span></li>
                                <li><i class="icon-notes-medical"></i><span>icon-notes-medical</span></li>
                                <li><i class="icon-object-group"></i><span>icon-object-group</span></li>
                                <li><i class="icon-object-ungroup"></i><span>icon-object-ungroup</span></li>
                                <li><i class="icon-oil-can"></i><span>icon-oil-can</span></li>
                                <li><i class="icon-om"></i><span>icon-om</span></li>
                                <li><i class="icon-outdent"></i><span>icon-outdent</span></li>
                                <li><i class="icon-paint-brush"></i><span>icon-paint-brush</span></li>
                                <li><i class="icon-paint-roller"></i><span>icon-paint-roller</span></li>
                                <li><i class="icon-palette"></i><span>icon-palette</span></li>
                                <li><i class="icon-pallet"></i><span>icon-pallet</span></li>
                                <li><i class="icon-paper-plane"></i><span>icon-paper-plane</span></li>
                                <li><i class="icon-paperclip"></i><span>icon-paperclip</span></li>
                                <li><i class="icon-parachute-box"></i><span>icon-parachute-box</span></li>
                                <li><i class="icon-paragraph"></i><span>icon-paragraph</span></li>
                                <li><i class="icon-parking"></i><span>icon-parking</span></li>
                                <li><i class="icon-passport"></i><span>icon-passport</span></li>
                                <li><i class="icon-pastafarianism"></i><span>icon-pastafarianism</span></li>
                                <li><i class="icon-paste"></i><span>icon-paste</span></li>
                                <li><i class="icon-pause-circle"></i><span>icon-pause-circle</span></li>
                                <li><i class="icon-pause"></i><span>icon-pause</span></li>
                                <li><i class="icon-paw"></i><span>icon-paw</span></li>
                                <li><i class="icon-peace"></i><span>icon-peace</span></li>
                                <li><i class="icon-pen-alt"></i><span>icon-pen-alt</span></li>
                                <li><i class="icon-pen-fancy"></i><span>icon-pen-fancy</span></li>
                                <li><i class="icon-pen-nib"></i><span>icon-pen-nib</span></li>
                                <li><i class="icon-pen-square"></i><span>icon-pen-square</span></li>
                                <li><i class="icon-pen"></i><span>icon-pen</span></li>
                                <li><i class="icon-pencil-alt"></i><span>icon-pencil-alt</span></li>
                                <li><i class="icon-pencil-ruler"></i><span>icon-pencil-ruler</span></li>
                                <li><i class="icon-people-carry"></i><span>icon-people-carry</span></li>
                                <li><i class="icon-percent"></i><span>icon-percent</span></li>
                                <li><i class="icon-percentage"></i><span>icon-percentage</span></li>
                                <li><i class="icon-phone-slash"></i><span>icon-phone-slash</span></li>
                                <li><i class="icon-phone-square"></i><span>icon-phone-square</span></li>
                                <li><i class="icon-phone-volume"></i><span>icon-phone-volume</span></li>
                                <li><i class="icon-phone"></i><span>icon-phone</span></li>
                                <li><i class="icon-piggy-bank"></i><span>icon-piggy-bank</span></li>
                                <li><i class="icon-pills"></i><span>icon-pills</span></li>
                                <li><i class="icon-place-of-worship"></i><span>icon-place-of-worship</span></li>
                                <li><i class="icon-plane-arrival"></i><span>icon-plane-arrival</span></li>
                                <li><i class="icon-plane-departure"></i><span>icon-plane-departure</span></li>
                                <li><i class="icon-plane"></i><span>icon-plane</span></li>
                                <li><i class="icon-play-circle"></i><span>icon-play-circle</span></li>
                                <li><i class="icon-play"></i><span>icon-play</span></li>
                                <li><i class="icon-plug"></i><span>icon-plug</span></li>
                                <li><i class="icon-plus-circle"></i><span>icon-plus-circle</span></li>
                                <li><i class="icon-plus-square"></i><span>icon-plus-square</span></li>
                                <li><i class="icon-plus"></i><span>icon-plus</span></li>
                                <li><i class="icon-podcast"></i><span>icon-podcast</span></li>
                                <li><i class="icon-poll-h"></i><span>icon-poll-h</span></li>
                                <li><i class="icon-poll"></i><span>icon-poll</span></li>
                                <li><i class="icon-poo"></i><span>icon-poo</span></li>
                                <li><i class="icon-poop"></i><span>icon-poop</span></li>
                                <li><i class="icon-portrait"></i><span>icon-portrait</span></li>
                                <li><i class="icon-pound-sign"></i><span>icon-pound-sign</span></li>
                                <li><i class="icon-power-off"></i><span>icon-power-off</span></li>
                                <li><i class="icon-pray"></i><span>icon-pray</span></li>
                                <li><i class="icon-praying-hands"></i><span>icon-praying-hands</span></li>
                                <li><i class="icon-prescription-bottle-alt"></i><span>icon-prescription-bottle-alt</span></li>
                                <li><i class="icon-prescription-bottle"></i><span>icon-prescription-bottle</span></li>
                                <li><i class="icon-prescription"></i><span>icon-prescription</span></li>
                                <li><i class="icon-print"></i><span>icon-print</span></li>
                                <li><i class="icon-procedures"></i><span>icon-procedures</span></li>
                                <li><i class="icon-project-diagram"></i><span>icon-project-diagram</span></li>
                                <li><i class="icon-puzzle-piece"></i><span>icon-puzzle-piece</span></li>
                                <li><i class="icon-qrcode"></i><span>icon-qrcode</span></li>
                                <li><i class="icon-question-circle"></i><span>icon-question-circle</span></li>
                                <li><i class="icon-question"></i><span>icon-question</span></li>
                                <li><i class="icon-quidditch"></i><span>icon-quidditch</span></li>
                                <li><i class="icon-quote-left"></i><span>icon-quote-left</span></li>
                                <li><i class="icon-quote-right"></i><span>icon-quote-right</span></li>
                                <li><i class="icon-quran"></i><span>icon-quran</span></li>
                                <li><i class="icon-random"></i><span>icon-random</span></li>
                                <li><i class="icon-receipt"></i><span>icon-receipt</span></li>
                                <li><i class="icon-recycle"></i><span>icon-recycle</span></li>
                                <li><i class="icon-redo-alt"></i><span>icon-redo-alt</span></li>
                                <li><i class="icon-redo"></i><span>icon-redo</span></li>
                                <li><i class="icon-registered"></i><span>icon-registered</span></li>
                                <li><i class="icon-reply-all"></i><span>icon-reply-all</span></li>
                                <li><i class="icon-reply"></i><span>icon-reply</span></li>
                                <li><i class="icon-retweet"></i><span>icon-retweet</span></li>
                                <li><i class="icon-ribbon"></i><span>icon-ribbon</span></li>
                                <li><i class="icon-road"></i><span>icon-road</span></li>
                                <li><i class="icon-robot"></i><span>icon-robot</span></li>
                                <li><i class="icon-rocket"></i><span>icon-rocket</span></li>
                                <li><i class="icon-route"></i><span>icon-route</span></li>
                                <li><i class="icon-rss-square"></i><span>icon-rss-square</span></li>
                                <li><i class="icon-rss"></i><span>icon-rss</span></li>
                                <li><i class="icon-ruble-sign"></i><span>icon-ruble-sign</span></li>
                                <li><i class="icon-ruler-combined"></i><span>icon-ruler-combined</span></li>
                                <li><i class="icon-ruler-horizontal"></i><span>icon-ruler-horizontal</span></li>
                                <li><i class="icon-ruler-vertical"></i><span>icon-ruler-vertical</span></li>
                                <li><i class="icon-ruler"></i><span>icon-ruler</span></li>
                                <li><i class="icon-rupee-sign"></i><span>icon-rupee-sign</span></li>
                                <li><i class="icon-sad-cry"></i><span>icon-sad-cry</span></li>
                                <li><i class="icon-sad-tear"></i><span>icon-sad-tear</span></li>
                                <li><i class="icon-save"></i><span>icon-save</span></li>
                                <li><i class="icon-school"></i><span>icon-school</span></li>
                                <li><i class="icon-screwdriver"></i><span>icon-screwdriver</span></li>
                                <li><i class="icon-search-dollar"></i><span>icon-search-dollar</span></li>
                                <li><i class="icon-search-location"></i><span>icon-search-location</span></li>
                                <li><i class="icon-search-minus"></i><span>icon-search-minus</span></li>
                                <li><i class="icon-search-plus"></i><span>icon-search-plus</span></li>
                                <li><i class="icon-search"></i><span>icon-search</span></li>
                                <li><i class="icon-seedling"></i><span>icon-seedling</span></li>
                                <li><i class="icon-server"></i><span>icon-server</span></li>
                                <li><i class="icon-shapes"></i><span>icon-shapes</span></li>
                                <li><i class="icon-share-alt-square"></i><span>icon-share-alt-square</span></li>
                                <li><i class="icon-share-alt"></i><span>icon-share-alt</span></li>
                                <li><i class="icon-share-square"></i><span>icon-share-square</span></li>
                                <li><i class="icon-share"></i><span>icon-share</span></li>
                                <li><i class="icon-shekel-sign"></i><span>icon-shekel-sign</span></li>
                                <li><i class="icon-shield-alt"></i><span>icon-shield-alt</span></li>
                                <li><i class="icon-ship"></i><span>icon-ship</span></li>
                                <li><i class="icon-shipping-fast"></i><span>icon-shipping-fast</span></li>
                                <li><i class="icon-shoe-prints"></i><span>icon-shoe-prints</span></li>
                                <li><i class="icon-shopping-bag"></i><span>icon-shopping-bag</span></li>
                                <li><i class="icon-shopping-basket"></i><span>icon-shopping-basket</span></li>
                                <li><i class="icon-shopping-cart"></i><span>icon-shopping-cart</span></li>
                                <li><i class="icon-shower"></i><span>icon-shower</span></li>
                                <li><i class="icon-shuttle-van"></i><span>icon-shuttle-van</span></li>
                                <li><i class="icon-sign-in-alt"></i><span>icon-sign-in-alt</span></li>
                                <li><i class="icon-sign-language"></i><span>icon-sign-language</span></li>
                                <li><i class="icon-sign-out-alt"></i><span>icon-sign-out-alt</span></li>
                                <li><i class="icon-sign"></i><span>icon-sign</span></li>
                                <li><i class="icon-signal"></i><span>icon-signal</span></li>
                                <li><i class="icon-signature"></i><span>icon-signature</span></li>
                                <li><i class="icon-sitemap"></i><span>icon-sitemap</span></li>
                                <li><i class="icon-skull"></i><span>icon-skull</span></li>
                                <li><i class="icon-sliders-h"></i><span>icon-sliders-h</span></li>
                                <li><i class="icon-smile-beam"></i><span>icon-smile-beam</span></li>
                                <li><i class="icon-smile-wink"></i><span>icon-smile-wink</span></li>
                                <li><i class="icon-smile"></i><span>icon-smile</span></li>
                                <li><i class="icon-smoking-ban"></i><span>icon-smoking-ban</span></li>
                                <li><i class="icon-smoking"></i><span>icon-smoking</span></li>
                                <li><i class="icon-snowflake"></i><span>icon-snowflake</span></li>
                                <li><i class="icon-socks"></i><span>icon-socks</span></li>
                                <li><i class="icon-solar-panel"></i><span>icon-solar-panel</span></li>
                                <li><i class="icon-sort-alpha-down"></i><span>icon-sort-alpha-down</span></li>
                                <li><i class="icon-sort-alpha-up"></i><span>icon-sort-alpha-up</span></li>
                                <li><i class="icon-sort-amount-down"></i><span>icon-sort-amount-down</span></li>
                                <li><i class="icon-sort-amount-up"></i><span>icon-sort-amount-up</span></li>
                                <li><i class="icon-sort-down"></i><span>icon-sort-down</span></li>
                                <li><i class="icon-sort-numeric-down"></i><span>icon-sort-numeric-down</span></li>
                                <li><i class="icon-sort-numeric-up"></i><span>icon-sort-numeric-up</span></li>
                                <li><i class="icon-sort-up"></i><span>icon-sort-up</span></li>
                                <li><i class="icon-sort"></i><span>icon-sort</span></li>
                                <li><i class="icon-spa"></i><span>icon-spa</span></li>
                                <li><i class="icon-space-shuttle"></i><span>icon-space-shuttle</span></li>
                                <li><i class="icon-spinner"></i><span>icon-spinner</span></li>
                                <li><i class="icon-splotch"></i><span>icon-splotch</span></li>
                                <li><i class="icon-spray-can"></i><span>icon-spray-can</span></li>
                                <li><i class="icon-square-full"></i><span>icon-square-full</span></li>
                                <li><i class="icon-square-root-alt"></i><span>icon-square-root-alt</span></li>
                                <li><i class="icon-square"></i><span>icon-square</span></li>
                                <li><i class="icon-stamp"></i><span>icon-stamp</span></li>
                                <li><i class="icon-star-and-crescent"></i><span>icon-star-and-crescent</span></li>
                                <li><i class="icon-star-half-alt"></i><span>icon-star-half-alt</span></li>
                                <li><i class="icon-star-half"></i><span>icon-star-half</span></li>
                                <li><i class="icon-star-of-david"></i><span>icon-star-of-david</span></li>
                                <li><i class="icon-star-of-life"></i><span>icon-star-of-life</span></li>
                                <li><i class="icon-star"></i><span>icon-star</span></li>
                                <li><i class="icon-step-backward"></i><span>icon-step-backward</span></li>
                                <li><i class="icon-step-forward"></i><span>icon-step-forward</span></li>
                                <li><i class="icon-stethoscope"></i><span>icon-stethoscope</span></li>
                                <li><i class="icon-sticky-note"></i><span>icon-sticky-note</span></li>
                                <li><i class="icon-stop-circle"></i><span>icon-stop-circle</span></li>
                                <li><i class="icon-stop"></i><span>icon-stop</span></li>
                                <li><i class="icon-stopwatch"></i><span>icon-stopwatch</span></li>
                                <li><i class="icon-store-alt"></i><span>icon-store-alt</span></li>
                                <li><i class="icon-store"></i><span>icon-store</span></li>
                                <li><i class="icon-stream"></i><span>icon-stream</span></li>
                                <li><i class="icon-street-view"></i><span>icon-street-view</span></li>
                                <li><i class="icon-strikethrough"></i><span>icon-strikethrough</span></li>
                                <li><i class="icon-stroopwafel"></i><span>icon-stroopwafel</span></li>
                                <li><i class="icon-subscript"></i><span>icon-subscript</span></li>
                                <li><i class="icon-subway"></i><span>icon-subway</span></li>
                                <li><i class="icon-suitcase-rolling"></i><span>icon-suitcase-rolling</span></li>
                                <li><i class="icon-suitcase"></i><span>icon-suitcase</span></li>
                                <li><i class="icon-sun"></i><span>icon-sun</span></li>
                                <li><i class="icon-superscript"></i><span>icon-superscript</span></li>
                                <li><i class="icon-surprise"></i><span>icon-surprise</span></li>
                                <li><i class="icon-swatchbook"></i><span>icon-swatchbook</span></li>
                                <li><i class="icon-swimmer"></i><span>icon-swimmer</span></li>
                                <li><i class="icon-swimming-pool"></i><span>icon-swimming-pool</span></li>
                                <li><i class="icon-synagogue"></i><span>icon-synagogue</span></li>
                                <li><i class="icon-sync-alt"></i><span>icon-sync-alt</span></li>
                                <li><i class="icon-sync"></i><span>icon-sync</span></li>
                                <li><i class="icon-syringe"></i><span>icon-syringe</span></li>
                                <li><i class="icon-table-tennis"></i><span>icon-table-tennis</span></li>
                                <li><i class="icon-table"></i><span>icon-table</span></li>
                                <li><i class="icon-tablet-alt"></i><span>icon-tablet-alt</span></li>
                                <li><i class="icon-tablet"></i><span>icon-tablet</span></li>
                                <li><i class="icon-tablets"></i><span>icon-tablets</span></li>
                                <li><i class="icon-tachometer-alt"></i><span>icon-tachometer-alt</span></li>
                                <li><i class="icon-tag"></i><span>icon-tag</span></li>
                                <li><i class="icon-tags"></i><span>icon-tags</span></li>
                                <li><i class="icon-tape"></i><span>icon-tape</span></li>
                                <li><i class="icon-tasks"></i><span>icon-tasks</span></li>
                                <li><i class="icon-taxi"></i><span>icon-taxi</span></li>
                                <li><i class="icon-teeth-open"></i><span>icon-teeth-open</span></li>
                                <li><i class="icon-teeth"></i><span>icon-teeth</span></li>
                                <li><i class="icon-terminal"></i><span>icon-terminal</span></li>
                                <li><i class="icon-text-height"></i><span>icon-text-height</span></li>
                                <li><i class="icon-text-width"></i><span>icon-text-width</span></li>
                                <li><i class="icon-th-large"></i><span>icon-th-large</span></li>
                                <li><i class="icon-th-list"></i><span>icon-th-list</span></li>
                                <li><i class="icon-th"></i><span>icon-th</span></li>
                                <li><i class="icon-theater-masks"></i><span>icon-theater-masks</span></li>
                                <li><i class="icon-thermometer-empty"></i><span>icon-thermometer-empty</span></li>
                                <li><i class="icon-thermometer-full"></i><span>icon-thermometer-full</span></li>
                                <li><i class="icon-thermometer-half"></i><span>icon-thermometer-half</span></li>
                                <li><i class="icon-thermometer-quarter"></i><span>icon-thermometer-quarter</span></li>
                                <li><i class="icon-thermometer-three-quarters"></i><span>icon-thermometer-three-quarters</span></li>
                                <li><i class="icon-thermometer"></i><span>icon-thermometer</span></li>
                                <li><i class="icon-thumbs-down"></i><span>icon-thumbs-down</span></li>
                                <li><i class="icon-thumbs-up"></i><span>icon-thumbs-up</span></li>
                                <li><i class="icon-thumbtack"></i><span>icon-thumbtack</span></li>
                                <li><i class="icon-ticket-alt"></i><span>icon-ticket-alt</span></li>
                                <li><i class="icon-times-circle"></i><span>icon-times-circle</span></li>
                                <li><i class="icon-times"></i><span>icon-times</span></li>
                                <li><i class="icon-tint-slash"></i><span>icon-tint-slash</span></li>
                                <li><i class="icon-tint"></i><span>icon-tint</span></li>
                                <li><i class="icon-tired"></i><span>icon-tired</span></li>
                                <li><i class="icon-toggle-off"></i><span>icon-toggle-off</span></li>
                                <li><i class="icon-toggle-on"></i><span>icon-toggle-on</span></li>
                                <li><i class="icon-toolbox"></i><span>icon-toolbox</span></li>
                                <li><i class="icon-tooth"></i><span>icon-tooth</span></li>
                                <li><i class="icon-torah"></i><span>icon-torah</span></li>
                                <li><i class="icon-torii-gate"></i><span>icon-torii-gate</span></li>
                                <li><i class="icon-trademark"></i><span>icon-trademark</span></li>
                                <li><i class="icon-traffic-light"></i><span>icon-traffic-light</span></li>
                                <li><i class="icon-train"></i><span>icon-train</span></li>
                                <li><i class="icon-transgender-alt"></i><span>icon-transgender-alt</span></li>
                                <li><i class="icon-transgender"></i><span>icon-transgender</span></li>
                                <li><i class="icon-trash-alt"></i><span>icon-trash-alt</span></li>
                                <li><i class="icon-trash"></i><span>icon-trash</span></li>
                                <li><i class="icon-tree"></i><span>icon-tree</span></li>
                                <li><i class="icon-trophy"></i><span>icon-trophy</span></li>
                                <li><i class="icon-truck-loading"></i><span>icon-truck-loading</span></li>
                                <li><i class="icon-truck-monster"></i><span>icon-truck-monster</span></li>
                                <li><i class="icon-truck-moving"></i><span>icon-truck-moving</span></li>
                                <li><i class="icon-truck-pickup"></i><span>icon-truck-pickup</span></li>
                                <li><i class="icon-truck"></i><span>icon-truck</span></li>
                                <li><i class="icon-tshirt"></i><span>icon-tshirt</span></li>
                                <li><i class="icon-tty"></i><span>icon-tty</span></li>
                                <li><i class="icon-tv"></i><span>icon-tv</span></li>
                                <li><i class="icon-umbrella-beach"></i><span>icon-umbrella-beach</span></li>
                                <li><i class="icon-umbrella"></i><span>icon-umbrella</span></li>
                                <li><i class="icon-underline"></i><span>icon-underline</span></li>
                                <li><i class="icon-undo-alt"></i><span>icon-undo-alt</span></li>
                                <li><i class="icon-undo"></i><span>icon-undo</span></li>
                                <li><i class="icon-universal-access"></i><span>icon-universal-access</span></li>
                                <li><i class="icon-university"></i><span>icon-university</span></li>
                                <li><i class="icon-unlink"></i><span>icon-unlink</span></li>
                                <li><i class="icon-unlock-alt"></i><span>icon-unlock-alt</span></li>
                                <li><i class="icon-unlock"></i><span>icon-unlock</span></li>
                                <li><i class="icon-upload"></i><span>icon-upload</span></li>
                                <li><i class="icon-user-alt-slash"></i><span>icon-user-alt-slash</span></li>
                                <li><i class="icon-user-alt"></i><span>icon-user-alt</span></li>
                                <li><i class="icon-user-astronaut"></i><span>icon-user-astronaut</span></li>
                                <li><i class="icon-user-check"></i><span>icon-user-check</span></li>
                                <li><i class="icon-user-circle"></i><span>icon-user-circle</span></li>
                                <li><i class="icon-user-clock"></i><span>icon-user-clock</span></li>
                                <li><i class="icon-user-cog"></i><span>icon-user-cog</span></li>
                                <li><i class="icon-user-edit"></i><span>icon-user-edit</span></li>
                                <li><i class="icon-user-friends"></i><span>icon-user-friends</span></li>
                                <li><i class="icon-user-graduate"></i><span>icon-user-graduate</span></li>
                                <li><i class="icon-user-lock"></i><span>icon-user-lock</span></li>
                                <li><i class="icon-user-md"></i><span>icon-user-md</span></li>
                                <li><i class="icon-user-minus"></i><span>icon-user-minus</span></li>
                                <li><i class="icon-user-ninja"></i><span>icon-user-ninja</span></li>
                                <li><i class="icon-user-plus"></i><span>icon-user-plus</span></li>
                                <li><i class="icon-user-secret"></i><span>icon-user-secret</span></li>
                                <li><i class="icon-user-shield"></i><span>icon-user-shield</span></li>
                                <li><i class="icon-user-slash"></i><span>icon-user-slash</span></li>
                                <li><i class="icon-user-tag"></i><span>icon-user-tag</span></li>
                                <li><i class="icon-user-tie"></i><span>icon-user-tie</span></li>
                                <li><i class="icon-user-times"></i><span>icon-user-times</span></li>
                                <li><i class="icon-user"></i><span>icon-user</span></li>
                                <li><i class="icon-users-cog"></i><span>icon-users-cog</span></li>
                                <li><i class="icon-users"></i><span>icon-users</span></li>
                                <li><i class="icon-utensil-spoon"></i><span>icon-utensil-spoon</span></li>
                                <li><i class="icon-utensils"></i><span>icon-utensils</span></li>
                                <li><i class="icon-vector-square"></i><span>icon-vector-square</span></li>
                                <li><i class="icon-venus-double"></i><span>icon-venus-double</span></li>
                                <li><i class="icon-venus-mars"></i><span>icon-venus-mars</span></li>
                                <li><i class="icon-venus"></i><span>icon-venus</span></li>
                                <li><i class="icon-vial"></i><span>icon-vial</span></li>
                                <li><i class="icon-vials"></i><span>icon-vials</span></li>
                                <li><i class="icon-video-slash"></i><span>icon-video-slash</span></li>
                                <li><i class="icon-video"></i><span>icon-video</span></li>
                                <li><i class="icon-vihara"></i><span>icon-vihara</span></li>
                                <li><i class="icon-volleyball-ball"></i><span>icon-volleyball-ball</span></li>
                                <li><i class="icon-volume-down"></i><span>icon-volume-down</span></li>
                                <li><i class="icon-volume-off"></i><span>icon-volume-off</span></li>
                                <li><i class="icon-volume-up"></i><span>icon-volume-up</span></li>
                                <li><i class="icon-walking"></i><span>icon-walking</span></li>
                                <li><i class="icon-wallet"></i><span>icon-wallet</span></li>
                                <li><i class="icon-warehouse"></i><span>icon-warehouse</span></li>
                                <li><i class="icon-weight-hanging"></i><span>icon-weight-hanging</span></li>
                                <li><i class="icon-weight"></i><span>icon-weight</span></li>
                                <li><i class="icon-wheelchair"></i><span>icon-wheelchair</span></li>
                                <li><i class="icon-wifi"></i><span>icon-wifi</span></li>
                                <li><i class="icon-window-close"></i><span>icon-window-close</span></li>
                                <li><i class="icon-window-maximize"></i><span>icon-window-maximize</span></li>
                                <li><i class="icon-window-minimize"></i><span>icon-window-minimize</span></li>
                                <li><i class="icon-window-restore"></i><span>icon-window-restore</span></li>
                                <li><i class="icon-wine-glass-alt"></i><span>icon-wine-glass-alt</span></li>
                                <li><i class="icon-wine-glass"></i><span>icon-wine-glass</span></li>
                                <li><i class="icon-won-sign"></i><span>icon-won-sign</span></li>
                                <li><i class="icon-wrench"></i><span>icon-wrench</span></li>
                                <li><i class="icon-x-ray"></i><span>icon-x-ray</span></li>
                                <li><i class="icon-yen-sign"></i><span>icon-yen-sign</span></li>
                                <li><i class="icon-yin-yang"></i><span>icon-yin-yang</span></li>
                                <li><i class="icon-address-book1"></i><span>icon-address-book1</span></li>
                                <li><i class="icon-address-card1"></i><span>icon-address-card1</span></li>
                                <li><i class="icon-angry1"></i><span>icon-angry1</span></li>
                                <li><i class="icon-arrow-alt-circle-down1"></i><span>icon-arrow-alt-circle-down1</span></li>
                                <li><i class="icon-arrow-alt-circle-left1"></i><span>icon-arrow-alt-circle-left1</span></li>
                                <li><i class="icon-arrow-alt-circle-right1"></i><span>icon-arrow-alt-circle-right1</span></li>
                                <li><i class="icon-arrow-alt-circle-up1"></i><span>icon-arrow-alt-circle-up1</span></li>
                                <li><i class="icon-bell-slash1"></i><span>icon-bell-slash1</span></li>
                                <li><i class="icon-bell1"></i><span>icon-bell1</span></li>
                                <li><i class="icon-bookmark1"></i><span>icon-bookmark1</span></li>
                                <li><i class="icon-building1"></i><span>icon-building1</span></li>
                                <li><i class="icon-calendar-alt1"></i><span>icon-calendar-alt1</span></li>
                                <li><i class="icon-calendar-check1"></i><span>icon-calendar-check1</span></li>
                                <li><i class="icon-calendar-minus1"></i><span>icon-calendar-minus1</span></li>
                                <li><i class="icon-calendar-plus1"></i><span>icon-calendar-plus1</span></li>
                                <li><i class="icon-calendar-times1"></i><span>icon-calendar-times1</span></li>
                                <li><i class="icon-calendar1"></i><span>icon-calendar1</span></li>
                                <li><i class="icon-caret-square-down1"></i><span>icon-caret-square-down1</span></li>
                                <li><i class="icon-caret-square-left1"></i><span>icon-caret-square-left1</span></li>
                                <li><i class="icon-caret-square-right1"></i><span>icon-caret-square-right1</span></li>
                                <li><i class="icon-caret-square-up1"></i><span>icon-caret-square-up1</span></li>
                                <li><i class="icon-chart-bar1"></i><span>icon-chart-bar1</span></li>
                                <li><i class="icon-check-circle1"></i><span>icon-check-circle1</span></li>
                                <li><i class="icon-check-square1"></i><span>icon-check-square1</span></li>
                                <li><i class="icon-circle1"></i><span>icon-circle1</span></li>
                                <li><i class="icon-clipboard1"></i><span>icon-clipboard1</span></li>
                                <li><i class="icon-clock1"></i><span>icon-clock1</span></li>
                                <li><i class="icon-clone1"></i><span>icon-clone1</span></li>
                                <li><i class="icon-closed-captioning1"></i><span>icon-closed-captioning1</span></li>
                                <li><i class="icon-comment-alt1"></i><span>icon-comment-alt1</span></li>
                                <li><i class="icon-comment-dots1"></i><span>icon-comment-dots1</span></li>
                                <li><i class="icon-comment1"></i><span>icon-comment1</span></li>
                                <li><i class="icon-comments1"></i><span>icon-comments1</span></li>
                                <li><i class="icon-compass1"></i><span>icon-compass1</span></li>
                                <li><i class="icon-copy1"></i><span>icon-copy1</span></li>
                                <li><i class="icon-copyright1"></i><span>icon-copyright1</span></li>
                                <li><i class="icon-credit-card1"></i><span>icon-credit-card1</span></li>
                                <li><i class="icon-dizzy1"></i><span>icon-dizzy1</span></li>
                                <li><i class="icon-dot-circle1"></i><span>icon-dot-circle1</span></li>
                                <li><i class="icon-edit1"></i><span>icon-edit1</span></li>
                                <li><i class="icon-envelope-open1"></i><span>icon-envelope-open1</span></li>
                                <li><i class="icon-envelope1"></i><span>icon-envelope1</span></li>
                                <li><i class="icon-eye-slash1"></i><span>icon-eye-slash1</span></li>
                                <li><i class="icon-eye1"></i><span>icon-eye1</span></li>
                                <li><i class="icon-file-alt1"></i><span>icon-file-alt1</span></li>
                                <li><i class="icon-file-archive1"></i><span>icon-file-archive1</span></li>
                                <li><i class="icon-file-audio1"></i><span>icon-file-audio1</span></li>
                                <li><i class="icon-file-code1"></i><span>icon-file-code1</span></li>
                                <li><i class="icon-file-excel1"></i><span>icon-file-excel1</span></li>
                                <li><i class="icon-file-image1"></i><span>icon-file-image1</span></li>
                                <li><i class="icon-file-pdf1"></i><span>icon-file-pdf1</span></li>
                                <li><i class="icon-file-powerpoint1"></i><span>icon-file-powerpoint1</span></li>
                                <li><i class="icon-file-video1"></i><span>icon-file-video1</span></li>
                                <li><i class="icon-file-word1"></i><span>icon-file-word1</span></li>
                                <li><i class="icon-file1"></i><span>icon-file1</span></li>
                                <li><i class="icon-flag1"></i><span>icon-flag1</span></li>
                                <li><i class="icon-flushed1"></i><span>icon-flushed1</span></li>
                                <li><i class="icon-folder-open1"></i><span>icon-folder-open1</span></li>
                                <li><i class="icon-folder1"></i><span>icon-folder1</span></li>
                                <li><i class="icon-font-awesome-logo-full1"></i><span>icon-font-awesome-logo-full1</span></li>
                                <li><i class="icon-frown-open1"></i><span>icon-frown-open1</span></li>
                                <li><i class="icon-frown1"></i><span>icon-frown1</span></li>
                                <li><i class="icon-futbol1"></i><span>icon-futbol1</span></li>
                                <li><i class="icon-gem1"></i><span>icon-gem1</span></li>
                                <li><i class="icon-grimace1"></i><span>icon-grimace1</span></li>
                                <li><i class="icon-grin-alt1"></i><span>icon-grin-alt1</span></li>
                                <li><i class="icon-grin-beam-sweat1"></i><span>icon-grin-beam-sweat1</span></li>
                                <li><i class="icon-grin-beam1"></i><span>icon-grin-beam1</span></li>
                                <li><i class="icon-grin-hearts1"></i><span>icon-grin-hearts1</span></li>
                                <li><i class="icon-grin-squint-tears1"></i><span>icon-grin-squint-tears1</span></li>
                                <li><i class="icon-grin-squint1"></i><span>icon-grin-squint1</span></li>
                                <li><i class="icon-grin-stars1"></i><span>icon-grin-stars1</span></li>
                                <li><i class="icon-grin-tears1"></i><span>icon-grin-tears1</span></li>
                                <li><i class="icon-grin-tongue-squint1"></i><span>icon-grin-tongue-squint1</span></li>
                                <li><i class="icon-grin-tongue-wink1"></i><span>icon-grin-tongue-wink1</span></li>
                                <li><i class="icon-grin-tongue1"></i><span>icon-grin-tongue1</span></li>
                                <li><i class="icon-grin-wink1"></i><span>icon-grin-wink1</span></li>
                                <li><i class="icon-grin1"></i><span>icon-grin1</span></li>
                                <li><i class="icon-hand-lizard1"></i><span>icon-hand-lizard1</span></li>
                                <li><i class="icon-hand-paper1"></i><span>icon-hand-paper1</span></li>
                                <li><i class="icon-hand-peace1"></i><span>icon-hand-peace1</span></li>
                                <li><i class="icon-hand-point-down1"></i><span>icon-hand-point-down1</span></li>
                                <li><i class="icon-hand-point-left1"></i><span>icon-hand-point-left1</span></li>
                                <li><i class="icon-hand-point-right1"></i><span>icon-hand-point-right1</span></li>
                                <li><i class="icon-hand-point-up1"></i><span>icon-hand-point-up1</span></li>
                                <li><i class="icon-hand-pointer1"></i><span>icon-hand-pointer1</span></li>
                                <li><i class="icon-hand-rock1"></i><span>icon-hand-rock1</span></li>
                                <li><i class="icon-hand-scissors1"></i><span>icon-hand-scissors1</span></li>
                                <li><i class="icon-hand-spock1"></i><span>icon-hand-spock1</span></li>
                                <li><i class="icon-handshake1"></i><span>icon-handshake1</span></li>
                                <li><i class="icon-hdd1"></i><span>icon-hdd1</span></li>
                                <li><i class="icon-heart1"></i><span>icon-heart1</span></li>
                                <li><i class="icon-hospital1"></i><span>icon-hospital1</span></li>
                                <li><i class="icon-hourglass1"></i><span>icon-hourglass1</span></li>
                                <li><i class="icon-id-badge1"></i><span>icon-id-badge1</span></li>
                                <li><i class="icon-id-card1"></i><span>icon-id-card1</span></li>
                                <li><i class="icon-image1"></i><span>icon-image1</span></li>
                                <li><i class="icon-images1"></i><span>icon-images1</span></li>
                                <li><i class="icon-keyboard1"></i><span>icon-keyboard1</span></li>
                                <li><i class="icon-kiss-beam1"></i><span>icon-kiss-beam1</span></li>
                                <li><i class="icon-kiss-wink-heart1"></i><span>icon-kiss-wink-heart1</span></li>
                                <li><i class="icon-kiss1"></i><span>icon-kiss1</span></li>
                                <li><i class="icon-laugh-beam1"></i><span>icon-laugh-beam1</span></li>
                                <li><i class="icon-laugh-squint1"></i><span>icon-laugh-squint1</span></li>
                                <li><i class="icon-laugh-wink1"></i><span>icon-laugh-wink1</span></li>
                                <li><i class="icon-laugh1"></i><span>icon-laugh1</span></li>
                                <li><i class="icon-lemon1"></i><span>icon-lemon1</span></li>
                                <li><i class="icon-life-ring1"></i><span>icon-life-ring1</span></li>
                                <li><i class="icon-lightbulb1"></i><span>icon-lightbulb1</span></li>
                                <li><i class="icon-list-alt1"></i><span>icon-list-alt1</span></li>
                                <li><i class="icon-map1"></i><span>icon-map1</span></li>
                                <li><i class="icon-meh-blank1"></i><span>icon-meh-blank1</span></li>
                                <li><i class="icon-meh-rolling-eyes1"></i><span>icon-meh-rolling-eyes1</span></li>
                                <li><i class="icon-meh1"></i><span>icon-meh1</span></li>
                                <li><i class="icon-minus-square1"></i><span>icon-minus-square1</span></li>
                                <li><i class="icon-money-bill-alt1"></i><span>icon-money-bill-alt1</span></li>
                                <li><i class="icon-moon1"></i><span>icon-moon1</span></li>
                                <li><i class="icon-newspaper1"></i><span>icon-newspaper1</span></li>
                                <li><i class="icon-object-group1"></i><span>icon-object-group1</span></li>
                                <li><i class="icon-object-ungroup1"></i><span>icon-object-ungroup1</span></li>
                                <li><i class="icon-paper-plane1"></i><span>icon-paper-plane1</span></li>
                                <li><i class="icon-pause-circle1"></i><span>icon-pause-circle1</span></li>
                                <li><i class="icon-play-circle1"></i><span>icon-play-circle1</span></li>
                                <li><i class="icon-plus-square1"></i><span>icon-plus-square1</span></li>
                                <li><i class="icon-question-circle1"></i><span>icon-question-circle1</span></li>
                                <li><i class="icon-registered1"></i><span>icon-registered1</span></li>
                                <li><i class="icon-sad-cry1"></i><span>icon-sad-cry1</span></li>
                                <li><i class="icon-sad-tear1"></i><span>icon-sad-tear1</span></li>
                                <li><i class="icon-save1"></i><span>icon-save1</span></li>
                                <li><i class="icon-share-square1"></i><span>icon-share-square1</span></li>
                                <li><i class="icon-smile-beam1"></i><span>icon-smile-beam1</span></li>
                                <li><i class="icon-smile-wink1"></i><span>icon-smile-wink1</span></li>
                                <li><i class="icon-smile1"></i><span>icon-smile1</span></li>
                                <li><i class="icon-snowflake1"></i><span>icon-snowflake1</span></li>
                                <li><i class="icon-square1"></i><span>icon-square1</span></li>
                                <li><i class="icon-star-half1"></i><span>icon-star-half1</span></li>
                                <li><i class="icon-star1"></i><span>icon-star1</span></li>
                                <li><i class="icon-sticky-note1"></i><span>icon-sticky-note1</span></li>
                                <li><i class="icon-stop-circle1"></i><span>icon-stop-circle1</span></li>
                                <li><i class="icon-sun1"></i><span>icon-sun1</span></li>
                                <li><i class="icon-surprise1"></i><span>icon-surprise1</span></li>
                                <li><i class="icon-thumbs-down1"></i><span>icon-thumbs-down1</span></li>
                                <li><i class="icon-thumbs-up1"></i><span>icon-thumbs-up1</span></li>
                                <li><i class="icon-times-circle1"></i><span>icon-times-circle1</span></li>
                                <li><i class="icon-tired1"></i><span>icon-tired1</span></li>
                                <li><i class="icon-trash-alt1"></i><span>icon-trash-alt1</span></li>
                                <li><i class="icon-user-circle1"></i><span>icon-user-circle1</span></li>
                                <li><i class="icon-user1"></i><span>icon-user1</span></li>
                                <li><i class="icon-window-close1"></i><span>icon-window-close1</span></li>
                                <li><i class="icon-window-maximize1"></i><span>icon-window-maximize1</span></li>
                                <li><i class="icon-window-minimize1"></i><span>icon-window-minimize1</span></li>
                                <li><i class="icon-window-restore1"></i><span>icon-window-restore1</span></li>
                                <li><i class="icon-px"></i><span>icon-px</span></li>
                                <li><i class="icon-accessible-icon"></i><span>icon-accessible-icon</span></li>
                                <li><i class="icon-accusoft"></i><span>icon-accusoft</span></li>
                                <li><i class="icon-adn"></i><span>icon-adn</span></li>
                                <li><i class="icon-adversal"></i><span>icon-adversal</span></li>
                                <li><i class="icon-affiliatetheme"></i><span>icon-affiliatetheme</span></li>
                                <li><i class="icon-algolia"></i><span>icon-algolia</span></li>
                                <li><i class="icon-alipay"></i><span>icon-alipay</span></li>
                                <li><i class="icon-amazon-pay"></i><span>icon-amazon-pay</span></li>
                                <li><i class="icon-amazon"></i><span>icon-amazon</span></li>
                                <li><i class="icon-amilia"></i><span>icon-amilia</span></li>
                                <li><i class="icon-android"></i><span>icon-android</span></li>
                                <li><i class="icon-angellist"></i><span>icon-angellist</span></li>
                                <li><i class="icon-angrycreative"></i><span>icon-angrycreative</span></li>
                                <li><i class="icon-angular"></i><span>icon-angular</span></li>
                                <li><i class="icon-app-store-ios"></i><span>icon-app-store-ios</span></li>
                                <li><i class="icon-app-store"></i><span>icon-app-store</span></li>
                                <li><i class="icon-apper"></i><span>icon-apper</span></li>
                                <li><i class="icon-apple-pay"></i><span>icon-apple-pay</span></li>
                                <li><i class="icon-apple"></i><span>icon-apple</span></li>
                                <li><i class="icon-asymmetrik"></i><span>icon-asymmetrik</span></li>
                                <li><i class="icon-audible"></i><span>icon-audible</span></li>
                                <li><i class="icon-autoprefixer"></i><span>icon-autoprefixer</span></li>
                                <li><i class="icon-avianex"></i><span>icon-avianex</span></li>
                                <li><i class="icon-aviato"></i><span>icon-aviato</span></li>
                                <li><i class="icon-aws"></i><span>icon-aws</span></li>
                                <li><i class="icon-bandcamp"></i><span>icon-bandcamp</span></li>
                                <li><i class="icon-behance-square"></i><span>icon-behance-square</span></li>
                                <li><i class="icon-behance"></i><span>icon-behance</span></li>
                                <li><i class="icon-bimobject"></i><span>icon-bimobject</span></li>
                                <li><i class="icon-bitbucket"></i><span>icon-bitbucket</span></li>
                                <li><i class="icon-bitcoin"></i><span>icon-bitcoin</span></li>
                                <li><i class="icon-bity"></i><span>icon-bity</span></li>
                                <li><i class="icon-black-tie"></i><span>icon-black-tie</span></li>
                                <li><i class="icon-blackberry"></i><span>icon-blackberry</span></li>
                                <li><i class="icon-blogger-b"></i><span>icon-blogger-b</span></li>
                                <li><i class="icon-blogger"></i><span>icon-blogger</span></li>
                                <li><i class="icon-bluetooth-b"></i><span>icon-bluetooth-b</span></li>
                                <li><i class="icon-bluetooth"></i><span>icon-bluetooth</span></li>
                                <li><i class="icon-btc"></i><span>icon-btc</span></li>
                                <li><i class="icon-buromobelexperte"></i><span>icon-buromobelexperte</span></li>
                                <li><i class="icon-buysellads"></i><span>icon-buysellads</span></li>
                                <li><i class="icon-cc-amazon-pay"></i><span>icon-cc-amazon-pay</span></li>
                                <li><i class="icon-cc-amex"></i><span>icon-cc-amex</span></li>
                                <li><i class="icon-cc-apple-pay"></i><span>icon-cc-apple-pay</span></li>
                                <li><i class="icon-cc-diners-club"></i><span>icon-cc-diners-club</span></li>
                                <li><i class="icon-cc-discover"></i><span>icon-cc-discover</span></li>
                                <li><i class="icon-cc-jcb"></i><span>icon-cc-jcb</span></li>
                                <li><i class="icon-cc-mastercard"></i><span>icon-cc-mastercard</span></li>
                                <li><i class="icon-cc-paypal"></i><span>icon-cc-paypal</span></li>
                                <li><i class="icon-cc-stripe"></i><span>icon-cc-stripe</span></li>
                                <li><i class="icon-cc-visa"></i><span>icon-cc-visa</span></li>
                                <li><i class="icon-centercode"></i><span>icon-centercode</span></li>
                                <li><i class="icon-chrome"></i><span>icon-chrome</span></li>
                                <li><i class="icon-cloudscale"></i><span>icon-cloudscale</span></li>
                                <li><i class="icon-cloudsmith"></i><span>icon-cloudsmith</span></li>
                                <li><i class="icon-cloudversify"></i><span>icon-cloudversify</span></li>
                                <li><i class="icon-codepen"></i><span>icon-codepen</span></li>
                                <li><i class="icon-codiepie"></i><span>icon-codiepie</span></li>
                                <li><i class="icon-connectdevelop"></i><span>icon-connectdevelop</span></li>
                                <li><i class="icon-contao"></i><span>icon-contao</span></li>
                                <li><i class="icon-cpanel"></i><span>icon-cpanel</span></li>
                                <li><i class="icon-creative-commons-by"></i><span>icon-creative-commons-by</span></li>
                                <li><i class="icon-creative-commons-nc-eu"></i><span>icon-creative-commons-nc-eu</span></li>
                                <li><i class="icon-creative-commons-nc-jp"></i><span>icon-creative-commons-nc-jp</span></li>
                                <li><i class="icon-creative-commons-nc"></i><span>icon-creative-commons-nc</span></li>
                                <li><i class="icon-creative-commons-nd"></i><span>icon-creative-commons-nd</span></li>
                                <li><i class="icon-creative-commons-pd-alt"></i><span>icon-creative-commons-pd-alt</span></li>
                                <li><i class="icon-creative-commons-pd"></i><span>icon-creative-commons-pd</span></li>
                                <li><i class="icon-creative-commons-remix"></i><span>icon-creative-commons-remix</span></li>
                                <li><i class="icon-creative-commons-sa"></i><span>icon-creative-commons-sa</span></li>
                                <li><i class="icon-creative-commons-sampling-plus"></i><span>icon-creative-commons-sampling-plus</span></li>
                                <li><i class="icon-creative-commons-sampling"></i><span>icon-creative-commons-sampling</span></li>
                                <li><i class="icon-creative-commons-share"></i><span>icon-creative-commons-share</span></li>
                                <li><i class="icon-creative-commons"></i><span>icon-creative-commons</span></li>
                                <li><i class="icon-css3-alt"></i><span>icon-css3-alt</span></li>
                                <li><i class="icon-css3"></i><span>icon-css3</span></li>
                                <li><i class="icon-cuttlefish"></i><span>icon-cuttlefish</span></li>
                                <li><i class="icon-d-and-d"></i><span>icon-d-and-d</span></li>
                                <li><i class="icon-dashcube"></i><span>icon-dashcube</span></li>
                                <li><i class="icon-delicious"></i><span>icon-delicious</span></li>
                                <li><i class="icon-deploydog"></i><span>icon-deploydog</span></li>
                                <li><i class="icon-deskpro"></i><span>icon-deskpro</span></li>
                                <li><i class="icon-deviantart"></i><span>icon-deviantart</span></li>
                                <li><i class="icon-digg"></i><span>icon-digg</span></li>
                                <li><i class="icon-digital-ocean"></i><span>icon-digital-ocean</span></li>
                                <li><i class="icon-discord"></i><span>icon-discord</span></li>
                                <li><i class="icon-discourse"></i><span>icon-discourse</span></li>
                                <li><i class="icon-dochub"></i><span>icon-dochub</span></li>
                                <li><i class="icon-docker"></i><span>icon-docker</span></li>
                                <li><i class="icon-draft2digital"></i><span>icon-draft2digital</span></li>
                                <li><i class="icon-dribbble-square"></i><span>icon-dribbble-square</span></li>
                                <li><i class="icon-dribbble"></i><span>icon-dribbble</span></li>
                                <li><i class="icon-dropbox"></i><span>icon-dropbox</span></li>
                                <li><i class="icon-drupal"></i><span>icon-drupal</span></li>
                                <li><i class="icon-dyalog"></i><span>icon-dyalog</span></li>
                                <li><i class="icon-earlybirds"></i><span>icon-earlybirds</span></li>
                                <li><i class="icon-ebay"></i><span>icon-ebay</span></li>
                                <li><i class="icon-edge"></i><span>icon-edge</span></li>
                                <li><i class="icon-elementor"></i><span>icon-elementor</span></li>
                                <li><i class="icon-ello"></i><span>icon-ello</span></li>
                                <li><i class="icon-ember"></i><span>icon-ember</span></li>
                                <li><i class="icon-empire"></i><span>icon-empire</span></li>
                                <li><i class="icon-envira"></i><span>icon-envira</span></li>
                                <li><i class="icon-erlang"></i><span>icon-erlang</span></li>
                                <li><i class="icon-ethereum"></i><span>icon-ethereum</span></li>
                                <li><i class="icon-etsy"></i><span>icon-etsy</span></li>
                                <li><i class="icon-expeditedssl"></i><span>icon-expeditedssl</span></li>
                                <li><i class="icon-facebook-f"></i><span>icon-facebook-f</span></li>
                                <li><i class="icon-facebook-messenger"></i><span>icon-facebook-messenger</span></li>
                                <li><i class="icon-facebook-square"></i><span>icon-facebook-square</span></li>
                                <li><i class="icon-facebook"></i><span>icon-facebook</span></li>
                                <li><i class="icon-firefox"></i><span>icon-firefox</span></li>
                                <li><i class="icon-first-order-alt"></i><span>icon-first-order-alt</span></li>
                                <li><i class="icon-first-order"></i><span>icon-first-order</span></li>
                                <li><i class="icon-firstdraft"></i><span>icon-firstdraft</span></li>
                                <li><i class="icon-flickr"></i><span>icon-flickr</span></li>
                                <li><i class="icon-flipboard"></i><span>icon-flipboard</span></li>
                                <li><i class="icon-fly"></i><span>icon-fly</span></li>
                                <li><i class="icon-font-awesome-alt"></i><span>icon-font-awesome-alt</span></li>
                                <li><i class="icon-font-awesome-flag"></i><span>icon-font-awesome-flag</span></li>
                                <li><i class="icon-font-awesome-logo-full2"></i><span>icon-font-awesome-logo-full2</span></li>
                                <li><i class="icon-font-awesome"></i><span>icon-font-awesome</span></li>
                                <li><i class="icon-fonticons-fi"></i><span>icon-fonticons-fi</span></li>
                                <li><i class="icon-fonticons"></i><span>icon-fonticons</span></li>
                                <li><i class="icon-fort-awesome-alt"></i><span>icon-fort-awesome-alt</span></li>
                                <li><i class="icon-fort-awesome"></i><span>icon-fort-awesome</span></li>
                                <li><i class="icon-forumbee"></i><span>icon-forumbee</span></li>
                                <li><i class="icon-foursquare"></i><span>icon-foursquare</span></li>
                                <li><i class="icon-free-code-camp"></i><span>icon-free-code-camp</span></li>
                                <li><i class="icon-freebsd"></i><span>icon-freebsd</span></li>
                                <li><i class="icon-fulcrum"></i><span>icon-fulcrum</span></li>
                                <li><i class="icon-galactic-republic"></i><span>icon-galactic-republic</span></li>
                                <li><i class="icon-galactic-senate"></i><span>icon-galactic-senate</span></li>
                                <li><i class="icon-get-pocket"></i><span>icon-get-pocket</span></li>
                                <li><i class="icon-gg-circle"></i><span>icon-gg-circle</span></li>
                                <li><i class="icon-gg"></i><span>icon-gg</span></li>
                                <li><i class="icon-git-square"></i><span>icon-git-square</span></li>
                                <li><i class="icon-git"></i><span>icon-git</span></li>
                                <li><i class="icon-github-alt"></i><span>icon-github-alt</span></li>
                                <li><i class="icon-github-square"></i><span>icon-github-square</span></li>
                                <li><i class="icon-github"></i><span>icon-github</span></li>
                                <li><i class="icon-gitkraken"></i><span>icon-gitkraken</span></li>
                                <li><i class="icon-gitlab"></i><span>icon-gitlab</span></li>
                                <li><i class="icon-gitter"></i><span>icon-gitter</span></li>
                                <li><i class="icon-glide-g"></i><span>icon-glide-g</span></li>
                                <li><i class="icon-glide"></i><span>icon-glide</span></li>
                                <li><i class="icon-gofore"></i><span>icon-gofore</span></li>
                                <li><i class="icon-goodreads-g"></i><span>icon-goodreads-g</span></li>
                                <li><i class="icon-goodreads"></i><span>icon-goodreads</span></li>
                                <li><i class="icon-google-drive"></i><span>icon-google-drive</span></li>
                                <li><i class="icon-google-play"></i><span>icon-google-play</span></li>
                                <li><i class="icon-google-plus-g"></i><span>icon-google-plus-g</span></li>
                                <li><i class="icon-google-plus-square"></i><span>icon-google-plus-square</span></li>
                                <li><i class="icon-google-plus"></i><span>icon-google-plus</span></li>
                                <li><i class="icon-google-wallet"></i><span>icon-google-wallet</span></li>
                                <li><i class="icon-google"></i><span>icon-google</span></li>
                                <li><i class="icon-gratipay"></i><span>icon-gratipay</span></li>
                                <li><i class="icon-grav"></i><span>icon-grav</span></li>
                                <li><i class="icon-gripfire"></i><span>icon-gripfire</span></li>
                                <li><i class="icon-grunt"></i><span>icon-grunt</span></li>
                                <li><i class="icon-gulp"></i><span>icon-gulp</span></li>
                                <li><i class="icon-hacker-news-square"></i><span>icon-hacker-news-square</span></li>
                                <li><i class="icon-hacker-news"></i><span>icon-hacker-news</span></li>
                                <li><i class="icon-hackerrank"></i><span>icon-hackerrank</span></li>
                                <li><i class="icon-hips"></i><span>icon-hips</span></li>
                                <li><i class="icon-hire-a-helper"></i><span>icon-hire-a-helper</span></li>
                                <li><i class="icon-hooli"></i><span>icon-hooli</span></li>
                                <li><i class="icon-hornbill"></i><span>icon-hornbill</span></li>
                                <li><i class="icon-hotjar"></i><span>icon-hotjar</span></li>
                                <li><i class="icon-houzz"></i><span>icon-houzz</span></li>
                                <li><i class="icon-html5"></i><span>icon-html5</span></li>
                                <li><i class="icon-hubspot"></i><span>icon-hubspot</span></li>
                                <li><i class="icon-imdb"></i><span>icon-imdb</span></li>
                                <li><i class="icon-instagram"></i><span>icon-instagram</span></li>
                                <li><i class="icon-internet-explorer"></i><span>icon-internet-explorer</span></li>
                                <li><i class="icon-ioxhost"></i><span>icon-ioxhost</span></li>
                                <li><i class="icon-itunes-note"></i><span>icon-itunes-note</span></li>
                                <li><i class="icon-itunes"></i><span>icon-itunes</span></li>
                                <li><i class="icon-java"></i><span>icon-java</span></li>
                                <li><i class="icon-jedi-order"></i><span>icon-jedi-order</span></li>
                                <li><i class="icon-jenkins"></i><span>icon-jenkins</span></li>
                                <li><i class="icon-joget"></i><span>icon-joget</span></li>
                                <li><i class="icon-joomla"></i><span>icon-joomla</span></li>
                                <li><i class="icon-js-square"></i><span>icon-js-square</span></li>
                                <li><i class="icon-js"></i><span>icon-js</span></li>
                                <li><i class="icon-jsfiddle"></i><span>icon-jsfiddle</span></li>
                                <li><i class="icon-kaggle"></i><span>icon-kaggle</span></li>
                                <li><i class="icon-keybase"></i><span>icon-keybase</span></li>
                                <li><i class="icon-keycdn"></i><span>icon-keycdn</span></li>
                                <li><i class="icon-kickstarter-k"></i><span>icon-kickstarter-k</span></li>
                                <li><i class="icon-kickstarter"></i><span>icon-kickstarter</span></li>
                                <li><i class="icon-korvue"></i><span>icon-korvue</span></li>
                                <li><i class="icon-laravel"></i><span>icon-laravel</span></li>
                                <li><i class="icon-lastfm-square"></i><span>icon-lastfm-square</span></li>
                                <li><i class="icon-lastfm"></i><span>icon-lastfm</span></li>
                                <li><i class="icon-leanpub"></i><span>icon-leanpub</span></li>
                                <li><i class="icon-less"></i><span>icon-less</span></li>
                                <li><i class="icon-line"></i><span>icon-line</span></li>
                                <li><i class="icon-linkedin-in"></i><span>icon-linkedin-in</span></li>
                                <li><i class="icon-linkedin"></i><span>icon-linkedin</span></li>
                                <li><i class="icon-linode"></i><span>icon-linode</span></li>
                                <li><i class="icon-linux"></i><span>icon-linux</span></li>
                                <li><i class="icon-lyft"></i><span>icon-lyft</span></li>
                                <li><i class="icon-magento"></i><span>icon-magento</span></li>
                                <li><i class="icon-mailchimp"></i><span>icon-mailchimp</span></li>
                                <li><i class="icon-mandalorian"></i><span>icon-mandalorian</span></li>
                                <li><i class="icon-markdown"></i><span>icon-markdown</span></li>
                                <li><i class="icon-mastodon"></i><span>icon-mastodon</span></li>
                                <li><i class="icon-maxcdn"></i><span>icon-maxcdn</span></li>
                                <li><i class="icon-medapps"></i><span>icon-medapps</span></li>
                                <li><i class="icon-medium-m"></i><span>icon-medium-m</span></li>
                                <li><i class="icon-medium"></i><span>icon-medium</span></li>
                                <li><i class="icon-medrt"></i><span>icon-medrt</span></li>
                                <li><i class="icon-meetup"></i><span>icon-meetup</span></li>
                                <li><i class="icon-megaport"></i><span>icon-megaport</span></li>
                                <li><i class="icon-microsoft"></i><span>icon-microsoft</span></li>
                                <li><i class="icon-mix"></i><span>icon-mix</span></li>
                                <li><i class="icon-mixcloud"></i><span>icon-mixcloud</span></li>
                                <li><i class="icon-mizuni"></i><span>icon-mizuni</span></li>
                                <li><i class="icon-modx"></i><span>icon-modx</span></li>
                                <li><i class="icon-monero"></i><span>icon-monero</span></li>
                                <li><i class="icon-napster"></i><span>icon-napster</span></li>
                                <li><i class="icon-neos"></i><span>icon-neos</span></li>
                                <li><i class="icon-nimblr"></i><span>icon-nimblr</span></li>
                                <li><i class="icon-nintendo-switch"></i><span>icon-nintendo-switch</span></li>
                                <li><i class="icon-node-js"></i><span>icon-node-js</span></li>
                                <li><i class="icon-node"></i><span>icon-node</span></li>
                                <li><i class="icon-npm"></i><span>icon-npm</span></li>
                                <li><i class="icon-ns8"></i><span>icon-ns8</span></li>
                                <li><i class="icon-nutritionix"></i><span>icon-nutritionix</span></li>
                                <li><i class="icon-odnoklassniki-square"></i><span>icon-odnoklassniki-square</span></li>
                                <li><i class="icon-odnoklassniki"></i><span>icon-odnoklassniki</span></li>
                                <li><i class="icon-old-republic"></i><span>icon-old-republic</span></li>
                                <li><i class="icon-opencart"></i><span>icon-opencart</span></li>
                                <li><i class="icon-openid"></i><span>icon-openid</span></li>
                                <li><i class="icon-opera"></i><span>icon-opera</span></li>
                                <li><i class="icon-optin-monster"></i><span>icon-optin-monster</span></li>
                                <li><i class="icon-osi"></i><span>icon-osi</span></li>
                                <li><i class="icon-page4"></i><span>icon-page4</span></li>
                                <li><i class="icon-pagelines"></i><span>icon-pagelines</span></li>
                                <li><i class="icon-palfed"></i><span>icon-palfed</span></li>
                                <li><i class="icon-patreon"></i><span>icon-patreon</span></li>
                                <li><i class="icon-paypal"></i><span>icon-paypal</span></li>
                                <li><i class="icon-periscope"></i><span>icon-periscope</span></li>
                                <li><i class="icon-phabricator"></i><span>icon-phabricator</span></li>
                                <li><i class="icon-phoenix-framework"></i><span>icon-phoenix-framework</span></li>
                                <li><i class="icon-phoenix-squadron"></i><span>icon-phoenix-squadron</span></li>
                                <li><i class="icon-php"></i><span>icon-php</span></li>
                                <li><i class="icon-pied-piper-alt"></i><span>icon-pied-piper-alt</span></li>
                                <li><i class="icon-pied-piper-hat"></i><span>icon-pied-piper-hat</span></li>
                                <li><i class="icon-pied-piper-pp"></i><span>icon-pied-piper-pp</span></li>
                                <li><i class="icon-pied-piper"></i><span>icon-pied-piper</span></li>
                                <li><i class="icon-pinterest-p"></i><span>icon-pinterest-p</span></li>
                                <li><i class="icon-pinterest-square"></i><span>icon-pinterest-square</span></li>
                                <li><i class="icon-pinterest"></i><span>icon-pinterest</span></li>
                                <li><i class="icon-playstation"></i><span>icon-playstation</span></li>
                                <li><i class="icon-product-hunt"></i><span>icon-product-hunt</span></li>
                                <li><i class="icon-pushed"></i><span>icon-pushed</span></li>
                                <li><i class="icon-python"></i><span>icon-python</span></li>
                                <li><i class="icon-qq"></i><span>icon-qq</span></li>
                                <li><i class="icon-quinscape"></i><span>icon-quinscape</span></li>
                                <li><i class="icon-quora"></i><span>icon-quora</span></li>
                                <li><i class="icon-r-project"></i><span>icon-r-project</span></li>
                                <li><i class="icon-ravelry"></i><span>icon-ravelry</span></li>
                                <li><i class="icon-react"></i><span>icon-react</span></li>
                                <li><i class="icon-readme"></i><span>icon-readme</span></li>
                                <li><i class="icon-rebel"></i><span>icon-rebel</span></li>
                                <li><i class="icon-red-river"></i><span>icon-red-river</span></li>
                                <li><i class="icon-reddit-alien"></i><span>icon-reddit-alien</span></li>
                                <li><i class="icon-reddit-square"></i><span>icon-reddit-square</span></li>
                                <li><i class="icon-reddit"></i><span>icon-reddit</span></li>
                                <li><i class="icon-rendact"></i><span>icon-rendact</span></li>
                                <li><i class="icon-renren"></i><span>icon-renren</span></li>
                                <li><i class="icon-replyd"></i><span>icon-replyd</span></li>
                                <li><i class="icon-researchgate"></i><span>icon-researchgate</span></li>
                                <li><i class="icon-resolving"></i><span>icon-resolving</span></li>
                                <li><i class="icon-rev"></i><span>icon-rev</span></li>
                                <li><i class="icon-rocketchat"></i><span>icon-rocketchat</span></li>
                                <li><i class="icon-rockrms"></i><span>icon-rockrms</span></li>
                                <li><i class="icon-safari"></i><span>icon-safari</span></li>
                                <li><i class="icon-sass"></i><span>icon-sass</span></li>
                                <li><i class="icon-schlix"></i><span>icon-schlix</span></li>
                                <li><i class="icon-scribd"></i><span>icon-scribd</span></li>
                                <li><i class="icon-searchengin"></i><span>icon-searchengin</span></li>
                                <li><i class="icon-sellcast"></i><span>icon-sellcast</span></li>
                                <li><i class="icon-sellsy"></i><span>icon-sellsy</span></li>
                                <li><i class="icon-servicestack"></i><span>icon-servicestack</span></li>
                                <li><i class="icon-shirtsinbulk"></i><span>icon-shirtsinbulk</span></li>
                                <li><i class="icon-shopware"></i><span>icon-shopware</span></li>
                                <li><i class="icon-simplybuilt"></i><span>icon-simplybuilt</span></li>
                                <li><i class="icon-sistrix"></i><span>icon-sistrix</span></li>
                                <li><i class="icon-sith"></i><span>icon-sith</span></li>
                                <li><i class="icon-skyatlas"></i><span>icon-skyatlas</span></li>
                                <li><i class="icon-skype"></i><span>icon-skype</span></li>
                                <li><i class="icon-slack-hash"></i><span>icon-slack-hash</span></li>
                                <li><i class="icon-slack"></i><span>icon-slack</span></li>
                                <li><i class="icon-slideshare"></i><span>icon-slideshare</span></li>
                                <li><i class="icon-snapchat-ghost"></i><span>icon-snapchat-ghost</span></li>
                                <li><i class="icon-snapchat-square"></i><span>icon-snapchat-square</span></li>
                                <li><i class="icon-snapchat"></i><span>icon-snapchat</span></li>
                                <li><i class="icon-soundcloud"></i><span>icon-soundcloud</span></li>
                                <li><i class="icon-speakap"></i><span>icon-speakap</span></li>
                                <li><i class="icon-spotify"></i><span>icon-spotify</span></li>
                                <li><i class="icon-squarespace"></i><span>icon-squarespace</span></li>
                                <li><i class="icon-stack-exchange"></i><span>icon-stack-exchange</span></li>
                                <li><i class="icon-stack-overflow"></i><span>icon-stack-overflow</span></li>
                                <li><i class="icon-staylinked"></i><span>icon-staylinked</span></li>
                                <li><i class="icon-steam-square"></i><span>icon-steam-square</span></li>
                                <li><i class="icon-steam-symbol"></i><span>icon-steam-symbol</span></li>
                                <li><i class="icon-steam"></i><span>icon-steam</span></li>
                                <li><i class="icon-sticker-mule"></i><span>icon-sticker-mule</span></li>
                                <li><i class="icon-strava"></i><span>icon-strava</span></li>
                                <li><i class="icon-stripe-s"></i><span>icon-stripe-s</span></li>
                                <li><i class="icon-stripe"></i><span>icon-stripe</span></li>
                                <li><i class="icon-studiovinari"></i><span>icon-studiovinari</span></li>
                                <li><i class="icon-stumbleupon-circle"></i><span>icon-stumbleupon-circle</span></li>
                                <li><i class="icon-stumbleupon"></i><span>icon-stumbleupon</span></li>
                                <li><i class="icon-superpowers"></i><span>icon-superpowers</span></li>
                                <li><i class="icon-supple"></i><span>icon-supple</span></li>
                                <li><i class="icon-teamspeak"></i><span>icon-teamspeak</span></li>
                                <li><i class="icon-telegram-plane"></i><span>icon-telegram-plane</span></li>
                                <li><i class="icon-telegram"></i><span>icon-telegram</span></li>
                                <li><i class="icon-tencent-weibo"></i><span>icon-tencent-weibo</span></li>
                                <li><i class="icon-the-red-yeti"></i><span>icon-the-red-yeti</span></li>
                                <li><i class="icon-themeco"></i><span>icon-themeco</span></li>
                                <li><i class="icon-themeisle"></i><span>icon-themeisle</span></li>
                                <li><i class="icon-trade-federation"></i><span>icon-trade-federation</span></li>
                                <li><i class="icon-trello"></i><span>icon-trello</span></li>
                                <li><i class="icon-tripadvisor"></i><span>icon-tripadvisor</span></li>
                                <li><i class="icon-tumblr-square"></i><span>icon-tumblr-square</span></li>
                                <li><i class="icon-tumblr"></i><span>icon-tumblr</span></li>
                                <li><i class="icon-twitch"></i><span>icon-twitch</span></li>
                                <li><i class="icon-twitter-square"></i><span>icon-twitter-square</span></li>
                                <li><i class="icon-twitter"></i><span>icon-twitter</span></li>
                                <li><i class="icon-typo3"></i><span>icon-typo3</span></li>
                                <li><i class="icon-uber"></i><span>icon-uber</span></li>
                                <li><i class="icon-uikit"></i><span>icon-uikit</span></li>
                                <li><i class="icon-uniregistry"></i><span>icon-uniregistry</span></li>
                                <li><i class="icon-untappd"></i><span>icon-untappd</span></li>
                                <li><i class="icon-usb"></i><span>icon-usb</span></li>
                                <li><i class="icon-ussunnah"></i><span>icon-ussunnah</span></li>
                                <li><i class="icon-vaadin"></i><span>icon-vaadin</span></li>
                                <li><i class="icon-viacoin"></i><span>icon-viacoin</span></li>
                                <li><i class="icon-viadeo-square"></i><span>icon-viadeo-square</span></li>
                                <li><i class="icon-viadeo"></i><span>icon-viadeo</span></li>
                                <li><i class="icon-viber"></i><span>icon-viber</span></li>
                                <li><i class="icon-vimeo-square"></i><span>icon-vimeo-square</span></li>
                                <li><i class="icon-vimeo-v"></i><span>icon-vimeo-v</span></li>
                                <li><i class="icon-vimeo"></i><span>icon-vimeo</span></li>
                                <li><i class="icon-vine"></i><span>icon-vine</span></li>
                                <li><i class="icon-vk"></i><span>icon-vk</span></li>
                                <li><i class="icon-vnv"></i><span>icon-vnv</span></li>
                                <li><i class="icon-vuejs"></i><span>icon-vuejs</span></li>
                                <li><i class="icon-weebly"></i><span>icon-weebly</span></li>
                                <li><i class="icon-weibo"></i><span>icon-weibo</span></li>
                                <li><i class="icon-weixin"></i><span>icon-weixin</span></li>
                                <li><i class="icon-whatsapp-square"></i><span>icon-whatsapp-square</span></li>
                                <li><i class="icon-whatsapp"></i><span>icon-whatsapp</span></li>
                                <li><i class="icon-whmcs"></i><span>icon-whmcs</span></li>
                                <li><i class="icon-wikipedia-w"></i><span>icon-wikipedia-w</span></li>
                                <li><i class="icon-windows"></i><span>icon-windows</span></li>
                                <li><i class="icon-wix"></i><span>icon-wix</span></li>
                                <li><i class="icon-wolf-pack-battalion"></i><span>icon-wolf-pack-battalion</span></li>
                                <li><i class="icon-wordpress-simple"></i><span>icon-wordpress-simple</span></li>
                                <li><i class="icon-wordpress"></i><span>icon-wordpress</span></li>
                                <li><i class="icon-wpbeginner"></i><span>icon-wpbeginner</span></li>
                                <li><i class="icon-wpexplorer"></i><span>icon-wpexplorer</span></li>
                                <li><i class="icon-wpforms"></i><span>icon-wpforms</span></li>
                                <li><i class="icon-xbox"></i><span>icon-xbox</span></li>
                                <li><i class="icon-xing-square"></i><span>icon-xing-square</span></li>
                                <li><i class="icon-xing"></i><span>icon-xing</span></li>
                                <li><i class="icon-y-combinator"></i><span>icon-y-combinator</span></li>
                                <li><i class="icon-yahoo"></i><span>icon-yahoo</span></li>
                                <li><i class="icon-yandex-international"></i><span>icon-yandex-international</span></li>
                                <li><i class="icon-yandex"></i><span>icon-yandex</span></li>
                                <li><i class="icon-yelp"></i><span>icon-yelp</span></li>
                                <li><i class="icon-yoast"></i><span>icon-yoast</span></li>
                                <li><i class="icon-youtube-square"></i><span>icon-youtube-square</span></li>
                                <li><i class="icon-youtube"></i><span>icon-youtube</span></li>
                                <li><i class="icon-zhihu"></i><span>icon-zhihu</span></li>
                                <li><i class="icon-deezer"></i><span>icon-deezer</span></li>
                                <li><i class="icon-edge-legacy"></i><span>icon-edge-legacy</span></li>
                                <li><i class="icon-google-pay"></i><span>icon-google-pay</span></li>
                                <li><i class="icon-google-plus"></i><span>icon-google-plus</span></li>
                                <li><i class="icon-rust"></i><span>icon-rust</span></li>
                                <li><i class="icon-tiktok"></i><span>icon-tiktok</span></li>
                                <li><i class="icon-tripadvisor"></i><span>icon-tripadvisor</span></li>
                                <li><i class="icon-unsplash"></i><span>icon-unsplash</span></li>
                                <li><i class="icon-yahoo"></i><span>icon-yahoo</span></li>
                                <li><i class="icon-box-tissue"></i><span>icon-box-tissue</span></li>
                                <li><i class="icon-hand-holding-medical"></i><span>icon-hand-holding-medical</span></li>
                                <li><i class="icon-hand-holding-water"></i><span>icon-hand-holding-water</span></li>
                                <li><i class="icon-hand-sparkles"></i><span>icon-hand-sparkles</span></li>
                                <li><i class="icon-hands-wash"></i><span>icon-hands-wash</span></li>
                                <li><i class="icon-handshake-alt-slash"></i><span>icon-handshake-alt-slash</span></li>
                                <li><i class="icon-handshake-slash"></i><span>icon-handshake-slash</span></li>
                                <li><i class="icon-head-side-cough-slash"></i><span>icon-head-side-cough-slash</span></li>
                                <li><i class="icon-head-side-cough"></i><span>icon-head-side-cough</span></li>
                                <li><i class="icon-head-side-mask"></i><span>icon-head-side-mask</span></li>
                                <li><i class="icon-head-side-virus"></i><span>icon-head-side-virus</span></li>
                                <li><i class="icon-house-user"></i><span>icon-house-user</span></li>
                                <li><i class="icon-laptop-house"></i><span>icon-laptop-house</span></li>
                                <li><i class="icon-lungs-virus"></i><span>icon-lungs-virus</span></li>
                                <li><i class="icon-people-arrows"></i><span>icon-people-arrows</span></li>
                                <li><i class="icon-plane-slash"></i><span>icon-plane-slash</span></li>
                                <li><i class="icon-pump-medical"></i><span>icon-pump-medical</span></li>
                                <li><i class="icon-pump-soap"></i><span>icon-pump-soap</span></li>
                                <li><i class="icon-shield-virus"></i><span>icon-shield-virus</span></li>
                                <li><i class="icon-sink"></i><span>icon-sink</span></li>
                                <li><i class="icon-socks"></i><span>icon-socks</span></li>
                                <li><i class="icon-stopwatch-20"></i><span>icon-stopwatch-20</span></li>
                                <li><i class="icon-store-alt-slash"></i><span>icon-store-alt-slash</span></li>
                                <li><i class="icon-store-slash"></i><span>icon-store-slash</span></li>
                                <li><i class="icon-toilet-paper-slash"></i><span>icon-toilet-paper-slash</span></li>
                                <li><i class="icon-users-slash"></i><span>icon-users-slash</span></li>
                                <li><i class="icon-virus-slash"></i><span>icon-virus-slash</span></li>
                                <li><i class="icon-virus"></i><span>icon-virus</span></li>
                                <li><i class="icon-viruses"></i><span>icon-viruses</span></li>
                                <li><i class="icon-bandcamp"></i><span>icon-bandcamp</span></li>
                                <li><i class="icon-bacteria"></i><span>icon-bacteria</span></li>
                                <li><i class="icon-bacterium"></i><span>icon-bacterium</span></li>
                                <li><i class="icon-line2-user-female"></i><span>icon-line2-user-female</span></li>
                                <li><i class="icon-line2-user-follow"></i><span>icon-line2-user-follow</span></li>
                                <li><i class="icon-line2-user-following"></i><span>icon-line2-user-following</span></li>
                                <li><i class="icon-line2-user-unfollow"></i><span>icon-line2-user-unfollow</span></li>
                                <li><i class="icon-line2-trophy"></i><span>icon-line2-trophy</span></li>
                                <li><i class="icon-line2-screen-smartphone"></i><span>icon-line2-screen-smartphone</span></li>
                                <li><i class="icon-line2-screen-desktop"></i><span>icon-line2-screen-desktop</span></li>
                                <li><i class="icon-line2-plane"></i><span>icon-line2-plane</span></li>
                                <li><i class="icon-line2-notebook"></i><span>icon-line2-notebook</span></li>
                                <li><i class="icon-line2-moustache"></i><span>icon-line2-moustache</span></li>
                                <li><i class="icon-line2-mouse"></i><span>icon-line2-mouse</span></li>
                                <li><i class="icon-line2-magnet"></i><span>icon-line2-magnet</span></li>
                                <li><i class="icon-line2-energy"></i><span>icon-line2-energy</span></li>
                                <li><i class="icon-line2-emoticon-smile"></i><span>icon-line2-emoticon-smile</span></li>
                                <li><i class="icon-line2-disc"></i><span>icon-line2-disc</span></li>
                                <li><i class="icon-line2-cursor-move"></i><span>icon-line2-cursor-move</span></li>
                                <li><i class="icon-line2-crop"></i><span>icon-line2-crop</span></li>
                                <li><i class="icon-line2-credit-card"></i><span>icon-line2-credit-card</span></li>
                                <li><i class="icon-line2-chemistry"></i><span>icon-line2-chemistry</span></li>
                                <li><i class="icon-line2-user"></i><span>icon-line2-user</span></li>
                                <li><i class="icon-line2-speedometer"></i><span>icon-line2-speedometer</span></li>
                                <li><i class="icon-line2-social-youtube"></i><span>icon-line2-social-youtube</span></li>
                                <li><i class="icon-line2-social-twitter"></i><span>icon-line2-social-twitter</span></li>
                                <li><i class="icon-line2-social-tumblr"></i><span>icon-line2-social-tumblr</span></li>
                                <li><i class="icon-line2-social-facebook"></i><span>icon-line2-social-facebook</span></li>
                                <li><i class="icon-line2-social-dropbox"></i><span>icon-line2-social-dropbox</span></li>
                                <li><i class="icon-line2-social-dribbble"></i><span>icon-line2-social-dribbble</span></li>
                                <li><i class="icon-line2-shield"></i><span>icon-line2-shield</span></li>
                                <li><i class="icon-line2-screen-tablet"></i><span>icon-line2-screen-tablet</span></li>
                                <li><i class="icon-line2-magic-wand"></i><span>icon-line2-magic-wand</span></li>
                                <li><i class="icon-line2-hourglass"></i><span>icon-line2-hourglass</span></li>
                                <li><i class="icon-line2-graduation"></i><span>icon-line2-graduation</span></li>
                                <li><i class="icon-line2-ghost"></i><span>icon-line2-ghost</span></li>
                                <li><i class="icon-line2-game-controller"></i><span>icon-line2-game-controller</span></li>
                                <li><i class="icon-line2-fire"></i><span>icon-line2-fire</span></li>
                                <li><i class="icon-line2-eyeglasses"></i><span>icon-line2-eyeglasses</span></li>
                                <li><i class="icon-line2-envelope-open"></i><span>icon-line2-envelope-open</span></li>
                                <li><i class="icon-line2-envelope-letter"></i><span>icon-line2-envelope-letter</span></li>
                                <li><i class="icon-line2-bell"></i><span>icon-line2-bell</span></li>
                                <li><i class="icon-line2-badge"></i><span>icon-line2-badge</span></li>
                                <li><i class="icon-line2-anchor"></i><span>icon-line2-anchor</span></li>
                                <li><i class="icon-line2-wallet"></i><span>icon-line2-wallet</span></li>
                                <li><i class="icon-line2-vector"></i><span>icon-line2-vector</span></li>
                                <li><i class="icon-line2-speech"></i><span>icon-line2-speech</span></li>
                                <li><i class="icon-line2-puzzle"></i><span>icon-line2-puzzle</span></li>
                                <li><i class="icon-line2-printer"></i><span>icon-line2-printer</span></li>
                                <li><i class="icon-line2-present"></i><span>icon-line2-present</span></li>
                                <li><i class="icon-line2-playlist"></i><span>icon-line2-playlist</span></li>
                                <li><i class="icon-line2-pin"></i><span>icon-line2-pin</span></li>
                                <li><i class="icon-line2-picture"></i><span>icon-line2-picture</span></li>
                                <li><i class="icon-line2-map"></i><span>icon-line2-map</span></li>
                                <li><i class="icon-line2-layers"></i><span>icon-line2-layers</span></li>
                                <li><i class="icon-line2-handbag"></i><span>icon-line2-handbag</span></li>
                                <li><i class="icon-line2-globe-alt"></i><span>icon-line2-globe-alt</span></li>
                                <li><i class="icon-line2-globe"></i><span>icon-line2-globe</span></li>
                                <li><i class="icon-line2-frame"></i><span>icon-line2-frame</span></li>
                                <li><i class="icon-line2-folder-alt"></i><span>icon-line2-folder-alt</span></li>
                                <li><i class="icon-line2-film"></i><span>icon-line2-film</span></li>
                                <li><i class="icon-line2-feed"></i><span>icon-line2-feed</span></li>
                                <li><i class="icon-line2-earphones-alt"></i><span>icon-line2-earphones-alt</span></li>
                                <li><i class="icon-line2-earphones"></i><span>icon-line2-earphones</span></li>
                                <li><i class="icon-line2-drop"></i><span>icon-line2-drop</span></li>
                                <li><i class="icon-line2-drawer"></i><span>icon-line2-drawer</span></li>
                                <li><i class="icon-line2-docs"></i><span>icon-line2-docs</span></li>
                                <li><i class="icon-line2-directions"></i><span>icon-line2-directions</span></li>
                                <li><i class="icon-line2-direction"></i><span>icon-line2-direction</span></li>
                                <li><i class="icon-line2-diamond"></i><span>icon-line2-diamond</span></li>
                                <li><i class="icon-line2-cup"></i><span>icon-line2-cup</span></li>
                                <li><i class="icon-line2-compass"></i><span>icon-line2-compass</span></li>
                                <li><i class="icon-line2-call-out"></i><span>icon-line2-call-out</span></li>
                                <li><i class="icon-line2-call-in"></i><span>icon-line2-call-in</span></li>
                                <li><i class="icon-line2-call-end"></i><span>icon-line2-call-end</span></li>
                                <li><i class="icon-line2-calculator"></i><span>icon-line2-calculator</span></li>
                                <li><i class="icon-line2-bubbles"></i><span>icon-line2-bubbles</span></li>
                                <li><i class="icon-line2-briefcase"></i><span>icon-line2-briefcase</span></li>
                                <li><i class="icon-line2-book-open"></i><span>icon-line2-book-open</span></li>
                                <li><i class="icon-line2-basket-loaded"></i><span>icon-line2-basket-loaded</span></li>
                                <li><i class="icon-line2-basket"></i><span>icon-line2-basket</span></li>
                                <li><i class="icon-line2-bag"></i><span>icon-line2-bag</span></li>
                                <li><i class="icon-line2-action-undo"></i><span>icon-line2-action-undo</span></li>
                                <li><i class="icon-line2-action-redo"></i><span>icon-line2-action-redo</span></li>
                                <li><i class="icon-line2-wrench"></i><span>icon-line2-wrench</span></li>
                                <li><i class="icon-line2-umbrella"></i><span>icon-line2-umbrella</span></li>
                                <li><i class="icon-line2-trash"></i><span>icon-line2-trash</span></li>
                                <li><i class="icon-line2-tag"></i><span>icon-line2-tag</span></li>
                                <li><i class="icon-line2-support"></i><span>icon-line2-support</span></li>
                                <li><i class="icon-line2-size-fullscreen"></i><span>icon-line2-size-fullscreen</span></li>
                                <li><i class="icon-line2-size-actual"></i><span>icon-line2-size-actual</span></li>
                                <li><i class="icon-line2-shuffle"></i><span>icon-line2-shuffle</span></li>
                                <li><i class="icon-line2-share-alt"></i><span>icon-line2-share-alt</span></li>
                                <li><i class="icon-line2-share"></i><span>icon-line2-share</span></li>
                                <li><i class="icon-line2-rocket"></i><span>icon-line2-rocket</span></li>
                                <li><i class="icon-line2-question"></i><span>icon-line2-question</span></li>
                                <li><i class="icon-line2-pie-chart"></i><span>icon-line2-pie-chart</span></li>
                                <li><i class="icon-line2-pencil"></i><span>icon-line2-pencil</span></li>
                                <li><i class="icon-line2-note"></i><span>icon-line2-note</span></li>
                                <li><i class="icon-line2-music-tone-alt"></i><span>icon-line2-music-tone-alt</span></li>
                                <li><i class="icon-line2-music-tone"></i><span>icon-line2-music-tone</span></li>
                                <li><i class="icon-line2-microphone"></i><span>icon-line2-microphone</span></li>
                                <li><i class="icon-line2-loop"></i><span>icon-line2-loop</span></li>
                                <li><i class="icon-line2-logout"></i><span>icon-line2-logout</span></li>
                                <li><i class="icon-line2-login"></i><span>icon-line2-login</span></li>
                                <li><i class="icon-line2-list"></i><span>icon-line2-list</span></li>
                                <li><i class="icon-line2-like"></i><span>icon-line2-like</span></li>
                                <li><i class="icon-line2-home"></i><span>icon-line2-home</span></li>
                                <li><i class="icon-line2-grid"></i><span>icon-line2-grid</span></li>
                                <li><i class="icon-line2-graph"></i><span>icon-line2-graph</span></li>
                                <li><i class="icon-line2-equalizer"></i><span>icon-line2-equalizer</span></li>
                                <li><i class="icon-line2-dislike"></i><span>icon-line2-dislike</span></li>
                                <li><i class="icon-line2-cursor"></i><span>icon-line2-cursor</span></li>
                                <li><i class="icon-line2-control-start"></i><span>icon-line2-control-start</span></li>
                                <li><i class="icon-line2-control-rewind"></i><span>icon-line2-control-rewind</span></li>
                                <li><i class="icon-line2-control-play"></i><span>icon-line2-control-play</span></li>
                                <li><i class="icon-line2-control-pause"></i><span>icon-line2-control-pause</span></li>
                                <li><i class="icon-line2-control-forward"></i><span>icon-line2-control-forward</span></li>
                                <li><i class="icon-line2-control-end"></i><span>icon-line2-control-end</span></li>
                                <li><i class="icon-line2-calendar"></i><span>icon-line2-calendar</span></li>
                                <li><i class="icon-line2-bulb"></i><span>icon-line2-bulb</span></li>
                                <li><i class="icon-line2-bar-chart"></i><span>icon-line2-bar-chart</span></li>
                                <li><i class="icon-line2-arrow-up"></i><span>icon-line2-arrow-up</span></li>
                                <li><i class="icon-line2-arrow-right"></i><span>icon-line2-arrow-right</span></li>
                                <li><i class="icon-line2-arrow-left"></i><span>icon-line2-arrow-left</span></li>
                                <li><i class="icon-line2-arrow-down"></i><span>icon-line2-arrow-down</span></li>
                                <li><i class="icon-line2-ban"></i><span>icon-line2-ban</span></li>
                                <li><i class="icon-line2-bubble"></i><span>icon-line2-bubble</span></li>
                                <li><i class="icon-line2-camcorder"></i><span>icon-line2-camcorder</span></li>
                                <li><i class="icon-line2-camera"></i><span>icon-line2-camera</span></li>
                                <li><i class="icon-line2-check"></i><span>icon-line2-check</span></li>
                                <li><i class="icon-line2-clock"></i><span>icon-line2-clock</span></li>
                                <li><i class="icon-line2-close"></i><span>icon-line2-close</span></li>
                                <li><i class="icon-line2-cloud-download"></i><span>icon-line2-cloud-download</span></li>
                                <li><i class="icon-line2-cloud-upload"></i><span>icon-line2-cloud-upload</span></li>
                                <li><i class="icon-line2-doc"></i><span>icon-line2-doc</span></li>
                                <li><i class="icon-line2-envelope"></i><span>icon-line2-envelope</span></li>
                                <li><i class="icon-line2-eye"></i><span>icon-line2-eye</span></li>
                                <li><i class="icon-line2-flag"></i><span>icon-line2-flag</span></li>
                                <li><i class="icon-line2-folder"></i><span>icon-line2-folder</span></li>
                                <li><i class="icon-line2-heart"></i><span>icon-line2-heart</span></li>
                                <li><i class="icon-line2-info"></i><span>icon-line2-info</span></li>
                                <li><i class="icon-line2-key"></i><span>icon-line2-key</span></li>
                                <li><i class="icon-line2-link"></i><span>icon-line2-link</span></li>
                                <li><i class="icon-line2-lock"></i><span>icon-line2-lock</span></li>
                                <li><i class="icon-line2-lock-open"></i><span>icon-line2-lock-open</span></li>
                                <li><i class="icon-line2-magnifier"></i><span>icon-line2-magnifier</span></li>
                                <li><i class="icon-line2-magnifier-add"></i><span>icon-line2-magnifier-add</span></li>
                                <li><i class="icon-line2-magnifier-remove"></i><span>icon-line2-magnifier-remove</span></li>
                                <li><i class="icon-line2-paper-clip"></i><span>icon-line2-paper-clip</span></li>
                                <li><i class="icon-line2-paper-plane"></i><span>icon-line2-paper-plane</span></li>
                                <li><i class="icon-line2-plus"></i><span>icon-line2-plus</span></li>
                                <li><i class="icon-line2-pointer"></i><span>icon-line2-pointer</span></li>
                                <li><i class="icon-line2-power"></i><span>icon-line2-power</span></li>
                                <li><i class="icon-line2-refresh"></i><span>icon-line2-refresh</span></li>
                                <li><i class="icon-line2-reload"></i><span>icon-line2-reload</span></li>
                                <li><i class="icon-line2-settings"></i><span>icon-line2-settings</span></li>
                                <li><i class="icon-line2-star"></i><span>icon-line2-star</span></li>
                                <li><i class="icon-line2-symbol-female"></i><span>icon-line2-symbol-female</span></li>
                                <li><i class="icon-line2-symbol-male"></i><span>icon-line2-symbol-male</span></li>
                                <li><i class="icon-line2-target"></i><span>icon-line2-target</span></li>
                                <li><i class="icon-line2-volume-1"></i><span>icon-line2-volume-1</span></li>
                                <li><i class="icon-line2-volume-2"></i><span>icon-line2-volume-2</span></li>
                                <li><i class="icon-line2-volume-off"></i><span>icon-line2-volume-off</span></li>
                                <li><i class="icon-line2-users"></i><span>icon-line2-users</span></li>
                                <li><i class="icon-et-mobile"></i><span>icon-et-mobile</span></li>
                                <li><i class="icon-et-laptop"></i><span>icon-et-laptop</span></li>
                                <li><i class="icon-et-desktop"></i><span>icon-et-desktop</span></li>
                                <li><i class="icon-et-tablet"></i><span>icon-et-tablet</span></li>
                                <li><i class="icon-et-phone"></i><span>icon-et-phone</span></li>
                                <li><i class="icon-et-document"></i><span>icon-et-document</span></li>
                                <li><i class="icon-et-documents"></i><span>icon-et-documents</span></li>
                                <li><i class="icon-et-search"></i><span>icon-et-search</span></li>
                                <li><i class="icon-et-clipboard"></i><span>icon-et-clipboard</span></li>
                                <li><i class="icon-et-newspaper"></i><span>icon-et-newspaper</span></li>
                                <li><i class="icon-et-notebook"></i><span>icon-et-notebook</span></li>
                                <li><i class="icon-et-book-open"></i><span>icon-et-book-open</span></li>
                                <li><i class="icon-et-browser"></i><span>icon-et-browser</span></li>
                                <li><i class="icon-et-calendar"></i><span>icon-et-calendar</span></li>
                                <li><i class="icon-et-presentation"></i><span>icon-et-presentation</span></li>
                                <li><i class="icon-et-picture"></i><span>icon-et-picture</span></li>
                                <li><i class="icon-et-pictures"></i><span>icon-et-pictures</span></li>
                                <li><i class="icon-et-video"></i><span>icon-et-video</span></li>
                                <li><i class="icon-et-camera"></i><span>icon-et-camera</span></li>
                                <li><i class="icon-et-printer"></i><span>icon-et-printer</span></li>
                                <li><i class="icon-et-toolbox"></i><span>icon-et-toolbox</span></li>
                                <li><i class="icon-et-briefcase"></i><span>icon-et-briefcase</span></li>
                                <li><i class="icon-et-wallet"></i><span>icon-et-wallet</span></li>
                                <li><i class="icon-et-gift"></i><span>icon-et-gift</span></li>
                                <li><i class="icon-et-bargraph"></i><span>icon-et-bargraph</span></li>
                                <li><i class="icon-et-grid"></i><span>icon-et-grid</span></li>
                                <li><i class="icon-et-expand"></i><span>icon-et-expand</span></li>
                                <li><i class="icon-et-focus"></i><span>icon-et-focus</span></li>
                                <li><i class="icon-et-edit"></i><span>icon-et-edit</span></li>
                                <li><i class="icon-et-adjustments"></i><span>icon-et-adjustments</span></li>
                                <li><i class="icon-et-ribbon"></i><span>icon-et-ribbon</span></li>
                                <li><i class="icon-et-hourglass"></i><span>icon-et-hourglass</span></li>
                                <li><i class="icon-et-lock"></i><span>icon-et-lock</span></li>
                                <li><i class="icon-et-megaphone"></i><span>icon-et-megaphone</span></li>
                                <li><i class="icon-et-shield"></i><span>icon-et-shield</span></li>
                                <li><i class="icon-et-trophy"></i><span>icon-et-trophy</span></li>
                                <li><i class="icon-et-flag"></i><span>icon-et-flag</span></li>
                                <li><i class="icon-et-map"></i><span>icon-et-map</span></li>
                                <li><i class="icon-et-puzzle"></i><span>icon-et-puzzle</span></li>
                                <li><i class="icon-et-basket"></i><span>icon-et-basket</span></li>
                                <li><i class="icon-et-envelope"></i><span>icon-et-envelope</span></li>
                                <li><i class="icon-et-streetsign"></i><span>icon-et-streetsign</span></li>
                                <li><i class="icon-et-telescope"></i><span>icon-et-telescope</span></li>
                                <li><i class="icon-et-gears"></i><span>icon-et-gears</span></li>
                                <li><i class="icon-et-key"></i><span>icon-et-key</span></li>
                                <li><i class="icon-et-paperclip"></i><span>icon-et-paperclip</span></li>
                                <li><i class="icon-et-attachment"></i><span>icon-et-attachment</span></li>
                                <li><i class="icon-et-pricetags"></i><span>icon-et-pricetags</span></li>
                                <li><i class="icon-et-lightbulb"></i><span>icon-et-lightbulb</span></li>
                                <li><i class="icon-et-layers"></i><span>icon-et-layers</span></li>
                                <li><i class="icon-et-pencil"></i><span>icon-et-pencil</span></li>
                                <li><i class="icon-et-tools"></i><span>icon-et-tools</span></li>
                                <li><i class="icon-et-tools-2"></i><span>icon-et-tools-2</span></li>
                                <li><i class="icon-et-scissors"></i><span>icon-et-scissors</span></li>
                                <li><i class="icon-et-paintbrush"></i><span>icon-et-paintbrush</span></li>
                                <li><i class="icon-et-magnifying-glass"></i><span>icon-et-magnifying-glass</span></li>
                                <li><i class="icon-et-circle-compass"></i><span>icon-et-circle-compass</span></li>
                                <li><i class="icon-et-linegraph"></i><span>icon-et-linegraph</span></li>
                                <li><i class="icon-et-mic"></i><span>icon-et-mic</span></li>
                                <li><i class="icon-et-strategy"></i><span>icon-et-strategy</span></li>
                                <li><i class="icon-et-beaker"></i><span>icon-et-beaker</span></li>
                                <li><i class="icon-et-caution"></i><span>icon-et-caution</span></li>
                                <li><i class="icon-et-recycle"></i><span>icon-et-recycle</span></li>
                                <li><i class="icon-et-anchor"></i><span>icon-et-anchor</span></li>
                                <li><i class="icon-et-profile-male"></i><span>icon-et-profile-male</span></li>
                                <li><i class="icon-et-profile-female"></i><span>icon-et-profile-female</span></li>
                                <li><i class="icon-et-bike"></i><span>icon-et-bike</span></li>
                                <li><i class="icon-et-wine"></i><span>icon-et-wine</span></li>
                                <li><i class="icon-et-hotairballoon"></i><span>icon-et-hotairballoon</span></li>
                                <li><i class="icon-et-globe"></i><span>icon-et-globe</span></li>
                                <li><i class="icon-et-genius"></i><span>icon-et-genius</span></li>
                                <li><i class="icon-et-map-pin"></i><span>icon-et-map-pin</span></li>
                                <li><i class="icon-et-dial"></i><span>icon-et-dial</span></li>
                                <li><i class="icon-et-chat"></i><span>icon-et-chat</span></li>
                                <li><i class="icon-et-heart"></i><span>icon-et-heart</span></li>
                                <li><i class="icon-et-cloud"></i><span>icon-et-cloud</span></li>
                                <li><i class="icon-et-upload"></i><span>icon-et-upload</span></li>
                                <li><i class="icon-et-download"></i><span>icon-et-download</span></li>
                                <li><i class="icon-et-target"></i><span>icon-et-target</span></li>
                                <li><i class="icon-et-hazardous"></i><span>icon-et-hazardous</span></li>
                                <li><i class="icon-et-piechart"></i><span>icon-et-piechart</span></li>
                                <li><i class="icon-et-speedometer"></i><span>icon-et-speedometer</span></li>
                                <li><i class="icon-et-global"></i><span>icon-et-global</span></li>
                                <li><i class="icon-et-compass"></i><span>icon-et-compass</span></li>
                                <li><i class="icon-et-lifesaver"></i><span>icon-et-lifesaver</span></li>
                                <li><i class="icon-et-clock"></i><span>icon-et-clock</span></li>
                                <li><i class="icon-et-aperture"></i><span>icon-et-aperture</span></li>
                                <li><i class="icon-et-quote"></i><span>icon-et-quote</span></li>
                                <li><i class="icon-et-scope"></i><span>icon-et-scope</span></li>
                                <li><i class="icon-et-alarmclock"></i><span>icon-et-alarmclock</span></li>
                                <li><i class="icon-et-refresh"></i><span>icon-et-refresh</span></li>
                                <li><i class="icon-et-happy"></i><span>icon-et-happy</span></li>
                                <li><i class="icon-et-sad"></i><span>icon-et-sad</span></li>
                                <li><i class="icon-et-facebook"></i><span>icon-et-facebook</span></li>
                                <li><i class="icon-et-twitter"></i><span>icon-et-twitter</span></li>
                                <li><i class="icon-et-googleplus"></i><span>icon-et-googleplus</span></li>
                                <li><i class="icon-et-rss"></i><span>icon-et-rss</span></li>
                                <li><i class="icon-et-tumblr"></i><span>icon-et-tumblr</span></li>
                                <li><i class="icon-et-linkedin"></i><span>icon-et-linkedin</span></li>
                                <li><i class="icon-et-dribbble"></i><span>icon-et-dribbble</span></li>
                                <li><i class="icon-medical-i-womens-health"></i><span>icon-medical-i-womens-health</span></li>
                                <li><i class="icon-medical-i-waiting-area"></i><span>icon-medical-i-waiting-area</span></li>
                                <li><i class="icon-medical-i-volume-control"></i><span>icon-medical-i-volume-control</span></li>
                                <li><i class="icon-medical-i-ultrasound"></i><span>icon-medical-i-ultrasound</span></li>
                                <li><i class="icon-medical-i-text-telephone"></i><span>icon-medical-i-text-telephone</span></li>
                                <li><i class="icon-medical-i-surgery"></i><span>icon-medical-i-surgery</span></li>
                                <li><i class="icon-medical-i-stairs"></i><span>icon-medical-i-stairs</span></li>
                                <li><i class="icon-medical-i-radiology"></i><span>icon-medical-i-radiology</span></li>
                                <li><i class="icon-medical-i-physical-therapy"></i><span>icon-medical-i-physical-therapy</span></li>
                                <li><i class="icon-medical-i-pharmacy"></i><span>icon-medical-i-pharmacy</span></li>
                                <li><i class="icon-medical-i-pediatrics"></i><span>icon-medical-i-pediatrics</span></li>
                                <li><i class="icon-medical-i-pathology"></i><span>icon-medical-i-pathology</span></li>
                                <li><i class="icon-medical-i-outpatient"></i><span>icon-medical-i-outpatient</span></li>
                                <li><i class="icon-medical-i-mental-health"></i><span>icon-medical-i-mental-health</span></li>
                                <li><i class="icon-medical-i-medical-records"></i><span>icon-medical-i-medical-records</span></li>
                                <li><i class="icon-medical-i-medical-library"></i><span>icon-medical-i-medical-library</span></li>
                                <li><i class="icon-medical-i-mammography"></i><span>icon-medical-i-mammography</span></li>
                                <li><i class="icon-medical-i-laboratory"></i><span>icon-medical-i-laboratory</span></li>
                                <li><i class="icon-medical-i-labor-delivery"></i><span>icon-medical-i-labor-delivery</span></li>
                                <li><i class="icon-medical-i-immunizations"></i><span>icon-medical-i-immunizations</span></li>
                                <li><i class="icon-medical-i-imaging-root-category"></i><span>icon-medical-i-imaging-root-category</span></li>
                                <li><i class="icon-medical-i-imaging-alternative-pet"></i><span>icon-medical-i-imaging-alternative-pet</span></li>
                                <li><i class="icon-medical-i-imaging-alternative-mri"></i><span>icon-medical-i-imaging-alternative-mri</span></li>
                                <li><i class="icon-medical-i-imaging-alternative-mri-two"></i><span>icon-medical-i-imaging-alternative-mri-two</span></li>
                                <li><i class="icon-medical-i-imaging-alternative-ct"></i><span>icon-medical-i-imaging-alternative-ct</span></li>
                                <li><i class="icon-medical-i-fire-extinguisher"></i><span>icon-medical-i-fire-extinguisher</span></li>
                                <li><i class="icon-medical-i-family-practice"></i><span>icon-medical-i-family-practice</span></li>
                                <li><i class="icon-medical-i-emergency"></i><span>icon-medical-i-emergency</span></li>
                                <li><i class="icon-medical-i-elevators"></i><span>icon-medical-i-elevators</span></li>
                                <li><i class="icon-medical-i-ear-nose-throat"></i><span>icon-medical-i-ear-nose-throat</span></li>
                                <li><i class="icon-medical-i-drinking-fountain"></i><span>icon-medical-i-drinking-fountain</span></li>
                                <li><i class="icon-medical-i-cardiology"></i><span>icon-medical-i-cardiology</span></li>
                                <li><i class="icon-medical-i-billing"></i><span>icon-medical-i-billing</span></li>
                                <li><i class="icon-medical-i-anesthesia"></i><span>icon-medical-i-anesthesia</span></li>
                                <li><i class="icon-medical-i-ambulance"></i><span>icon-medical-i-ambulance</span></li>
                                <li><i class="icon-medical-i-alternative-complementary"></i><span>icon-medical-i-alternative-complementary</span></li>
                                <li><i class="icon-medical-i-administration"></i><span>icon-medical-i-administration</span></li>
                                <li><i class="icon-medical-i-social-services"></i><span>icon-medical-i-social-services</span></li>
                                <li><i class="icon-medical-i-smoking"></i><span>icon-medical-i-smoking</span></li>
                                <li><i class="icon-medical-i-restrooms"></i><span>icon-medical-i-restrooms</span></li>
                                <li><i class="icon-medical-i-restaurant"></i><span>icon-medical-i-restaurant</span></li>
                                <li><i class="icon-medical-i-respiratory"></i><span>icon-medical-i-respiratory</span></li>
                                <li><i class="icon-medical-i-registration"></i><span>icon-medical-i-registration</span></li>
                                <li><i class="icon-medical-i-oncology"></i><span>icon-medical-i-oncology</span></li>
                                <li><i class="icon-medical-i-nutrition"></i><span>icon-medical-i-nutrition</span></li>
                                <li><i class="icon-medical-i-nursery"></i><span>icon-medical-i-nursery</span></li>
                                <li><i class="icon-medical-i-no-smoking"></i><span>icon-medical-i-no-smoking</span></li>
                                <li><i class="icon-medical-i-neurology"></i><span>icon-medical-i-neurology</span></li>
                                <li><i class="icon-medical-i-mri-pet"></i><span>icon-medical-i-mri-pet</span></li>
                                <li><i class="icon-medical-i-interpreter-services"></i><span>icon-medical-i-interpreter-services</span></li>
                                <li><i class="icon-medical-i-internal-medicine"></i><span>icon-medical-i-internal-medicine</span></li>
                                <li><i class="icon-medical-i-intensive-care"></i><span>icon-medical-i-intensive-care</span></li>
                                <li><i class="icon-medical-i-inpatient"></i><span>icon-medical-i-inpatient</span></li>
                                <li><i class="icon-medical-i-information-us"></i><span>icon-medical-i-information-us</span></li>
                                <li><i class="icon-medical-i-infectious-diseases"></i><span>icon-medical-i-infectious-diseases</span></li>
                                <li><i class="icon-medical-i-hearing-assistance"></i><span>icon-medical-i-hearing-assistance</span></li>
                                <li><i class="icon-medical-i-health-services"></i><span>icon-medical-i-health-services</span></li>
                                <li><i class="icon-medical-i-health-education"></i><span>icon-medical-i-health-education</span></li>
                                <li><i class="icon-medical-i-gift-shop"></i><span>icon-medical-i-gift-shop</span></li>
                                <li><i class="icon-medical-i-genetics"></i><span>icon-medical-i-genetics</span></li>
                                <li><i class="icon-medical-i-first-aid"></i><span>icon-medical-i-first-aid</span></li>
                                <li><i class="icon-medical-i-dermatology"></i><span>icon-medical-i-dermatology</span></li>
                                <li><i class="icon-medical-i-dental"></i><span>icon-medical-i-dental</span></li>
                                <li><i class="icon-medical-i-coffee-shop"></i><span>icon-medical-i-coffee-shop</span></li>
                                <li><i class="icon-medical-i-chapel"></i><span>icon-medical-i-chapel</span></li>
                                <li><i class="icon-medical-i-cath-lab"></i><span>icon-medical-i-cath-lab</span></li>
                                <li><i class="icon-medical-i-care-staff-area"></i><span>icon-medical-i-care-staff-area</span></li>
                                <li><i class="icon-medical-i-accessibility"></i><span>icon-medical-i-accessibility</span></li>
                                <li><i class="icon-medical-i-diabetes-education"></i><span>icon-medical-i-diabetes-education</span></li>
                                <li><i class="icon-medical-i-hospital"></i><span>icon-medical-i-hospital</span></li>
                                <li><i class="icon-medical-i-kidney"></i><span>icon-medical-i-kidney</span></li>
                                <li><i class="icon-medical-i-ophthalmology"></i><span>icon-medical-i-ophthalmology</span></li>
                                <li><i class="icon-medical-womens-health"></i><span>icon-medical-womens-health</span></li>
                                <li><i class="icon-medical-waiting-area"></i><span>icon-medical-waiting-area</span></li>
                                <li><i class="icon-medical-volume-control"></i><span>icon-medical-volume-control</span></li>
                                <li><i class="icon-medical-ultrasound"></i><span>icon-medical-ultrasound</span></li>
                                <li><i class="icon-medical-text-telephone"></i><span>icon-medical-text-telephone</span></li>
                                <li><i class="icon-medical-surgery"></i><span>icon-medical-surgery</span></li>
                                <li><i class="icon-medical-stairs"></i><span>icon-medical-stairs</span></li>
                                <li><i class="icon-medical-radiology"></i><span>icon-medical-radiology</span></li>
                                <li><i class="icon-medical-physical-therapy"></i><span>icon-medical-physical-therapy</span></li>
                                <li><i class="icon-medical-pharmacy"></i><span>icon-medical-pharmacy</span></li>
                                <li><i class="icon-medical-pediatrics"></i><span>icon-medical-pediatrics</span></li>
                                <li><i class="icon-medical-pathology"></i><span>icon-medical-pathology</span></li>
                                <li><i class="icon-medical-outpatient"></i><span>icon-medical-outpatient</span></li>
                                <li><i class="icon-medical-ophthalmology"></i><span>icon-medical-ophthalmology</span></li>
                                <li><i class="icon-medical-mental-health"></i><span>icon-medical-mental-health</span></li>
                                <li><i class="icon-medical-medical-records"></i><span>icon-medical-medical-records</span></li>
                                <li><i class="icon-medical-medical-library"></i><span>icon-medical-medical-library</span></li>
                                <li><i class="icon-medical-mammography"></i><span>icon-medical-mammography</span></li>
                                <li><i class="icon-medical-laboratory"></i><span>icon-medical-laboratory</span></li>
                                <li><i class="icon-medical-labor-delivery"></i><span>icon-medical-labor-delivery</span></li>
                                <li><i class="icon-medical-kidney"></i><span>icon-medical-kidney</span></li>
                                <li><i class="icon-medical-immunizations"></i><span>icon-medical-immunizations</span></li>
                                <li><i class="icon-medical-imaging-root-category"></i><span>icon-medical-imaging-root-category</span></li>
                                <li><i class="icon-medical-imaging-alternative-pet"></i><span>icon-medical-imaging-alternative-pet</span></li>
                                <li><i class="icon-medical-imaging-alternative-mri"></i><span>icon-medical-imaging-alternative-mri</span></li>
                                <li><i class="icon-medical-imaging-alternative-mri-two"></i><span>icon-medical-imaging-alternative-mri-two</span></li>
                                <li><i class="icon-medical-imaging-alternative-ct"></i><span>icon-medical-imaging-alternative-ct</span></li>
                                <li><i class="icon-medical-hospital"></i><span>icon-medical-hospital</span></li>
                                <li><i class="icon-medical-fire-extinguisher"></i><span>icon-medical-fire-extinguisher</span></li>
                                <li><i class="icon-medical-family-practice"></i><span>icon-medical-family-practice</span></li>
                                <li><i class="icon-medical-emergency"></i><span>icon-medical-emergency</span></li>
                                <li><i class="icon-medical-elevators"></i><span>icon-medical-elevators</span></li>
                                <li><i class="icon-medical-ear-nose-throat"></i><span>icon-medical-ear-nose-throat</span></li>
                                <li><i class="icon-medical-drinking-fountain"></i><span>icon-medical-drinking-fountain</span></li>
                                <li><i class="icon-medical-diabetes-education"></i><span>icon-medical-diabetes-education</span></li>
                                <li><i class="icon-medical-cardiology"></i><span>icon-medical-cardiology</span></li>
                                <li><i class="icon-medical-billing"></i><span>icon-medical-billing</span></li>
                                <li><i class="icon-medical-anesthesia"></i><span>icon-medical-anesthesia</span></li>
                                <li><i class="icon-medical-ambulance"></i><span>icon-medical-ambulance</span></li>
                                <li><i class="icon-medical-alternative-complementary"></i><span>icon-medical-alternative-complementary</span></li>
                                <li><i class="icon-medical-administration"></i><span>icon-medical-administration</span></li>
                                <li><i class="icon-medical-accessibility"></i><span>icon-medical-accessibility</span></li>
                                <li><i class="icon-medical-social-services"></i><span>icon-medical-social-services</span></li>
                                <li><i class="icon-medical-smoking"></i><span>icon-medical-smoking</span></li>
                                <li><i class="icon-medical-restrooms"></i><span>icon-medical-restrooms</span></li>
                                <li><i class="icon-medical-restaurant"></i><span>icon-medical-restaurant</span></li>
                                <li><i class="icon-medical-respiratory"></i><span>icon-medical-respiratory</span></li>
                                <li><i class="icon-medical-oncology"></i><span>icon-medical-oncology</span></li>
                                <li><i class="icon-medical-nutrition"></i><span>icon-medical-nutrition</span></li>
                                <li><i class="icon-medical-nursery"></i><span>icon-medical-nursery</span></li>
                                <li><i class="icon-medical-no-smoking"></i><span>icon-medical-no-smoking</span></li>
                                <li><i class="icon-medical-neurology"></i><span>icon-medical-neurology</span></li>
                                <li><i class="icon-medical-mri-pet"></i><span>icon-medical-mri-pet</span></li>
                                <li><i class="icon-medical-interpreter-services"></i><span>icon-medical-interpreter-services</span></li>
                                <li><i class="icon-medical-internal-medicine"></i><span>icon-medical-internal-medicine</span></li>
                                <li><i class="icon-medical-intensive-care"></i><span>icon-medical-intensive-care</span></li>
                                <li><i class="icon-medical-inpatient"></i><span>icon-medical-inpatient</span></li>
                                <li><i class="icon-medical-information-us"></i><span>icon-medical-information-us</span></li>
                                <li><i class="icon-medical-infectious-diseases"></i><span>icon-medical-infectious-diseases</span></li>
                                <li><i class="icon-medical-hearing-assistance"></i><span>icon-medical-hearing-assistance</span></li>
                                <li><i class="icon-medical-health-services"></i><span>icon-medical-health-services</span></li>
                                <li><i class="icon-medical-health-education"></i><span>icon-medical-health-education</span></li>
                                <li><i class="icon-medical-gift-shop"></i><span>icon-medical-gift-shop</span></li>
                                <li><i class="icon-medical-genetics"></i><span>icon-medical-genetics</span></li>
                                <li><i class="icon-medical-first-aid"></i><span>icon-medical-first-aid</span></li>
                                <li><i class="icon-medical-dental"></i><span>icon-medical-dental</span></li>
                                <li><i class="icon-medical-coffee-shop"></i><span>icon-medical-coffee-shop</span></li>
                                <li><i class="icon-medical-chapel"></i><span>icon-medical-chapel</span></li>
                                <li><i class="icon-medical-cath-lab"></i><span>icon-medical-cath-lab</span></li>
                                <li><i class="icon-medical-care-staff-area"></i><span>icon-medical-care-staff-area</span></li>
                                <li><i class="icon-medical-registration"></i><span>icon-medical-registration</span></li>
                                <li><i class="icon-medical-dermatology"></i><span>icon-medical-dermatology</span></li>
                                <li><i class="icon-realestate-advert"></i><span>icon-realestate-advert</span></li>
                                <li><i class="icon-realestate-air-conditioning"></i><span>icon-realestate-air-conditioning</span></li>
                                <li><i class="icon-realestate-bag"></i><span>icon-realestate-bag</span></li>
                                <li><i class="icon-realestate-balance"></i><span>icon-realestate-balance</span></li>
                                <li><i class="icon-realestate-balcony"></i><span>icon-realestate-balcony</span></li>
                                <li><i class="icon-realestate-barrow"></i><span>icon-realestate-barrow</span></li>
                                <li><i class="icon-realestate-bathtub"></i><span>icon-realestate-bathtub</span></li>
                                <li><i class="icon-realestate-bed"></i><span>icon-realestate-bed</span></li>
                                <li><i class="icon-realestate-billboard"></i><span>icon-realestate-billboard</span></li>
                                <li><i class="icon-realestate-box"></i><span>icon-realestate-box</span></li>
                                <li><i class="icon-realestate-bricks"></i><span>icon-realestate-bricks</span></li>
                                <li><i class="icon-realestate-bridge"></i><span>icon-realestate-bridge</span></li>
                                <li><i class="icon-realestate-brush"></i><span>icon-realestate-brush</span></li>
                                <li><i class="icon-realestate-building-crane"></i><span>icon-realestate-building-crane</span></li>
                                <li><i class="icon-realestate-building"></i><span>icon-realestate-building</span></li>
                                <li><i class="icon-realestate-building2"></i><span>icon-realestate-building2</span></li>
                                <li><i class="icon-realestate-building3"></i><span>icon-realestate-building3</span></li>
                                <li><i class="icon-realestate-bungalow"></i><span>icon-realestate-bungalow</span></li>
                                <li><i class="icon-realestate-buying-a-home"></i><span>icon-realestate-buying-a-home</span></li>
                                <li><i class="icon-realestate-calculator"></i><span>icon-realestate-calculator</span></li>
                                <li><i class="icon-realestate-calendar"></i><span>icon-realestate-calendar</span></li>
                                <li><i class="icon-realestate-chair"></i><span>icon-realestate-chair</span></li>
                                <li><i class="icon-realestate-chair2"></i><span>icon-realestate-chair2</span></li>
                                <li><i class="icon-realestate-chandelier"></i><span>icon-realestate-chandelier</span></li>
                                <li><i class="icon-realestate-check"></i><span>icon-realestate-check</span></li>
                                <li><i class="icon-realestate-china-house"></i><span>icon-realestate-china-house</span></li>
                                <li><i class="icon-realestate-clip"></i><span>icon-realestate-clip</span></li>
                                <li><i class="icon-realestate-combination-lock"></i><span>icon-realestate-combination-lock</span></li>
                                <li><i class="icon-realestate-compasses"></i><span>icon-realestate-compasses</span></li>
                                <li><i class="icon-realestate-concrete-mixer"></i><span>icon-realestate-concrete-mixer</span></li>
                                <li><i class="icon-realestate-construction-helmet"></i><span>icon-realestate-construction-helmet</span></li>
                                <li><i class="icon-realestate-court"></i><span>icon-realestate-court</span></li>
                                <li><i class="icon-realestate-credit"></i><span>icon-realestate-credit</span></li>
                                <li><i class="icon-realestate-dialogue"></i><span>icon-realestate-dialogue</span></li>
                                <li><i class="icon-realestate-doc"></i><span>icon-realestate-doc</span></li>
                                <li><i class="icon-realestate-doc2"></i><span>icon-realestate-doc2</span></li>
                                <li><i class="icon-realestate-doc3"></i><span>icon-realestate-doc3</span></li>
                                <li><i class="icon-realestate-document"></i><span>icon-realestate-document</span></li>
                                <li><i class="icon-realestate-door"></i><span>icon-realestate-door</span></li>
                                <li><i class="icon-realestate-door2"></i><span>icon-realestate-door2</span></li>
                                <li><i class="icon-realestate-drill"></i><span>icon-realestate-drill</span></li>
                                <li><i class="icon-realestate-eco"></i><span>icon-realestate-eco</span></li>
                                <li><i class="icon-realestate-elevator"></i><span>icon-realestate-elevator</span></li>
                                <li><i class="icon-realestate-exchange"></i><span>icon-realestate-exchange</span></li>
                                <li><i class="icon-realestate-fence"></i><span>icon-realestate-fence</span></li>
                                <li><i class="icon-realestate-fireplace"></i><span>icon-realestate-fireplace</span></li>
                                <li><i class="icon-realestate-folder"></i><span>icon-realestate-folder</span></li>
                                <li><i class="icon-realestate-garage"></i><span>icon-realestate-garage</span></li>
                                <li><i class="icon-realestate-garage2"></i><span>icon-realestate-garage2</span></li>
                                <li><i class="icon-realestate-glasses"></i><span>icon-realestate-glasses</span></li>
                                <li><i class="icon-realestate-hacksaw"></i><span>icon-realestate-hacksaw</span></li>
                                <li><i class="icon-realestate-hammer"></i><span>icon-realestate-hammer</span></li>
                                <li><i class="icon-realestate-hangar"></i><span>icon-realestate-hangar</span></li>
                                <li><i class="icon-realestate-heating"></i><span>icon-realestate-heating</span></li>
                                <li><i class="icon-realestate-high-voltage"></i><span>icon-realestate-high-voltage</span></li>
                                <li><i class="icon-realestate-horn"></i><span>icon-realestate-horn</span></li>
                                <li><i class="icon-realestate-hotel"></i><span>icon-realestate-hotel</span></li>
                                <li><i class="icon-realestate-hotel2"></i><span>icon-realestate-hotel2</span></li>
                                <li><i class="icon-realestate-house-key"></i><span>icon-realestate-house-key</span></li>
                                <li><i class="icon-realestate-house"></i><span>icon-realestate-house</span></li>
                                <li><i class="icon-realestate-house2"></i><span>icon-realestate-house2</span></li>
                                <li><i class="icon-realestate-house3"></i><span>icon-realestate-house3</span></li>
                                <li><i class="icon-realestate-house4"></i><span>icon-realestate-house4</span></li>
                                <li><i class="icon-realestate-house5"></i><span>icon-realestate-house5</span></li>
                                <li><i class="icon-realestate-house6"></i><span>icon-realestate-house6</span></li>
                                <li><i class="icon-realestate-house7"></i><span>icon-realestate-house7</span></li>
                                <li><i class="icon-realestate-house8"></i><span>icon-realestate-house8</span></li>
                                <li><i class="icon-realestate-house9"></i><span>icon-realestate-house9</span></li>
                                <li><i class="icon-realestate-imac"></i><span>icon-realestate-imac</span></li>
                                <li><i class="icon-realestate-incision-plan"></i><span>icon-realestate-incision-plan</span></li>
                                <li><i class="icon-realestate-ipad"></i><span>icon-realestate-ipad</span></li>
                                <li><i class="icon-realestate-key"></i><span>icon-realestate-key</span></li>
                                <li><i class="icon-realestate-key2"></i><span>icon-realestate-key2</span></li>
                                <li><i class="icon-realestate-ladder"></i><span>icon-realestate-ladder</span></li>
                                <li><i class="icon-realestate-lamp"></i><span>icon-realestate-lamp</span></li>
                                <li><i class="icon-realestate-lawn-mower"></i><span>icon-realestate-lawn-mower</span></li>
                                <li><i class="icon-realestate-letter"></i><span>icon-realestate-letter</span></li>
                                <li><i class="icon-realestate-light-bulb"></i><span>icon-realestate-light-bulb</span></li>
                                <li><i class="icon-realestate-light-bulb2"></i><span>icon-realestate-light-bulb2</span></li>
                                <li><i class="icon-realestate-lock"></i><span>icon-realestate-lock</span></li>
                                <li><i class="icon-realestate-lock2"></i><span>icon-realestate-lock2</span></li>
                                <li><i class="icon-realestate-love"></i><span>icon-realestate-love</span></li>
                                <li><i class="icon-realestate-mail"></i><span>icon-realestate-mail</span></li>
                                <li><i class="icon-realestate-map"></i><span>icon-realestate-map</span></li>
                                <li><i class="icon-realestate-medicine-chest"></i><span>icon-realestate-medicine-chest</span></li>
                                <li><i class="icon-realestate-mixer"></i><span>icon-realestate-mixer</span></li>
                                <li><i class="icon-realestate-money"></i><span>icon-realestate-money</span></li>
                                <li><i class="icon-realestate-moneybox"></i><span>icon-realestate-moneybox</span></li>
                                <li><i class="icon-realestate-motorhome"></i><span>icon-realestate-motorhome</span></li>
                                <li><i class="icon-realestate-move"></i><span>icon-realestate-move</span></li>
                                <li><i class="icon-realestate-move2"></i><span>icon-realestate-move2</span></li>
                                <li><i class="icon-realestate-music"></i><span>icon-realestate-music</span></li>
                                <li><i class="icon-realestate-music2"></i><span>icon-realestate-music2</span></li>
                                <li><i class="icon-realestate-my-house"></i><span>icon-realestate-my-house</span></li>
                                <li><i class="icon-realestate-my-key"></i><span>icon-realestate-my-key</span></li>
                                <li><i class="icon-realestate-newspapers"></i><span>icon-realestate-newspapers</span></li>
                                <li><i class="icon-realestate-nightstand"></i><span>icon-realestate-nightstand</span></li>
                                <li><i class="icon-realestate-nippers"></i><span>icon-realestate-nippers</span></li>
                                <li><i class="icon-realestate-notebook"></i><span>icon-realestate-notebook</span></li>
                                <li><i class="icon-realestate-pan"></i><span>icon-realestate-pan</span></li>
                                <li><i class="icon-realestate-parking"></i><span>icon-realestate-parking</span></li>
                                <li><i class="icon-realestate-parquet"></i><span>icon-realestate-parquet</span></li>
                                <li><i class="icon-realestate-phone"></i><span>icon-realestate-phone</span></li>
                                <li><i class="icon-realestate-phone2"></i><span>icon-realestate-phone2</span></li>
                                <li><i class="icon-realestate-phone3"></i><span>icon-realestate-phone3</span></li>
                                <li><i class="icon-realestate-pipe-wrench"></i><span>icon-realestate-pipe-wrench</span></li>
                                <li><i class="icon-realestate-plan"></i><span>icon-realestate-plan</span></li>
                                <li><i class="icon-realestate-plan2"></i><span>icon-realestate-plan2</span></li>
                                <li><i class="icon-realestate-plan3"></i><span>icon-realestate-plan3</span></li>
                                <li><i class="icon-realestate-plant"></i><span>icon-realestate-plant</span></li>
                                <li><i class="icon-realestate-plant2"></i><span>icon-realestate-plant2</span></li>
                                <li><i class="icon-realestate-point"></i><span>icon-realestate-point</span></li>
                                <li><i class="icon-realestate-pointer"></i><span>icon-realestate-pointer</span></li>
                                <li><i class="icon-realestate-printer"></i><span>icon-realestate-printer</span></li>
                                <li><i class="icon-realestate-purse"></i><span>icon-realestate-purse</span></li>
                                <li><i class="icon-realestate-purse2"></i><span>icon-realestate-purse2</span></li>
                                <li><i class="icon-realestate-realtor"></i><span>icon-realestate-realtor</span></li>
                                <li><i class="icon-realestate-regulator"></i><span>icon-realestate-regulator</span></li>
                                <li><i class="icon-realestate-rent"></i><span>icon-realestate-rent</span></li>
                                <li><i class="icon-realestate-rent2"></i><span>icon-realestate-rent2</span></li>
                                <li><i class="icon-realestate-restaurant"></i><span>icon-realestate-restaurant</span></li>
                                <li><i class="icon-realestate-roller"></i><span>icon-realestate-roller</span></li>
                                <li><i class="icon-realestate-roulette"></i><span>icon-realestate-roulette</span></li>
                                <li><i class="icon-realestate-scale"></i><span>icon-realestate-scale</span></li>
                                <li><i class="icon-realestate-search"></i><span>icon-realestate-search</span></li>
                                <li><i class="icon-realestate-secateurs"></i><span>icon-realestate-secateurs</span></li>
                                <li><i class="icon-realestate-shop"></i><span>icon-realestate-shop</span></li>
                                <li><i class="icon-realestate-shovel"></i><span>icon-realestate-shovel</span></li>
                                <li><i class="icon-realestate-shower"></i><span>icon-realestate-shower</span></li>
                                <li><i class="icon-realestate-skyscrapers"></i><span>icon-realestate-skyscrapers</span></li>
                                <li><i class="icon-realestate-skyscrapers2"></i><span>icon-realestate-skyscrapers2</span></li>
                                <li><i class="icon-realestate-socket"></i><span>icon-realestate-socket</span></li>
                                <li><i class="icon-realestate-spatula"></i><span>icon-realestate-spatula</span></li>
                                <li><i class="icon-realestate-stamp"></i><span>icon-realestate-stamp</span></li>
                                <li><i class="icon-realestate-statistic"></i><span>icon-realestate-statistic</span></li>
                                <li><i class="icon-realestate-suitcase2"></i><span>icon-realestate-suitcase2</span></li>
                                <li><i class="icon-realestate-swimming-pool"></i><span>icon-realestate-swimming-pool</span></li>
                                <li><i class="icon-realestate-switch"></i><span>icon-realestate-switch</span></li>
                                <li><i class="icon-realestate-tag"></i><span>icon-realestate-tag</span></li>
                                <li><i class="icon-realestate-tap"></i><span>icon-realestate-tap</span></li>
                                <li><i class="icon-realestate-things"></i><span>icon-realestate-things</span></li>
                                <li><i class="icon-realestate-time"></i><span>icon-realestate-time</span></li>
                                <li><i class="icon-realestate-tools"></i><span>icon-realestate-tools</span></li>
                                <li><i class="icon-realestate-trowel"></i><span>icon-realestate-trowel</span></li>
                                <li><i class="icon-realestate-tv"></i><span>icon-realestate-tv</span></li>
                                <li><i class="icon-realestate-vacuum-cleaner"></i><span>icon-realestate-vacuum-cleaner</span></li>
                                <li><i class="icon-realestate-ventilation"></i><span>icon-realestate-ventilation</span></li>
                                <li><i class="icon-realestate-washing-machine"></i><span>icon-realestate-washing-machine</span></li>
                                <li><i class="icon-realestate-window"></i><span>icon-realestate-window</span></li>
                                <li><i class="icon-realestate-wood"></i><span>icon-realestate-wood</span></li>
                              </ul>
                            </div>
                          `,
                          attributes: { class: "my-class" },
                      });

                  $('#icons-filter').typing({
                    stop: function (event, $elem) {
                      var filterValue = $elem.val(),
                        count = 0;

                      if( $elem.val() ) {
                                    console.log($elem.val());
                        $(".icons-list li").each(function(){
                                        
                          if ($(this).text().search(new RegExp(filterValue, "i")) < 0) {
                            $(this).fadeOut();
                          } else {
                            $(this).show();
                            count++
                          }
                        });
                      } else {
                        $(".icons-list li").show();
                      }

                      count = 0;
                    },
                    delay: 500
                  });

                  $("ul.icons-list li").on("click", function() {
                    console.log($(this).find("i").attr("class"));
                    editor.getSelected().set({
                        attributes: { class: $(this).find("i").attr("class") + " icon-2x" },
                    });
                    modal.close();
                  });
            },
        },
    },
});

editor.BlockManager.add('b4-block-col2', {
  label: '2 Columns',
  content: `<div class="row"><div class="col-md-6"></div><div class="col-md-6"></div></div>`,
  category: 'Columns',
  attributes: { class: 'fa fa-columns', },
});

editor.BlockManager.add("b4-block-col3", {
    label: "3 Columns",
    content: `<div class="row"><div class="col-md-4"></div><div class="col-md-4"></div><div class="col-md-4"></div></div>`,
    category: "Columns",
    attributes: { class: "fa fa-columns" },
});

editor.BlockManager.add("b4-block-col4", {
    label: "4 Columns",
    content: `<div class="row"><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div></div>`,
    category: "Columns",
    attributes: { class: "fa fa-columns" },
});
editor.BlockManager.add("b4-block-col6", {
    label: "6 Columns",
    content: `<div class="row"><div class="col-md-2"></div><div class="col-md-2"></div><div class="col-md-2"></div><div class="col-md-2"></div><div class="col-md-2"></div><div class="col-md-2"></div></div>`,
    category: "Columns",
    attributes: { class: "fa fa-columns" },
});

editor.TraitManager.addType("align-items", {
    // Return a simple HTML string or an HTML element
    createInput({ trait }) {
        // Here we can decide to use properties from the trait
        const traitOpts = trait.get("options") || [];
        const options = traitOpts.lenght
            ? traitOpts
            : [
                  { id: "", name: "None" },
                  { id: "align-items-start", name: "Start" },
                  { id: "align-items-end", name: "End" },
                  { id: "align-items-center", name: "Center" },
                  { id: "align-items-baseline", name: "Baseline" },
                  { id: "align-items-stretch", name: "Stretch" },
              ];

        // Create a new element container add some content
        const el = document.createElement("div");
        el.innerHTML = `
      <select class="align-items__type">
        ${options
            .map((opt) => `<option value="${opt.id}">${opt.name}</option>`)
            .join("")}
      </select>
      <div class="gjs-sel-arrow">
        <div class="gjs-d-s-arrow"></div>
      </div>     
    `;

        return el;
    },

    // Update the component based element changes
    onEvent({ elInput, component }) {
        const inputType = elInput.querySelector(".align-items__type");
        const inputVal = inputType.value;

        if (inputVal !== "") {
            component.addAttributes({ "data-align-items": inputVal });
            component.addClass(inputVal);
            if (component._previousAttributes.attributes["data-align-items"]) {
                component.removeClass(
                    component._previousAttributes.attributes["data-align-items"]
                );
            }
        } else {
            component.removeClass(
                component.getAttributes()["data-align-items"]
            );
            component.removeAttributes("data-align-items");
        }
    },

    onUpdate({ elInput, component }) {
        const alignItems = component.getAttributes()["data-align-items"] || "";
        const inputType = elInput.querySelector(".align-items__type");

        inputType.value = alignItems;
    },
});

// editor.BlockManager.add('b4-block-row', {
//   label: 'Row',
//   content: `<div class="row" ></div>
//   <style> div.row {min-height: 40px;}</style>`,
//   category: 'Basic',
//   attributes: { class: 'fa fa-square' },
// });

// editor.BlockManager.add('b4-block-col2', {
//   label: 'Cols',
//   content: `<div class="col" ></div><div class="col" ></div>
//   <style> div.col {min-height: 40px;}</style>`,
//   category: 'Basic',
//   attributes: { class: 'fa fa-columns' },
// });

// editor.BlockManager.add('b4-block-container', {
//   label: 'Container',
//   tagName: "div",
//   content: {
//     type: "container",
//     content: `<div class="container" ></div>
//   <style> div.container {min-height: 40px;}</style>`},
//   category: 'Layout',
//   attributes: { class: 'fa fa-window-maximize' },
// });

// editor.DomComponents.addType("container", {
//     extend: "container",
//     content: {
//         type: "container",
//         styles: `
//         [data-gjs-type="container"]:empty:before {
//             background-color: #ddd;
//             color: #000;
//             font-size: 16px;
//             font-weight: bold;
//             display: flex;
//             align-items: center;
//             justify-content: center;
//             min-height: 50px;
//             padding: 0 10px;
//             opacity: 0.3;
//             border-radius: 3px;
//             white-space: nowrap;
//             overflow: hidden;
//             text-overflow: ellipsis;
//             content: "Container";
//         }
//         `,
//     },
//     category: "Layout",
// });

editor.BlockManager.add("b4-block-section", {
    label: "Section",
    content: `<section style="padding:100px 0"></section>
  <style> section:empty {min-height: 40px;}</style>`,
    category: "Layout",
    attributes: { class: "fa fa-puzzle-piece" },
});


editor.DomComponents.addType('link', {
  model: {
    defaults: {
      traits: [
      'title', 'href', 'target',  
      'data-toggle',
      { type: 'checkbox', name: 'data-toggle' },
      'data-target',
      { type: 'checkbox', name: 'data-target' },
      ]
    }
  }
});

editor.DomComponents.addType('link', {
  isComponent: el => el.tagName === 'A',
  extend: 'link',
  name: "Link",
  model: {
      defaults: {
        traits: [
          {
            type: 'href-next',
            name: 'href',
            label: 'New href',
          },
        ]
      }
    },
  view: {  }, // Will extend the view from 'other-defined-component'
});

editor.TraitManager.addType('href-next', {
    noLabel: true,

    // Return a simple HTML string or an HTML element
    createInput({ trait }) {
      // Here we can decide to use properties from the trait
      const traitOpts = trait.get('options') || [];
      const options = traitOpts.lenght ? traitOpts : [
        { id: 'url', name: 'URL' },
        { id: 'element', name: 'Element ID' },
        { id: 'email', name: 'Email' },
        { id: 'phone', name: 'Phone' },
      ];

      // Create a new element container add some content
      const el = document.createElement('div');
      el.innerHTML = `
      <ul class="nav nav-line" id="myTab" role="tablist">
        ${options
            .map((opt) => {
                return opt.id == "url"
                    ? `
                <li class="nav-item">
                  <a class="nav-link active" id="${opt.id}-tab" data-toggle="tab" href="#${opt.id}" role="tab" aria-controls="${opt.id}" aria-selected="true">${opt.name}</a>
                </li>
              `
                    : `
                <li class="nav-item">
                  <a class="nav-link" id="${opt.id}-tab" data-toggle="tab" href="#${opt.id}" role="tab" aria-controls="${opt.id}" aria-selected="true">${opt.name}</a>
                </li>
              `;
            })
            .join("")}
      </ul>
      <div class="tab-content mg-t-20" id="myTabContent">
        ${options
            .map((opt) => {
                if (opt.id == "url") {
                    return `
                <div class="tab-pane fade show active" id="${opt.id}" role="tabpanel" aria-labelledby="${opt.id}-tab">
                  <div class="gjs-trt-trait gjs-trt-trait--text">
                    <div class="gjs-label-wrp" data-label=""><div class="gjs-label" title="${opt.name}">${opt.name}</div></div>
                    <div class="gjs-field-wrp gjs-field-wrp--text" data-input="">
                      <div class="gjs-field gjs-field-text" data-input=""><input class="href-next__url" placeholder="Insert URL"/></div>
                    </div>
                  </div>
                  <div class="gjs-trt-trait gjs-trt-trait--text" style="margin-top:-10px">
                    <div class="gjs-label-wrp" data-label=""></div>
                    <div class="gjs-field-wrp gjs-field-wrp--text" data-input="">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label href-next__url--target" for="customCheck1">Open in new tab</label>
                      </div>
                    </div>
                  </div>
                </div>
              `;
                } else if (opt.id == "element") {
                    return `
                <div class="tab-pane fade" id="${opt.id}" role="tabpanel" aria-labelledby="${opt.id}-tab">
                  <div class="gjs-trt-trait gjs-trt-trait--text">
                    <div class="gjs-label-wrp" data-label=""><div class="gjs-label" title="${opt.name}">${opt.name}</div></div>
                    <div class="gjs-field-wrp gjs-field-wrp--text" data-input="">
                      <div class="gjs-field gjs-field-text" data-input=""><input class="href-next__element" placeholder="eg. my-element-in-page"/></div>
                    </div>
                  </div>
                  <div class="gjs-trt-trait gjs-trt-trait--text" style="margin-top:-10px">
                    <div class="gjs-label-wrp" data-label=""></div>
                    <div class="gjs-field-wrp gjs-field-wrp--text" data-input="">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                        <label class="custom-control-label href-next__element--target" for="customCheck2">Open in new tab</label>
                      </div>
                    </div>
                  </div>
                </div>
              `;
                } else if (opt.id == "email") {
                    return `
                <div class="tab-pane fade" id="${opt.id}" role="tabpanel" aria-labelledby="${opt.id}-tab">
                  <div class="gjs-trt-trait gjs-trt-trait--text">
                    <div class="gjs-label-wrp" data-label=""><div class="gjs-label" title="${opt.name}">${opt.name}</div></div>
                    <div class="gjs-field-wrp gjs-field-wrp--text" data-input="">
                      <div class="gjs-field gjs-field-text" data-input=""><input type="email" class="href-next__email" placeholder="eg. mail@gmail.com"/></div>
                    </div>
                  </div>
                  <div class="gjs-trt-trait gjs-trt-trait--text">
                    <div class="gjs-label-wrp" data-label=""><div class="gjs-label" title="Subject">Subject</div></div>
                    <div class="gjs-field-wrp gjs-field-wrp--text" data-input="">
                      <div class="gjs-field gjs-field-text" data-input=""><input class="href-next__email--subject" placeholder="eg. Hello"/></div>
                    </div>
                  </div>
                </div>
              `;
                } else {
                    return `
                <div class="tab-pane fade" id="${opt.id}" role="tabpanel" aria-labelledby="${opt.id}-tab">
                  <div class="gjs-trt-trait gjs-trt-trait--text">
                    <div class="gjs-label-wrp" data-label=""><div class="gjs-label" title="${opt.name}">${opt.name}</div></div>
                    <div class="gjs-field-wrp gjs-field-wrp--text" data-input="">
                      <div class="gjs-field gjs-field-text" data-input=""><input type="number" class="href-next__phone" placeholder="eg. +55123456789"/></div>
                    </div>
                  </div>
                </div>
              `;
                }
            })
            .join("")}
      </div>      
    `;

      return el;
    },

    // Update the component based element changes
    onEvent({ elInput, component }) {
      // `elInput` is the result HTMLElement you get from `createInput`
      const hrefNext = elInput.querySelector('#myTab a[data-toggle="tab"].active').id;
      let href = '';

      switch (hrefNext) {
          case "url-tab":
              elInput.querySelector(".href-next__email").value = "";
              elInput.querySelector(".href-next__email--subject").value = "";
              elInput.querySelector(".href-next__phone").value = "";
              const checkUrl = elInput.querySelector("#customCheck1:checked");
              if(checkUrl !== null) {
                component.addAttributes({ "target": "_blank" });
              } else {
                component.removeAttributes("target");
              }
              const valUrl = elInput.querySelector(".href-next__url").value;
              href = valUrl;
              break;
          case "element-tab":
              elInput.querySelector(".href-next__url").value = "";
              elInput.querySelector(".href-next__email").value = "";
              elInput.querySelector(".href-next__email--subject").value = "";
              elInput.querySelector(".href-next__phone").value = "";
              component.removeAttributes("target");
              const checkElement = elInput.querySelector("#customCheck2:checked");
              if(checkElement !== null) {
                component.addAttributes({ "target": "_blank" });
              } else {
                component.removeAttributes("target");
              }
              const valElement = elInput.querySelector(".href-next__element").value;
              href = `#${valElement}`;
              break;
          case "email-tab":
              elInput.querySelector(".href-next__url").value = "";
              elInput.querySelector(".href-next__element").value = "";
              elInput.querySelector(".href-next__phone").value = "";
              component.removeAttributes("target");
              const valEmail = elInput.querySelector(".href-next__email").value;
              const valSubj = elInput.querySelector(
                  ".href-next__email--subject"
              ).value;
              href = `mailto:${valEmail}${
                  valSubj ? `?subject=${valSubj}` : ""
              }`;
              break;
          case "phone-tab":
              elInput.querySelector(".href-next__url").value = "";
              elInput.querySelector("#customCheck1").checked = false;
              elInput.querySelector(".href-next__email").value = "";
              elInput.querySelector(".href-next__email--subject").value = "";
              component.removeAttributes("target");
              const valPhone = elInput.querySelector(".href-next__phone").value;
              href = `tel:${valPhone}`;
              break;
      }

      component.addAttributes({ href });
    },

    onUpdate({ elInput, component }) {
      const href = component.getAttributes().href || '';
      const target = component.getAttributes().target || '';
      const inputType = elInput.querySelector('.href-next__type');
      let type = 'url';

      if (href.indexOf('tel:') === 0) {
        elInput.querySelector("#myTab a[data-toggle='tab']").setAttribute("class", "nav-link");
        elInput.querySelector("#myTabContent div[role='tabpanel']").setAttribute("class", "tab-pane fade");
        elInput.querySelector("#phone-tab").setAttribute("class", "nav-link active");
        elInput.querySelector("#phone").setAttribute("class", "tab-pane fade show active");
        const inputPhone = elInput.querySelector('.href-next__phone');
        const phone = href.replace('tel:', '');

        inputPhone.value = phone || '';
      } else if (href.indexOf('mailto:') === 0) {
        elInput.querySelector("#myTab a[data-toggle='tab']").setAttribute("class", "nav-link");
        elInput.querySelector("#myTabContent div[role='tabpanel']").setAttribute("class", "tab-pane fade");
        elInput.querySelector("#email-tab").setAttribute("class", "nav-link active");
        elInput.querySelector("#email").setAttribute("class", "tab-pane fade show active");
        const inputEmail = elInput.querySelector('.href-next__email');
        const inputSubject = elInput.querySelector('.href-next__email--subject');
        const mailTo = href.replace('mailto:', '').split('?');
        const email = mailTo[0];
        const params = (mailTo[1] || '').split('&').reduce((acc, item) => {
          const items = item.split('=');
          acc[items[0]] = items[1];
          return acc;
        }, {});

        inputEmail.value = email || '';
        inputSubject.value = params.subject || '';
      } else if (href.indexOf('#') === 0) {
        elInput.querySelector("#myTab a[data-toggle='tab']").setAttribute("class", "nav-link");
        elInput.querySelector("#myTabContent div[role='tabpanel']").setAttribute("class", "tab-pane fade");
        elInput.querySelector("#element-tab").setAttribute("class", "nav-link active");
        elInput.querySelector("#element").setAttribute("class", "tab-pane fade show active");
        const checkElement = elInput.querySelector('#customCheck2');
        const inputElement = elInput.querySelector('.href-next__element');
        if(target != "") {
          checkElement.checked = true;
        }
        const element = href.replace('#', '');
        inputElement.value = element || '';
      }else {
        const checkUrl = elInput.querySelector('#customCheck1');
        if(target != "") {
          checkUrl.checked = true;
        }
        elInput.querySelector('.href-next__url').value = href;
      }

    },
  });

editor.TraitManager.addType('button-size', {
    // Return a simple HTML string or an HTML element
    createInput({ trait }) {
      // Here we can decide to use properties from the trait
      const traitOpts = trait.get('options') || [];
      const options = traitOpts.lenght ? traitOpts : [
        { id: '', name: 'Button Regular' },
        { id: 'button-mini', name: 'Button Mini' },
        { id: 'button-small', name: 'Button Small' },
        { id: 'button-large', name: 'Button Large' },
        { id: 'button-xlarge', name: 'Button Extra Large' },
        { id: 'button-desc', name: 'Button Extra Extra Large' },
      ];

      // Create a new element container add some content
      const el = document.createElement('div');
      el.innerHTML = `
      <select class="button-size__type">
        ${options
            .map((opt) => `<option value="${opt.id}">${opt.name}</option>`)
            .join("")}
      </select>
      <div class="gjs-sel-arrow">
        <div class="gjs-d-s-arrow"></div>
      </div>     
    `;

      return el;
    },

    // Update the component based element changes
    onEvent({ elInput, component }) {
      const inputType = elInput.querySelector(".button-size__type");
      const inputVal = inputType.value;

      if (inputVal !== "") {
        component.addAttributes({ "data-button-size": inputVal });
        component.addClass("button " + inputVal);
        if (component._previousAttributes.attributes["data-button-size"]) {
          component.removeClass(component._previousAttributes.attributes["data-button-size"]);
        }
      } else {
        component.removeClass(component.getAttributes()["data-button-size"]);
        component.removeAttributes("data-button-size");
      }
    },

    onUpdate({ elInput, component }) {
      const buttonSize = component.getAttributes()["data-button-size"] || '';
      const inputType = elInput.querySelector('.button-size__type');

      inputType.value = buttonSize;
    },
  });

editor.TraitManager.addType('button-style', {
    // Return a simple HTML string or an HTML element
    createInput({ trait }) {
      // Here we can decide to use properties from the trait
      const traitOpts = trait.get('options') || [];
      const options = traitOpts.lenght ? traitOpts : [
        { id: '', name: 'Button Flat' },
        { id: 'button-3d', name: 'Button 3D' },
        { id: 'button-border', name: 'Button Border' },
      ];

      // Create a new element container add some content
      const el = document.createElement('div');
      el.innerHTML = `
      <select class="button-style__type">
        ${options
            .map((opt) => `<option value="${opt.id}">${opt.name}</option>`)
            .join("")}
      </select>
      <div class="gjs-sel-arrow">
        <div class="gjs-d-s-arrow"></div>
      </div>     
    `;

      return el;
    },

    // Update the component based element changes
    onEvent({ elInput, component }) {
      const inputType = elInput.querySelector(".button-style__type");
      const inputVal = inputType.value;

      if (inputVal !== "") {
        component.addAttributes({ "data-button-style": inputVal });
        component.addClass("button " + inputVal);
        if (component._previousAttributes.attributes["data-button-style"]) {
          component.removeClass(component._previousAttributes.attributes["data-button-style"]);
        }
      } else {
        component.removeClass(component.getAttributes()["data-button-style"]);
        component.removeAttributes("data-button-style");
      }
    },

    onUpdate({ elInput, component }) {
      const buttonStyle = component.getAttributes()["data-button-style"] || '';
      const inputType = elInput.querySelector('.button-style__type');

      inputType.value = buttonStyle;
    },
  });

editor.DomComponents.addType("link-box", {
    isComponent: (el) => el.tagName === "A",
    extend: "link",
    name: "Link Box",
    badgable: true,
    model: {
      defaults: {
        traits: [
          {
            type: 'href-next',
            name: 'href',
            label: 'New href',
          },
        ]
      }
    },
    view: {}, // Will extend the view from 'other-defined-component'
});

editor.DomComponents.addType("button", {
    isComponent: (el) => el.tagName === "A",
    extend: "link",
    name: "Button",
    badgable: true,
    model: {
      defaults: {
        traits: [
          {
            type: 'href-next',
            name: 'href',
            label: 'New href',
          },
          {
            type: 'button-size',
            name: 'button size',
            label: 'Button Size',
          },
          {
            type: 'button-style',
            name: 'button style',
            label: 'Button Style',
          },
        ]
      }
    },
    view: {}, // Will extend the view from 'other-defined-component'
});



editor.BlockManager.add('button', {
  label: 'Button',
  content: {
    content: `<a data-gjs-type="button" class="button"><div data-gjs-type="text" data-highlightable="1">Button</div></a>`,
    style: {
        "min-width": "80px",
    },
  },
  category: 'Basic',
  attributes: { class: 'fa fa-square' },
});

editor.BlockManager.add('b4-block-link', {
  label: 'Link',
  content: `<a data-gjs-type="link" data-highlightable="1" id="iwrref" class="gjs-comp-selected">Link</a>`,
  category: 'Basic',
  attributes: { class: 'fa fa-link' },
});


editor.BlockManager.add("link-box", {
    category: "Basic",
    label: `
      <svg class="gjs-block-svg mg-b-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 13c.2.4.2.8 0 1.1-.4.3-.8.3-1.1 0a3.8 3.8 0 010-5.3L12.5 6a3.8 3.8 0 015.4 5.4l-1.1 1c0-.5-.1-1.2-.3-1.7l.3-.4a2.3 2.3 0 000-3.2 2.3 2.3 0 00-3.2 0L11 9.9a2.3 2.3 0 000 3.2zm2-3.1c.4-.3.8-.3 1.1 0a3.8 3.8 0 010 5.3L11.5 18A3.8 3.8 0 016 12.5l1.1-1c0 .5.1 1.2.3 1.7l-.3.4a2.3 2.3 0 000 3.2 2.3 2.3 0 003.2 0l2.7-2.7a2.3 2.3 0 000-3.2.7.7 0 010-1zM3 3v18h18V3H3zm0-2h18a2 2 0 012 2v18a2 2 0 01-2 2H3a2 2 0 01-2-2V3c0-1.1.9-2 2-2z"></path></svg>
      <div class="gjs-block-label">Link Box</div>
    `,
    content: {
        type: "link-box",
        name: "Link Box",
        editable: false,
        droppable: true,
        style: {
            display: "inline-block",
            padding: "5px",
            "min-height": "50px",
            "min-width": "50px",
        },
        attributes: {}
    },
});


// editor.BlockManager.add('b4-block-text', {
//   label: 'Text',
//   content: `<div data-gjs-type="text"  contenteditable="true" >Insert your text here</div>`,
//   category: 'Basic',
//   attributes: { class: 'fa fa-font' },
// });


editor.BlockManager.add('b4-image', {
 label: 'Image',
 content: {
  type: 'image',

},
attributes: { class: 'fa fa-file-image-o' },
category: 'Basic',
});

// editor.BlockManager.add('b4-video', {
//  label: 'Video',
//  content: `<div data-gjs-type="video" draggable="true" allowfullscreen="allowfullscreen" id="iyyl" class="gjs-comp-selected"><video src="img/video2.webm" class="gjs-no-pointer" style="height: 100%; width: 100%;"></video></div>`,
//  attributes: { class: 'fa fa-file-video-o' },
//  category: 'Basic',
// });


// editor.BlockManager.add('b4-map', {
//  label: 'Map',
//  content: `<iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>`,
//  attributes: { class: 'fa fa-map-marker' },
//  category: 'Basic',
// });




var blockManager = editor.BlockManager;
blockManager.add('table-block', {
  id: 'table',
  label: 'Table',
  category: 'Basic',
  attributes: { class: 'fa fa-table' },
  content: `<style>td { min-width: 100px; height: 20px;}</style>
  <table class="table  table-bordered table-resizable">
  <tr><td></td><td></td><td></td></tr>
  <tr><td></td><td></td><td></td></tr>
  <tr><td></td><td></td><td></td></tr>
  </table>
  `,
});
var TOOLBAR_CELL = [
{
  attributes: { class: "fa fa-arrows" },
  command: "tlb-move"
},
{
  attributes: { class: "fa fa-flag" },
  command: "table-insert-row-above"
},

{
  attributes: {class: 'fa fa-clone'},
  command: 'tlb-clone',
},
{
  attributes: {class: 'fa fa-trash-o'},
  command: 'tlb-delete',
}
];
var getCellToolbar = () => TOOLBAR_CELL;


var components = editor.DomComponents;
var text = components.getType('text');
components.addType('cell', {
  model: text.model.extend({
    defaults: Object.assign({}, text.model.prototype.defaults, {
      type: 'cell',
      tagName: 'td',
      draggable: ['tr'],
      
    }),
  },

  {
    isComponent(el) {
      let result;
      var tag = el.tagName;
      if (tag == 'TD' || tag == 'TH') {
        result = {
          type: 'cell',
          tagName: tag.toLowerCase()
        };
      }
      return result;
    }
  }),
  view: text.view,
});



editor.on('component:selected', m => {
  var compType = m.get('type');
  switch (compType) {
    case 'cell':
                  m.set('toolbar', getCellToolbar()); // set a toolbars
                }
              });



editor.Commands.add('table-insert-row-above', editor => {
  var selected = editor.getSelected();

  if (selected.is('cell')) {
    var rowComponent = selected.parent();
    var rowIndex = rowComponent.collection.indexOf(rowComponent);
    var cells = rowComponent.components().length;
    var rowContainer = rowComponent.parent();

    rowContainer.components().add({
      type: 'row',
      components: [...Array(cells).keys()].map(i => ({
        type: 'cell',
        content: 'New Cell',
      }))
    }, { at: rowIndex });
  }
});








//Alerts

// editor.BlockManager.add('b4-block-alert-primary', {
//   label: 'Alert primary',
//   content: `<div class="alert alert-primary" role="alert">
//   This is a primary alert—check it out!
//   </div>`,
//   category: 'Alerts',
//   attributes: { class: 'fa fa-exclamation-triangle' },
// });


// editor.BlockManager.add('b4-block-alert-secondary', {
//   label: 'Alert secondary',
//   content: `<div class="alert alert-secondary" role="alert">
//   This is a secondary alert—check it out!
//   </div>`,
//   category: 'Alerts',
//   attributes: { class: 'fa fa-exclamation-triangle' },
// });

// editor.BlockManager.add('b4-block-alert-success', {
//   label: 'Alert success',
//   content: `<div class="alert alert-success" role="alert">
//   This is a success alert—check it out!
//   </div>`,
//   category: 'Alerts',
//   attributes: { class: 'fa fa-exclamation-triangle' },
// });

// editor.BlockManager.add('b4-block-alert-danger', {
//   label: 'Alert danger',
//   content: `<div class="alert alert-danger" role="alert">
//   This is a danger alert—check it out!
//   </div>`,
//   category: 'Alerts',
//   attributes: { class: 'fa fa-exclamation-triangle' },
// });


//Buttons



// editor.BlockManager.add("b4-block-button-primary", {
//     label: "Button primary",
//     content: `
//       <a data-gjs-type="link" class="btn btn-primary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Primary</div></a>
//       <style>a p {margin-bottom: 0;}</style>
//     `,
//     category: "Buttons",
//     attributes: { class: "fa fa-square" },
// });
// editor.BlockManager.add('b4-block-button-secondary', {
//   label: 'Button secondary',
//   content: `<button type="button" class="btn btn-secondary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Secondary</div></button>`,
//   category: 'Buttons',
//   attributes: { class: 'fa fa-square' },
// });
// editor.BlockManager.add('b4-block-button-success', {
//   label: 'Button primary',
//   content: `<button type="button" class="btn btn-success"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Success</div></button>`,
//   category: 'Buttons',
//   attributes: { class: 'fa fa-square' },
// });
// editor.BlockManager.add('b4-block-button-danger', {
//   label: 'Button primary',
//   content: `<button type="button" class="btn btn-danger"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Danger</div></button>`,
//   category: 'Buttons',
//   attributes: { class: 'fa fa-square' },
// });

// editor.BlockManager.add('b4-block-button-primary-small', {
//   label: 'Button primary small',
//   content: `<button type="button" class="btn btn-primary btn-sm"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Small button</div></button>`,
//   category: 'Buttons',
//   attributes: { class: 'fa fa-square' },
// });
// editor.BlockManager.add('b4-block-button-secondary-small', {
//   label: 'Button secondary small',
//   content: `<button type="button" class="btn btn-secondary btn-sm"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Small button</div></button>`,
//   category: 'Buttons',
//   attributes: { class: 'fa fa-square' },
// });

// editor.BlockManager.add('b4-block-button-group', {
//   label: 'Button Group',
//   content: `<div class="btn-group" role="group" aria-label="Basic example">
//   <button type="button" class="btn btn-secondary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Left</div></button>
//   <button type="button" class="btn btn-secondary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Middle</div></button>
//   <button type="button" class="btn btn-secondary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Right</div></button>
//   </div>`,
//   category: 'Buttons',
//   attributes: { class: 'fa fa-square' },
// });




//Collapse
// editor.BlockManager.add('b4-block-button-collapse', {
//   label: 'Collapse',
//   content: `<p>
//   <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
//   Link with href
//   </a>
//   </p>
//   <div class="collapse" id="collapseExample">
//   <div class="card card-body">
//   Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
//   </div>
//   </div>`,
//   category: 'Collapse',
//   attributes: { class: 'fa fa-bars' },
// });

// editor.BlockManager.add('b4-block-button-accordion', {
//   label: 'Accordion',
//   content: `<div id="accordion">
//   <div class="card">
//   <div class="card-header" id="headingOne">
//   <h5 class="mb-0">
//   <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
//   Collapsible Group Item #1
//   </button>
//   </h5>
//   </div>

//   <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
//   <div class="card-body">
//   Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
//   </div>
//   </div>
//   </div>
//   <div class="card">
//   <div class="card-header" id="headingTwo">
//   <h5 class="mb-0">
//   <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
//   Collapsible Group Item #2
//   </button>
//   </h5>
//   </div>
//   <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
//   <div class="card-body">
//   Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
//   </div>
//   </div>
//   </div>
//   <div class="card">
//   <div class="card-header" id="headingThree">
//   <h5 class="mb-0">
//   <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
//   Collapsible Group Item #3
//   </button>
//   </h5>
//   </div>
//   <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
//   <div class="card-body">
//   Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
//   </div>
//   </div>
//   </div>
//   </div>`,
//   category: 'Collapse',
//   attributes: { class: 'fa fa-bars' },
// });


//Dropdown
// editor.BlockManager.add('b4-cards-dropdown', {
//   label: 'Dropdown',
//   content: `<div class="dropdown">
//   <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//   Dropdown button
//   </button>
//   <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
//   <a class="dropdown-item" href="#">Action</a>
//   <a class="dropdown-item" href="#">Another action</a>
//   <a class="dropdown-item" href="#">Something else here</a>
//   </div>
//   </div>`,
//   category: 'Dropdown',
//   attributes: { class: 'fa fa-caret-down' },
// });

// editor.BlockManager.add('b4-cards-dropdown-split', {
//   label: 'Split button dropdowns',
//   content: `<div class="btn-group">
//   <button type="button" class="btn ">Action</button>
//   <button type="button" class="btn  dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//   <span class="sr-only">Toggle Dropdown</span>
//   </button>
//   <div class="dropdown-menu">
//   <a class="dropdown-item" href="#">Action</a>
//   <a class="dropdown-item" href="#">Another action</a>
//   <a class="dropdown-item" href="#">Something else here</a>
//   <div class="dropdown-divider"></div>
//   <a class="dropdown-item" href="#">Separated link</a>
//   </div>
//   </div>`,
//   category: 'Dropdown',
//   attributes: { class: 'fa fa-caret-down' },
// });



editor.BlockManager.add("parallax", {
    label: "Parallax Background",
    content: `<div data-gjs-type="parallax" class="parallax gjs-selected" data-bottom-top="background-position:0px 300px;" data-top-bottom="background-position:0px -300px;"></div>`,
    category: "Background",
    attributes: { class: "gjs-fonts gjs-f-image" },
});

editor.DomComponents.addType('parallax', {
  isComponent: el => el.tagName === 'DIV',
  model: {  },
  view: {  }, // Will extend the view from 'other-defined-component'
});

//Cards

editor.BlockManager.add('b4-cards-button', {
  label: 'Card with button',
  content: `<div class="card" style="width: 18rem;">
  <img data-gjs-type="image" class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16f1fa7e8df%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16f1fa7e8df%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.1953125%22%20y%3D%2296.3%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
  <div class="card-body">
  <h5 class="card-title">Card title</h5>
  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
  </div>`,
  category: 'Cards',
  attributes: { class: 'fa fa-id-card' },
});



editor.BlockManager.add('b4-cards-center', {
  label: 'Card Center',
  content: `<div class="card text-center">
  <div class="card-header">
  Featured
  </div>
  <div class="card-body">
  <h5 class="card-title">Special title treatment</h5>
  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
  <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
  <div class="card-footer text-muted">
  2 days ago
  </div>
  </div>`,
  category: 'Cards',
  attributes: { class: 'fa fa-id-card' },
});


editor.BlockManager.add('b4-cards-featured', {
  label: 'Card Featured',
  content: `<div class="card">
  <h5 class="card-header">Featured</h5>
  <div class="card-body">
  <h5 class="card-title">Special title treatment</h5>
  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
  <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
  </div>`,
  category: 'Cards',
  attributes: { class: 'fa fa-id-card' },
});



editor.BlockManager.add('b4-cards-listgroup-featured', {
  label: 'Card List groups Featured',
  content: `<div class="card" style="width: 18rem;">
  <div class="card-header">
  Featured
  </div>
  <ul class="list-group list-group-flush">
  <li class="list-group-item">Cras justo odio</li>
  <li class="list-group-item">Dapibus ac facilisis in</li>
  <li class="list-group-item">Vestibulum at eros</li>
  </ul>
  </div>`,
  category: 'Cards',
  attributes: { class: 'fa fa-id-card' },
});


editor.BlockManager.add('b4-cards-listgroup', {
  label: 'Card List groups',
  content: `<div class="card" style="width: 18rem;">
  <ul class="list-group list-group-flush">
  <li class="list-group-item">Cras justo odio</li>
  <li class="list-group-item">Dapibus ac facilisis in</li>
  <li class="list-group-item">Vestibulum at eros</li>
  </ul>
  </div>`,
  category: 'Cards',
  attributes: { class: 'fa fa-id-card' },
});




//Button

editor.DomComponents.addType('b4-button', {
  // Make the editor understand when to bind `my-input-type`
  isComponent: el => el.tagName === 'BUTTON',

  // Model definition
  model: {
    // Default properties
    defaults: {
      tagName: 'button',
      classes: ['btn', 'btn-primary'],
      //draggable: 'form, form *', // Can be dropped only inside `form` elements
      droppable: false, // Can't drop other elements inside
      attributes: { // Default attributes
        type: 'submit',        
      },
      // components: [{
      //   type: 'text',
      //   content: 'Submit'
      // }],

      traits: [
      {
        label: 'Type',
        type: 'select',
        name: 'type',
        options: [
        {value: 'button', name: 'button'},
        {value: 'reset', name: 'reset'},
        {value: 'submit', name: 'submit'},


        ],
      },
      'data-toggle',
      { type: 'checkbox', name: 'data-toggle' },
      'data-target',
      { type: 'checkbox', name: 'data-target' },

      ],
    }
  }
});


//Input

editor.DomComponents.addType('b4-input', {
  // Make the editor understand when to bind `my-input-type`
  isComponent: el => el.tagName === 'INPUT',

  // Model definition
  model: {
    // Default properties
    defaults: {

     tagName: 'input',
      draggable: 'form, form *', // Can be dropped only inside `form` elements
      droppable: false, // Can't drop other elements inside
      classes: ['form-control'],
      attributes: { // Default attributes
        type: 'text',
        id: 'exampleInput',
        name: 'default-name',
        placeholder: 'Insert text here',
      },
      traits: [
      'name',
      'placeholder',
      { type: 'checkbox', name: 'required' },
      { type: 'checkbox', name: 'disabled' },
      
      {
        label: 'Type',
        type: 'select',
        name: 'type',
        options: [
        {value: 'text', name: 'text'},
        {value: 'email', name: 'email'},
        {value: 'password', name: 'password'},
        {value: 'number', name: 'number'},
        {value: 'date', name: 'date'},
        {value: 'hidden', name: 'hidden'},
        {value: 'checkbox', name: 'checkbox'},
        {value: 'file', name: 'file'},
        {value: 'radio', name: 'radio'},
        
        
        ]
      }
      ]

    }
  }
});



//Label

editor.DomComponents.addType('b4-label', {
  // Make the editor understand when to bind `my-input-type`
  isComponent: el => el.tagName === 'LABEL',

  // Model definition
  model: {
    // Default properties
    defaults: {
      tagName: 'label',
      attributes: { // Default attributes
        for: 'exampleInput',
      },components: [{
        type: 'text',        
      }],
      traits: [
      'for',
      ]
    }
  }
});


//Select

const traitManager = editor.TraitManager;
traitManager.addType('select-options', {
  events:{
    'keyup': 'onChange',
  },

  onValueChange: function () {
    const optionsStr = this.model.get('value').trim();
    const options = optionsStr.split('\n');
    const optComps = [];

    for (let i = 0; i < options.length; i++) {
      const optionStr = options[i];
      const option = optionStr.split('::');
      const opt = {
        tagName: 'option',
        attributes: {}
      };
      if(option[1]) {
        opt.content = option[1];
        opt.attributes.value = option[0];
      } else {
        opt.content = option[0];
        opt.attributes.value = option[0];
      }
      optComps.push(opt);
    }

    const comps = this.target.get('components');
    comps.reset(optComps);
    this.target.view.render();
  },

  getInputEl: function() {
    if (!this.$input) {
      const target = this.target;
      let optionsStr = '';
      const options = target.get('components');

      for (let i = 0; i < options.length; i++) {
        const option = options.models[i];
        const optAttr = option.get('attributes');
        const optValue = optAttr.value || '';
        optionsStr += `${optValue}${'::'}${option.get('content')}\n`;
      }

      this.$input = document.createElement('textarea');
      this.$input.value = optionsStr;
    }
    return this.$input;
  },
});



editor.DomComponents.addType('b4-select', {
  isComponent: el => el.tagName === 'SELECT',
  extend: 'select',
  model: { defaults: {
    name: 'SelectName',
    tagName: 'select',
    traits: [
    'name', {
      label: 'Options',
      type: 'select-options'
    },
    { type: 'checkbox', name: 'required' },
    ],


  } }, // Will extend the model from 'other-defined-component'
  view: {  }, // Will extend the view from 'other-defined-component'
});



//Group

editor.DomComponents.addType('b4-form-group', {
  // Make the editor understand when to bind `my-input-type`
  isComponent(el) {
    if(el && el.classList && el.classList.contains('form_group_input')) {
      return {type: 'form_group_input'};
    }
  },



  model: {
    // Default properties
    defaults: {

     tagName: 'div',
     classes: ['form-group'],
     draggable: 'form, form *', // Can be dropped only inside `form` elements
      attributes: { // Default attributes
        class: 'form-group',

      }
    }}
  });


//Jumbotron

editor.BlockManager.add('b4-jumbotron', {
  label: 'Jumbotron',
  content: `<div class="jumbotron">
  <h1 class="display-4">Hello, world!</h1>
  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
  <hr class="my-4">
  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
  <p class="lead">
  <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
  </p>
  </div>`,
  category: 'Jumbotrons',
  attributes: { class: 'fa fa-newspaper-o' },
});

editor.BlockManager.add('b4-jumbotron-fluid', {
  label: 'Fluid jumbotron',
  content: `<div class="jumbotron jumbotron-fluid">
  <div class="container">
  <h1 class="display-4">Fluid jumbotron</h1>
  <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
  </div>
  </div>`,
  category: 'Jumbotrons',
  attributes: { class: 'fa fa-newspaper-o' },
});



//Modal



// editor.BlockManager.add('b4-modal', {
//   label: 'Modal',
//   content: `<!-- Button trigger modal -->
//   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
//   Launch demo modal
//   </button>

//   <div class="modal modaledit" id="exampleModal" tabindex="-1" role="dialog">
//   <div class="modal-dialog" role="document">
//   <div class="modal-content">
//   <div class="modal-header">
//   <h5 class="modal-title">Modal title</h5>
//   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
//   <span aria-hidden="true">&times;</span>
//   </button>
//   </div>
//   <div class="modal-body">
//   <p>Modal body text goes here.</p>
//   </div>
//   <div class="modal-footer">
//   <button type="button" class="btn btn-primary">Save changes</button>
//   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
//   </div>
//   </div>
//   </div>
//   </div>
//   `,
//   category: 'Modals',
//   attributes: { class: 'fa fa-newspaper-o' },
// });




//Tabs


// editor.BlockManager.add('b4-tabs', {
//   label: 'Tabs',
//   content: `<nav>
//   <div class="nav nav-tabs" id="nav-tab" role="tablist">
//   <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
//   <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
//   <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
//   </div>
//   </nav>
//   <div class="tab-content" id="nav-tabContent">
//   <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.</div>
//   <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim reprehenderit. Magna duis labore cillum sint adipisicing exercitation ipsum. Nostrud ut anim non exercitation velit laboris fugiat cupidatat. Commodo esse dolore fugiat sint velit ullamco magna consequat voluptate minim amet aliquip ipsum aute laboris nisi. Labore labore veniam irure irure ipsum pariatur mollit magna in cupidatat dolore magna irure esse tempor ad mollit. Dolore commodo nulla minim amet ipsum officia consectetur amet ullamco voluptate nisi commodo ea sit eu.

//   </div>
//   <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">Sint sit mollit irure quis est nostrud cillum consequat Lorem esse do quis dolor esse fugiat sunt do. Eu ex commodo veniam Lorem aliquip laborum occaecat qui Lorem esse mollit dolore anim cupidatat. Deserunt officia id Lorem nostrud aute id commodo elit eiusmod enim irure amet eiusmod qui reprehenderit nostrud tempor. Fugiat ipsum excepteur in aliqua non et quis aliquip ad irure in labore cillum elit enim. Consequat aliquip incididunt ipsum et minim laborum laborum laborum et cillum labore. Deserunt adipisicing cillum id nulla minim nostrud labore eiusmod et amet. Laboris consequat consequat commodo non ut non aliquip reprehenderit nulla anim occaecat. Sunt sit ullamco reprehenderit irure ea ullamco Lorem aute nostrud magna.

//   </div>
//   </div>`,
//   category: 'Tabs',
//   attributes: { class: 'fa fa-clone' },
// });


// editor.BlockManager.add('b4-tabs-pills', {
//   label: 'Tabs Pills',
//   content: `<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
//   <li class="nav-item">
//   <a class="nav-link active show" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
//   </li>
//   <li class="nav-item">
//   <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
//   </li>
//   <li class="nav-item">
//   <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
//   </li>
//   </ul>
//   <div class="tab-content" id="pills-tabContent">
//   <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
//   <p>Consequat occaecat ullamco amet non eiusmod nostrud dolore irure incididunt est duis anim sunt officia. Fugiat velit proident aliquip nisi incididunt nostrud exercitation proident est nisi. Irure magna elit commodo anim ex veniam culpa eiusmod id nostrud sit cupidatat in veniam ad. Eiusmod consequat eu adipisicing minim anim aliquip cupidatat culpa excepteur quis. Occaecat sit eu exercitation irure Lorem incididunt nostrud.</p>
//   </div>
//   <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
//   <p>Ad pariatur nostrud pariatur exercitation ipsum ipsum culpa mollit commodo mollit ex. Aute sunt incididunt amet commodo est sint nisi deserunt pariatur do. Aliquip ex eiusmod voluptate exercitation cillum id incididunt elit sunt. Qui minim sit magna Lorem id et dolore velit Lorem amet exercitation duis deserunt. Anim id labore elit adipisicing ut in id occaecat pariatur ut ullamco ea tempor duis.</p>
//   </div>
//   <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
//   <p>Est quis nulla laborum officia ad nisi ex nostrud culpa Lorem excepteur aliquip dolor aliqua irure ex. Nulla ut duis ipsum nisi elit fugiat commodo sunt reprehenderit laborum veniam eu veniam. Eiusmod minim exercitation fugiat irure ex labore incididunt do fugiat commodo aliquip sit id deserunt reprehenderit aliquip nostrud. Amet ex cupidatat excepteur aute veniam incididunt mollit cupidatat esse irure officia elit do ipsum ullamco Lorem. Ullamco ut ad minim do mollit labore ipsum laboris ipsum commodo sunt tempor enim incididunt. Commodo quis sunt dolore aliquip aute tempor irure magna enim minim reprehenderit. Ullamco consectetur culpa veniam sint cillum aliqua incididunt velit ullamco sunt ullamco quis quis commodo voluptate. Mollit nulla nostrud adipisicing aliqua cupidatat aliqua pariatur mollit voluptate voluptate consequat non.</p>
//   </div>
//   </div>`,
//   category: 'Tabs',
//   attributes: { class: 'fa fa-clone' },
// });

// editor.BlockManager.add('b4-tabs-pills-vertical', {
//   label: 'Tabs Pills Vertical',
//   content: `
//   <div class="row">
//   <div class="col-3">
//   <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
//   <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
//   <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
//   <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
//   <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
//   </div>
//   </div>
//   <div class="col-9">
//   <div class="tab-content" id="v-pills-tabContent">
//   <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
//   <p>Cillum ad ut irure tempor velit nostrud occaecat ullamco aliqua anim Lorem sint. Veniam sint duis incididunt do esse magna mollit excepteur laborum qui. Id id reprehenderit sit est eu aliqua occaecat quis et velit excepteur laborum mollit dolore eiusmod. Ipsum dolor in occaecat commodo et voluptate minim reprehenderit mollit pariatur. Deserunt non laborum enim et cillum eu deserunt excepteur ea incididunt minim occaecat.</p>
//   </div>
//   <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
//   <p>Culpa dolor voluptate do laboris laboris irure reprehenderit id incididunt duis pariatur mollit aute magna pariatur consectetur. Eu veniam duis non ut dolor deserunt commodo et minim in quis laboris ipsum velit id veniam. Quis ut consectetur adipisicing officia excepteur non sit. Ut et elit aliquip labore Lorem enim eu. Ullamco mollit occaecat dolore ipsum id officia mollit qui esse anim eiusmod do sint minim consectetur qui.</p>
//   </div>
//   <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
//   <p>Fugiat id quis dolor culpa eiusmod anim velit excepteur proident dolor aute qui magna. Ad proident laboris ullamco esse anim Lorem Lorem veniam quis Lorem irure occaecat velit nostrud magna nulla. Velit et et proident Lorem do ea tempor officia dolor. Reprehenderit Lorem aliquip labore est magna commodo est ea veniam consectetur.</p>
//   </div>
//   <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
//   <p>Eu dolore ea ullamco dolore Lorem id cupidatat excepteur reprehenderit consectetur elit id dolor proident in cupidatat officia. Voluptate excepteur commodo labore nisi cillum duis aliqua do. Aliqua amet qui mollit consectetur nulla mollit velit aliqua veniam nisi id do Lorem deserunt amet. Culpa ullamco sit adipisicing labore officia magna elit nisi in aute tempor commodo eiusmod.</p>
//   </div>
//   </div>
//   </div>
//   </div>
//   `,
//   category: 'Tabs',
//   attributes: { class: 'fa fa-clone' },
// });





//Commands

editor.Panels.addButton('options',{
  id: 'undo',
  className: 'fa fa-undo',
  command: e => e.runCommand('core:undo'),
});
editor.Panels.addButton('options',{
  id: 'redo',
  className: 'fa fa-repeat',
  command: e => e.runCommand('core:redo'),
});

editor.Commands.add('cmdClear', e => confirm("Are you sure to clean the canvas?") && e.runCommand('core:canvas-clear'));
editor.Panels.addButton("options", {
	id: "clear-canvas",
	className: "fa fa-trash",
	command: "cmdClear",
	attributes: {
		title: "Clear Canvas",
		"data-tooltip": "Clear Canvas",
		"data-tooltip-pos": "bottom",
	},
});

editor.getConfig().showDevices = 0;
const panelDevices = editor.Panels.addPanel({ id: "devices-c" });
panelDevices.get("buttons").add([
	{
		id: "cmdDeviceDesktop",
		command: "cmdDeviceDesktop",
		className: "fa fa-desktop",
		active: 1,
	},
	{
		id: "cmdDeviceTablet",
		command: "cmdDeviceTablet",
		className: "fa fa-tablet",
	},
	{
		id: "cmdDeviceMobile",
		command: "cmdDeviceMobile",
		className: "fa fa-mobile",
	},
]);

var cmdm = editor.Commands

cmdm.add("cmdDeviceDesktop", {
	run: function (editor) {
		editor.setDevice("Desktop");
	},
	stop: function () {},
});
cmdm.add("cmdDeviceTablet", {
	run: function (editor) {
		editor.setDevice("Tablet");
	},
	stop: function () {},
});
cmdm.add("cmdDeviceMobile", {
	run: function (editor) {
		editor.setDevice("Mobile portrait");
	},
	stop: function () {},
});

var domc = editor.DomComponents;

domc.addType("image_basic", {
    extend: "image",
    model: {
        defaults: {
            attributes: {
                width: "100%",
                height: "auto",
            },
        },
    },
});

// domc.addType("container", {

//     model: {
//         defaults: {
//             traits: [
//                 {
//                     type: "select",
//                     label: "Animation",
//                     name: "data-animate",
//                     options: [
//                         { value: "", name: "None" },
//                         { value: "bounce", name: "Bounce" },
//                         //Other animations...
//                     ],
//                 },
//                 {
//                     type: "number",
//                     label: "Duration(s)",
//                     name: "duration",
//                 },
//                 {
//                     type: "number",
//                     label: "Delay(s)",
//                     name: "delay",
//                 },
//             ],
//         },
//         init() {
//             this.on("change:animation", this.onAnimationChange);
//             this.onAnimationChange();
//             this.on("change:duration", this.onDurationChange);
//             this.onDurationChange();
//             this.on("change:delay", this.onDelayChange);
//             this.onDelayChange();
//         },
//         onAnimationChange() {
//             const animation = this.get("animation");
//             this.addAttributes({ "data-animate": animation });
//             this.addClass({ animation });
//         },
//         onDurationChange() {
//             const duration = this.get("duration");
//             this.addStyle({ "animation-duration": duration });
//         },
//         onDelayChange() {
//             const delay = this.get("delay");
//             this.addStyle({ "animation-delay": delay });
//         },
//     },
// });


}

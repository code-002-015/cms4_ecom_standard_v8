function PB4(editor){



//Bacic Blocks

editor.BlockManager.add('b4-block-box', {
  label: 'Box',
  content: `<div class="box" ></div>
  <style> div.box {min-height: 40px;}</style>`,
  category: 'Layout',
  attributes: { class: 'fa fa-square-o' },
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
//   content: `<div class="container" ></div>
//   <style> div.container {min-height: 40px;}</style>`,
//   category: 'Basic',
//   attributes: { class: 'fa fa-window-maximize' },
// });


editor.BlockManager.add('b4-block-section', {
  label: 'Section',
  content: `<section></section>
  <style> section {min-height: 40px;}</style>`,
  category: 'Layout',
  attributes: { class: 'fa fa-puzzle-piece' },
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

editor.DomComponents.addType('b4-link', {
  isComponent: el => el.tagName === 'A',
  extend: 'link',
  model: { }, // Will extend the model from 'other-defined-component'
  view: {  }, // Will extend the view from 'other-defined-component'
});





editor.BlockManager.add('b4-block-link', {
  label: 'Link',
  content: `<a data-gjs-type="b4-link" draggable="true" data-highlightable="1" id="iwrref" class="gjs-comp-selected">Link</a>`,
  category: 'Basic',
  attributes: { class: 'fa fa-link' },
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


editor.BlockManager.add('b4-map', {
 label: 'Map',
 content: `<iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>`,
 attributes: { class: 'fa fa-map-marker' },
 category: 'Basic',
});




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

editor.BlockManager.add('b4-block-alert-primary', {
  label: 'Alert primary',
  content: `<div class="alert alert-primary" role="alert">
  This is a primary alert—check it out!
  </div>`,
  category: 'Alerts',
  attributes: { class: 'fa fa-exclamation-triangle' },
});


editor.BlockManager.add('b4-block-alert-secondary', {
  label: 'Alert secondary',
  content: `<div class="alert alert-secondary" role="alert">
  This is a secondary alert—check it out!
  </div>`,
  category: 'Alerts',
  attributes: { class: 'fa fa-exclamation-triangle' },
});

editor.BlockManager.add('b4-block-alert-success', {
  label: 'Alert success',
  content: `<div class="alert alert-success" role="alert">
  This is a success alert—check it out!
  </div>`,
  category: 'Alerts',
  attributes: { class: 'fa fa-exclamation-triangle' },
});

editor.BlockManager.add('b4-block-alert-danger', {
  label: 'Alert danger',
  content: `<div class="alert alert-danger" role="alert">
  This is a danger alert—check it out!
  </div>`,
  category: 'Alerts',
  attributes: { class: 'fa fa-exclamation-triangle' },
});


//Buttons



editor.BlockManager.add('b4-block-button-primary', {
  label: 'Button primary',
  content: `<button type="button" class="btn btn-primary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Primary</div></button>`,
  category: 'Buttons',
  attributes: { class: 'fa fa-square' },
});
editor.BlockManager.add('b4-block-button-secondary', {
  label: 'Button secondary',
  content: `<button type="button" class="btn btn-secondary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Secondary</div></button>`,
  category: 'Buttons',
  attributes: { class: 'fa fa-square' },
});
editor.BlockManager.add('b4-block-button-success', {
  label: 'Button primary',
  content: `<button type="button" class="btn btn-success"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Success</div></button>`,
  category: 'Buttons',
  attributes: { class: 'fa fa-square' },
});
editor.BlockManager.add('b4-block-button-danger', {
  label: 'Button primary',
  content: `<button type="button" class="btn btn-danger"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Danger</div></button>`,
  category: 'Buttons',
  attributes: { class: 'fa fa-square' },
});

editor.BlockManager.add('b4-block-button-primary-small', {
  label: 'Button primary small',
  content: `<button type="button" class="btn btn-primary btn-sm"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Small button</div></button>`,
  category: 'Buttons',
  attributes: { class: 'fa fa-square' },
});
editor.BlockManager.add('b4-block-button-secondary-small', {
  label: 'Button secondary small',
  content: `<button type="button" class="btn btn-secondary btn-sm"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Small button</div></button>`,
  category: 'Buttons',
  attributes: { class: 'fa fa-square' },
});

editor.BlockManager.add('b4-block-button-group', {
  label: 'Button Group',
  content: `<div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Left</div></button>
  <button type="button" class="btn btn-secondary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Middle</div></button>
  <button type="button" class="btn btn-secondary"><div data-gjs-type="text" draggable="true" data-highlightable="1" id="iu6eb" class="">Right</div></button>
  </div>`,
  category: 'Buttons',
  attributes: { class: 'fa fa-square' },
});




//Collapse
editor.BlockManager.add('b4-block-button-collapse', {
  label: 'Collapse',
  content: `<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
  Link with href
  </a>
  </p>
  <div class="collapse" id="collapseExample">
  <div class="card card-body">
  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
  </div>`,
  category: 'Collapse',
  attributes: { class: 'fa fa-bars' },
});

editor.BlockManager.add('b4-block-button-accordion', {
  label: 'Accordion',
  content: `<div id="accordion">
  <div class="card">
  <div class="card-header" id="headingOne">
  <h5 class="mb-0">
  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
  Collapsible Group Item #1
  </button>
  </h5>
  </div>

  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
  <div class="card-body">
  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
  </div>
  </div>
  </div>
  <div class="card">
  <div class="card-header" id="headingTwo">
  <h5 class="mb-0">
  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
  Collapsible Group Item #2
  </button>
  </h5>
  </div>
  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
  <div class="card-body">
  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
  </div>
  </div>
  </div>
  <div class="card">
  <div class="card-header" id="headingThree">
  <h5 class="mb-0">
  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
  Collapsible Group Item #3
  </button>
  </h5>
  </div>
  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
  <div class="card-body">
  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
  </div>
  </div>
  </div>
  </div>`,
  category: 'Collapse',
  attributes: { class: 'fa fa-bars' },
});


//Dropdown
editor.BlockManager.add('b4-cards-dropdown', {
  label: 'Dropdown',
  content: `<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  Dropdown button
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
  <a class="dropdown-item" href="#">Action</a>
  <a class="dropdown-item" href="#">Another action</a>
  <a class="dropdown-item" href="#">Something else here</a>
  </div>
  </div>`,
  category: 'Dropdown',
  attributes: { class: 'fa fa-caret-down' },
});

editor.BlockManager.add('b4-cards-dropdown-split', {
  label: 'Split button dropdowns',
  content: `<div class="btn-group">
  <button type="button" class="btn ">Action</button>
  <button type="button" class="btn  dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <span class="sr-only">Toggle Dropdown</span>
  </button>
  <div class="dropdown-menu">
  <a class="dropdown-item" href="#">Action</a>
  <a class="dropdown-item" href="#">Another action</a>
  <a class="dropdown-item" href="#">Something else here</a>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Separated link</a>
  </div>
  </div>`,
  category: 'Dropdown',
  attributes: { class: 'fa fa-caret-down' },
});





//Cards

editor.BlockManager.add('b4-cards-button', {
  label: 'Card with button',
  content: `<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16f1fa7e8df%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16f1fa7e8df%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.1953125%22%20y%3D%2296.3%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
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







//Carousels

editor.BlockManager.add('b4-carousel', {
  label: 'Carousel',
  content: `<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
  <div class="carousel-item active">
  <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16f1f8d5e3a%20text%20%7B%20fill%3A%23555%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16f1f8d5e3a%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22285.9140625%22%20y%3D%22217.7%22%3EFirst%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="First slide">
  </div>
  <div class="carousel-item">
  <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16f1f8d5e3e%20text%20%7B%20fill%3A%23444%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16f1f8d5e3e%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23666%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22247.3125%22%20y%3D%22217.7%22%3ESecond%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Second slide">
  </div>
  <div class="carousel-item">
  <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16f1f8d5e3c%20text%20%7B%20fill%3A%23333%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16f1f8d5e3c%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23555%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22276.9921875%22%20y%3D%22217.7%22%3EThird%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Third slide">
  </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
  <span class="carousel-control-next-icon" aria-hidden="true"></span>
  <span class="sr-only">Next</span>
  </a>
  </div>`,
  category: 'Sliders',
  attributes: { class: 'fa fa-sliders' },

});


editor.BlockManager.add('b4-carousel-text', {
  label: 'Carousel with text',
  content: `<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
  <div class="carousel-item active">
  <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16f1f8d5e3a%20text%20%7B%20fill%3A%23555%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16f1f8d5e3a%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22285.9140625%22%20y%3D%22217.7%22%3EFirst%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="First slide">
  <div class="carousel-caption d-none d-md-block">
  <h5>First slide label</h5>
  <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
  </div>
  </div>
  <div class="carousel-item">
  <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16f1f8d5e3e%20text%20%7B%20fill%3A%23444%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16f1f8d5e3e%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23666%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22247.3125%22%20y%3D%22217.7%22%3ESecond%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Second slide">
  <div class="carousel-caption d-none d-md-block">
  <h5>Second slide label</h5>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
  </div>
  </div>
  <div class="carousel-item">
  <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16f1f8d5e3c%20text%20%7B%20fill%3A%23333%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16f1f8d5e3c%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23555%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22276.9921875%22%20y%3D%22217.7%22%3EThird%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Third slide">
  <div class="carousel-caption d-none d-md-block">
  <h5>Third slide label</h5>
  <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
  </div>
  </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
  <span class="carousel-control-next-icon" aria-hidden="true"></span>
  <span class="sr-only">Next</span>
  </a>
  </div>`,
  category: 'Sliders',
  attributes: { class: 'fa fa-sliders' },

});



//Navbars

// editor.BlockManager.add('b4-navbar-light', {
//   label: 'Navbar light',
//   content: `<nav class="navbar navbar-expand-lg navbar-light bg-light">
//   <a class="navbar-brand" href="#"> <img src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">Navbar</a>
//   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
//   <span class="navbar-toggler-icon"></span>
//   </button>

//   <div class="collapse navbar-collapse" id="navbarSupportedContent">
//   <ul class="navbar-nav mr-auto">
//   <li class="nav-item active">
//   <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
//   </li>
//   <li class="nav-item">
//   <a class="nav-link" href="#">Link</a>
//   </li>
//   <li class="nav-item dropdown">
//   <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//   Dropdown
//   </a>
//   <div class="dropdown-menu" aria-labelledby="navbarDropdown">
//   <a class="dropdown-item" href="#">Action</a>
//   <a class="dropdown-item" href="#">Another action</a>
//   <div class="dropdown-divider"></div>
//   <a class="dropdown-item" href="#">Something else here</a>
//   </div>
//   </li>
//   <li class="nav-item">
//   <a class="nav-link disabled" href="#">Disabled</a>
//   </li>
//   </ul>
//   <form class="form-inline my-2 my-lg-0">
//   <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
//   <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
//   </form>
//   </div>
//   </nav>
//   `,
//   category: 'Bootstrap4 Navbars',
//   attributes: { class: 'fa fa-bars' },

// });

// editor.BlockManager.add('b4-navbar-dark', {
//   label: 'Navbar dark',
//   content: `<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
//   <a class="navbar-brand" href="#"> <img src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">Navbar</a>
//   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
//   <span class="navbar-toggler-icon"></span>
//   </button>

//   <div class="collapse navbar-collapse" id="navbarSupportedContent">
//   <ul class="navbar-nav mr-auto">
//   <li class="nav-item active">
//   <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
//   </li>
//   <li class="nav-item">
//   <a class="nav-link" href="#">Link</a>
//   </li>
//   <li class="nav-item dropdown">
//   <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//   Dropdown
//   </a>
//   <div class="dropdown-menu" aria-labelledby="navbarDropdown">
//   <a class="dropdown-item" href="#">Action</a>
//   <a class="dropdown-item" href="#">Another action</a>
//   <div class="dropdown-divider"></div>
//   <a class="dropdown-item" href="#">Something else here</a>
//   </div>
//   </li>
//   <li class="nav-item">
//   <a class="nav-link disabled" href="#">Disabled</a>
//   </li>
//   </ul>
//   <form class="form-inline my-2 my-lg-0">
//   <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
//   <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
//   </form>
//   </div>
//   </nav>
//   `,
//   category: 'Bootstrap4 Navbars',
//   attributes: { class: 'fa fa-bars' },

// });




//Forms

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




//Form

editor.DomComponents.addType('b4-form', {
  // Make the editor understand when to bind `my-input-type`
  isComponent: el => el.tagName === 'FORM',

  // Model definition
  model: {
    // Default properties
    defaults: {

      tagName: 'form',
      traits: [      
      
        {
          type: 'select',
          label: 'Method',
          name: 'method',
          options: [
            {value: 'get', name: 'GET'},
            {value: 'post', name: 'POST'},
          ],
        },{
          label: 'Action',
          name: 'action',
        },

      'data-request',
      { type: 'checkbox', name: 'data-request' },
      'data-request-confirm',
      { type: 'checkbox', name: 'data-request-confirm' },
      'data-request-redirect',
      { type: 'checkbox', name: 'data-request-redirect' },

      'data-request-url',
      { type: 'checkbox', name: 'data-request-url' },
      'data-request-update',
      { type: 'checkbox', name: 'data-request-update' },
      'data-request-ajax-global',
      { type: 'checkbox', name: 'data-request-ajax-global' },
      'data-request-data',
      { type: 'checkbox', name: 'data-request-data' },
      'data-request-before-update',
      { type: 'checkbox', name: 'data-request-before-update' },
      'data-request-success',
      { type: 'checkbox', name: 'data-request-success' },
      'data-request-error',
      { type: 'checkbox', name: 'data-request-error' },
      'data-request-complete',
      { type: 'checkbox', name: 'data-request-complete' },
      'data-request-loading',
      { type: 'checkbox', name: 'data-request-loading' },
      'data-request-form',
      { type: 'checkbox', name: 'data-request-form' },
      'data-request-flash',
      { type: 'checkbox', name: 'data-request-flash' },
      'data-request-files',
      { type: 'checkbox', name: 'data-request-files' },
      'data-track-input',
      { type: 'checkbox', name: 'data-track-input' },

      
      

      ],

      
      components: [

      {
        type: 'b4-form-group',
        components: [{

          type: 'b4-label',
          components: [{
            type: 'text',
            content: 'Example Input'
          }],
          
        },{

          type: 'b4-input',

        }]

      },

      {
        type: 'b4-form-group',
        components: [{

          type: 'b4-label',
          components: [{
            type: 'text',
            content: 'Example Input'
          }],
          
        },{

          type: 'b4-input',

        }]

      }
      ,{
        type: 'b4-button',
        components: [{
          type: 'text',
          content: 'Submit'
        }],

      }],


    }
  }
});


//Add Blocks

editor.BlockManager.add('b4-form-form', {
 label: `
 <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
 <path class="gjs-block-svg-path" d="M22,5.5 C22,5.2 21.5,5 20.75,5 L3.25,5 C2.5,5 2,5.2 2,5.5 L2,8.5 C2,8.8 2.5,9 3.25,9 L20.75,9 C21.5,9 22,8.8 22,8.5 L22,5.5 Z M21,8 L3,8 L3,6 L21,6 L21,8 Z" fill-rule="nonzero"></path>
 <path class="gjs-block-svg-path" d="M22,10.5 C22,10.2 21.5,10 20.75,10 L3.25,10 C2.5,10 2,10.2 2,10.5 L2,13.5 C2,13.8 2.5,14 3.25,14 L20.75,14 C21.5,14 22,13.8 22,13.5 L22,10.5 Z M21,13 L3,13 L3,11 L21,11 L21,13 Z" fill-rule="nonzero"></path>
 <rect class="gjs-block-svg-path" x="2" y="15" width="10" height="3" rx="0.5"></rect>
 </svg>
 <div class="gjs-block-label">Form</div>`,
 content: {
  type: 'b4-form',
},
//attributes: { class: 'fa fa-square' },
category: 'Forms',
});

editor.BlockManager.add('b4-form-button', {
 label: `
 <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
 <path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z" fill-rule="nonzero"></path>
 <rect class="gjs-block-svg-path" x="4" y="11.5" width="16" height="1"></rect>
 </svg>
 <div class="gjs-block-label">Button</div>`,
 content: {
  type: 'b4-button',
  components: [{
    type: 'text',
    content: 'Submit'
  }],
},
//attributes: { class: 'fa fa-square' },
category: 'Forms',
});

editor.BlockManager.add('b4-form-input', {
 label: `
 <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
 <path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path>
 <polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon>
 </svg>
 <div class="gjs-block-label">Input</div>`,
 content:  `<div class="form-group">
 <label data-gjs-type="b4-label" draggable="true" data-highlightable="1" for="exampleInput" id="i5rsh">
 <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Example Input</div>
 </label>
 <input type="text" class="form-control" id="exampleInput1" aria-describedby="emailHelp" placeholder="Enter text">
 <small id="Help" class="form-text text-muted">small text</small>
 </div>`,
//attributes: { class: 'fa fa-square' },
category: 'Forms',
});



editor.BlockManager.add('b4-form-label', {
 label: `
 <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
 <path class="gjs-block-svg-path" d="M22,11.875 C22,11.35 21.5,11 20.75,11 L3.25,11 C2.5,11 2,11.35 2,11.875 L2,17.125 C2,17.65 2.5,18 3.25,18 L20.75,18 C21.5,18 22,17.65 22,17.125 L22,11.875 Z M21,17 L3,17 L3,12 L21,12 L21,17 Z" fill-rule="nonzero"></path>
 <rect class="gjs-block-svg-path" x="2" y="5" width="14" height="5" rx="0.5"></rect>
 <polygon class="gjs-block-svg-path" fill-rule="nonzero" points="4 13 5 13 5 16 4 16"></polygon>
 </svg>
 <div class="gjs-block-label">Label</div>`,
 content: `<label data-gjs-type="b4-label" draggable="true" data-highlightable="1" for="exampleInput" id="i5rsh">
 <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Example Input</div>
 </label>`,
//attributes: { class: 'fa fa-square' },
category: 'Forms',
});



editor.BlockManager.add('b4-select', {
  label: `
  <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z" fill-rule="nonzero"></path>
  <polygon class="gjs-block-svg-path" transform="translate(18.500000, 12.000000) scale(1, -1) translate(-18.500000, -12.000000) " points="18.5 11 20 13 17 13"></polygon>
  <rect class="gjs-block-svg-path" x="4" y="11.5" width="11" height="1"></rect>
  </svg>
  <div class="gjs-block-label">Select</div>`,
  category: 'Forms',
  content: `<div class="form-group">
  <label data-gjs-type="b4-label" draggable="true" data-highlightable="1" for="exampleInput" id="i5rsh">
  <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Example Input</div>
  </label>
  <select  class="form-control"><option value="">SelectOption</option>
  <option value="1">Option 1</option>
  </select>
  </div>`,
});

editor.BlockManager.add('b4-multiple-select', {
  label: `
  <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z" fill-rule="nonzero"></path>
  <polygon class="gjs-block-svg-path" transform="translate(18.500000, 12.000000) scale(1, -1) translate(-18.500000, -12.000000) " points="18.5 11 20 13 17 13"></polygon>
  <rect class="gjs-block-svg-path" x="4" y="11.5" width="11" height="1"></rect>
  </svg>
  <div class="gjs-block-label">Multiple Select</div>`,
  category: 'Forms',
  content: `<div class="form-group">
  <label data-gjs-type="b4-label" draggable="true" data-highlightable="1" for="exampleInput" id="i5rsh">
  <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Example Input</div>
  </label>
  <select multiple class="form-control"><option value="">SelectOption</option>
  <option value="1">Option 1</option>
  </select>
  </div>`,
});



editor.BlockManager.add('b4-textarea', {
  label: `
  <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path class="gjs-block-svg-path" d="M22,7.5 C22,6.6 21.5,6 20.75,6 L3.25,6 C2.5,6 2,6.6 2,7.5 L2,16.5 C2,17.4 2.5,18 3.25,18 L20.75,18 C21.5,18 22,17.4 22,16.5 L22,7.5 Z M21,17 L3,17 L3,7 L21,7 L21,17 Z"></path>
  <polygon class="gjs-block-svg-path" points="4 8 5 8 5 12 4 12"></polygon>
  <polygon class="gjs-block-svg-path" points="19 7 20 7 20 17 19 17"></polygon>
  <polygon class="gjs-block-svg-path" points="20 8 21 8 21 9 20 9"></polygon>
  <polygon class="gjs-block-svg-path" points="20 15 21 15 21 16 20 16"></polygon>
  </svg>
  <div class="gjs-block-label">Textarea</div>`,
  category: 'Forms',
  content: `<div class="form-group">
  <label data-gjs-type="b4-label" draggable="true" data-highlightable="1" for="exampleInput" id="i5rsh">
  <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Example Input</div>
  </label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>`,
});


editor.BlockManager.add('b4-upload', {
  label: `Upload`,
  category: 'Forms',
  content: `<div class="form-group">
  <label data-gjs-type="b4-label" draggable="true" data-highlightable="1" for="exampleInput" id="i5rsh">
  <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Example file input</div>
  </label>

  <input type="file" class="form-control-file" id="exampleFormControlFile1">
  </div>
  `,
  attributes: { class: 'fa fa-file-o' },

});


editor.BlockManager.add('b4-check', {
  label: `CheckBox`,
  category: 'Forms',
  content: `<div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
  <label class="form-check-label" for="defaultCheck1">
  <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Default checkbox</div>
  </label>
  </div>`,
  attributes: { class: 'fa fa-check-square-o' },

});


editor.BlockManager.add('b4-radio', {
  label: `Radio`,
  category: 'Forms',
  content: `<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
  <label data-gjs-type="b4-label" draggable="true" data-highlightable="1" for="exampleInput" id="i5rsh">
  <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Default radio</div>
  </label>  
  </div>
  <div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
  <label data-gjs-type="b4-label" draggable="true" data-highlightable="1" for="exampleInput" id="i5rsh">
  <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Second default radio</div>
  </label>  
  </div>
  <div class="form-check disabled">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
  <label data-gjs-type="b4-label" draggable="true" data-highlightable="1" for="exampleInput" id="i5rsh">
  <div data-gjs-type="text" draggable="true" data-highlightable="1" id="ik44n" class="gjs-comp-selected" contenteditable="false">Disabled radio</div>
  </label>    
  </div>`,
  attributes: { class: 'fa fa-circle-o' },

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



editor.BlockManager.add('b4-modal', {
  label: 'Modal',
  content: `<!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
  </button>

  <div class="modal modaledit" id="exampleModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-header">
  <h5 class="modal-title">Modal title</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
  </div>
  <div class="modal-body">
  <p>Modal body text goes here.</p>
  </div>
  <div class="modal-footer">
  <button type="button" class="btn btn-primary">Save changes</button>
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
  </div>
  </div>
  </div>
  `,
  category: 'Modals',
  attributes: { class: 'fa fa-newspaper-o' },
});




//Tabs


editor.BlockManager.add('b4-tabs', {
  label: 'Tabs',
  content: `<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
  <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
  </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.</div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim reprehenderit. Magna duis labore cillum sint adipisicing exercitation ipsum. Nostrud ut anim non exercitation velit laboris fugiat cupidatat. Commodo esse dolore fugiat sint velit ullamco magna consequat voluptate minim amet aliquip ipsum aute laboris nisi. Labore labore veniam irure irure ipsum pariatur mollit magna in cupidatat dolore magna irure esse tempor ad mollit. Dolore commodo nulla minim amet ipsum officia consectetur amet ullamco voluptate nisi commodo ea sit eu.

  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">Sint sit mollit irure quis est nostrud cillum consequat Lorem esse do quis dolor esse fugiat sunt do. Eu ex commodo veniam Lorem aliquip laborum occaecat qui Lorem esse mollit dolore anim cupidatat. Deserunt officia id Lorem nostrud aute id commodo elit eiusmod enim irure amet eiusmod qui reprehenderit nostrud tempor. Fugiat ipsum excepteur in aliqua non et quis aliquip ad irure in labore cillum elit enim. Consequat aliquip incididunt ipsum et minim laborum laborum laborum et cillum labore. Deserunt adipisicing cillum id nulla minim nostrud labore eiusmod et amet. Laboris consequat consequat commodo non ut non aliquip reprehenderit nulla anim occaecat. Sunt sit ullamco reprehenderit irure ea ullamco Lorem aute nostrud magna.

  </div>
  </div>`,
  category: 'Tabs',
  attributes: { class: 'fa fa-clone' },
});


editor.BlockManager.add('b4-tabs-pills', {
  label: 'Tabs Pills',
  content: `<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item">
  <a class="nav-link active show" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
  </li>
  <li class="nav-item">
  <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
  </li>
  <li class="nav-item">
  <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
  </li>
  </ul>
  <div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
  <p>Consequat occaecat ullamco amet non eiusmod nostrud dolore irure incididunt est duis anim sunt officia. Fugiat velit proident aliquip nisi incididunt nostrud exercitation proident est nisi. Irure magna elit commodo anim ex veniam culpa eiusmod id nostrud sit cupidatat in veniam ad. Eiusmod consequat eu adipisicing minim anim aliquip cupidatat culpa excepteur quis. Occaecat sit eu exercitation irure Lorem incididunt nostrud.</p>
  </div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
  <p>Ad pariatur nostrud pariatur exercitation ipsum ipsum culpa mollit commodo mollit ex. Aute sunt incididunt amet commodo est sint nisi deserunt pariatur do. Aliquip ex eiusmod voluptate exercitation cillum id incididunt elit sunt. Qui minim sit magna Lorem id et dolore velit Lorem amet exercitation duis deserunt. Anim id labore elit adipisicing ut in id occaecat pariatur ut ullamco ea tempor duis.</p>
  </div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
  <p>Est quis nulla laborum officia ad nisi ex nostrud culpa Lorem excepteur aliquip dolor aliqua irure ex. Nulla ut duis ipsum nisi elit fugiat commodo sunt reprehenderit laborum veniam eu veniam. Eiusmod minim exercitation fugiat irure ex labore incididunt do fugiat commodo aliquip sit id deserunt reprehenderit aliquip nostrud. Amet ex cupidatat excepteur aute veniam incididunt mollit cupidatat esse irure officia elit do ipsum ullamco Lorem. Ullamco ut ad minim do mollit labore ipsum laboris ipsum commodo sunt tempor enim incididunt. Commodo quis sunt dolore aliquip aute tempor irure magna enim minim reprehenderit. Ullamco consectetur culpa veniam sint cillum aliqua incididunt velit ullamco sunt ullamco quis quis commodo voluptate. Mollit nulla nostrud adipisicing aliqua cupidatat aliqua pariatur mollit voluptate voluptate consequat non.</p>
  </div>
  </div>`,
  category: 'Tabs',
  attributes: { class: 'fa fa-clone' },
});

editor.BlockManager.add('b4-tabs-pills-vertical', {
  label: 'Tabs Pills Vertical',
  content: `
  <div class="row">
  <div class="col-3">
  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
  </div>
  </div>
  <div class="col-9">
  <div class="tab-content" id="v-pills-tabContent">
  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
  <p>Cillum ad ut irure tempor velit nostrud occaecat ullamco aliqua anim Lorem sint. Veniam sint duis incididunt do esse magna mollit excepteur laborum qui. Id id reprehenderit sit est eu aliqua occaecat quis et velit excepteur laborum mollit dolore eiusmod. Ipsum dolor in occaecat commodo et voluptate minim reprehenderit mollit pariatur. Deserunt non laborum enim et cillum eu deserunt excepteur ea incididunt minim occaecat.</p>
  </div>
  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
  <p>Culpa dolor voluptate do laboris laboris irure reprehenderit id incididunt duis pariatur mollit aute magna pariatur consectetur. Eu veniam duis non ut dolor deserunt commodo et minim in quis laboris ipsum velit id veniam. Quis ut consectetur adipisicing officia excepteur non sit. Ut et elit aliquip labore Lorem enim eu. Ullamco mollit occaecat dolore ipsum id officia mollit qui esse anim eiusmod do sint minim consectetur qui.</p>
  </div>
  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
  <p>Fugiat id quis dolor culpa eiusmod anim velit excepteur proident dolor aute qui magna. Ad proident laboris ullamco esse anim Lorem Lorem veniam quis Lorem irure occaecat velit nostrud magna nulla. Velit et et proident Lorem do ea tempor officia dolor. Reprehenderit Lorem aliquip labore est magna commodo est ea veniam consectetur.</p>
  </div>
  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
  <p>Eu dolore ea ullamco dolore Lorem id cupidatat excepteur reprehenderit consectetur elit id dolor proident in cupidatat officia. Voluptate excepteur commodo labore nisi cillum duis aliqua do. Aliqua amet qui mollit consectetur nulla mollit velit aliqua veniam nisi id do Lorem deserunt amet. Culpa ullamco sit adipisicing labore officia magna elit nisi in aute tempor commodo eiusmod.</p>
  </div>
  </div>
  </div>
  </div>
  `,
  category: 'Tabs',
  attributes: { class: 'fa fa-clone' },
});





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





}

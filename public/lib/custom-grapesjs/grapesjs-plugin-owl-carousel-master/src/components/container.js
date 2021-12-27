import { OWL_CONTAINER, OWL_TYPE } from '../consts';
import renderItems from './slideTemplate';

export default (editor, opts = {}) => {
  const domc = editor.DomComponents;

  const defaultType = domc.getType('default');
  const defaultModel = defaultType.model;
  const defaultView = defaultType.view;

  // TODO: REMOVE THIS AND USE THE TRAITS/MODEL
  const items = [
    {
      name: 'Deaultt Glasses #1',
      img: 'http://gpj.localhost/files/uploads/feature-modern.png',
      price: 42,
      surcharges: [
        {
          name: '1.5 DV Silver / Lotutec',
          price: 0
        },
        {
          name: '1.5 DV Platinum / DV BlueProtect',
          price: 15
        },
        {
          name: '1.6 DV Silver / Lotutec',
          price: 10
        },
        {
          name: '1.6 DV Platinum / DV BlueProtect',
          price: 25
        }
      ]
    },
    {
      name: 'Default #2',
      img: 'http://gpj.localhost/files/uploads/feature-module.png',
      price: 321,
      surcharges: [
        {
          name: 'PhotoFusion LotuTec UV',
          price: 40
        },
        {
          name: 'PhotoFusion DuraVision Platinum UV',
          price: 55
        }
      ]
    },
    {
      name: 'deefaultt #3',
      img: 'http://gpj.localhost/files/uploads/feature-options.png',
      price: 123,
      surcharges: [
        {
          name: 'DuraVision Platinum UV',
          price: 44
        },
        {
          name: 'PhotoFusion LotuTec UV',
          price: 55
        }
      ]
    }
  ];

  const renderContent = (items) => items.map(item => ({
    content: `${renderItems([item])}`
  }));

  // Open modal to select glasses
  const chooseGlasses = (editor, model) => {
    const comp = editor.DomComponents.getWrapper();
    const container = comp.find('div.owl-carousel');
    console.log('container', container);
    editor.select(model);
    editor.runCommand('show-glasses');
  };

  const containerModel = defaultModel.extend({
      init() {
        // this.on('change:attributes:content', this.handleTypeChange);
        this.on('change:glasses', this.handleTypeChange);
      },
      chooseGlasses(editor, model) {
        const comp = editor.DomComponents.getWrapper();
        console.log('comp', comp);
        debugger;
        const container = comp.find('div[class=owl-carousel]');
        console.log('container', container);
        editor.select(container);
        editor.runCommand('show-glasses');
      },
      handleTypeChange() {
        console.log('Glasses has been changed to: ', this.getAttributes());
      },
      defaults: {
        ...defaultModel.prototype.defaults,
        tagName: 'div',
        traits: [
          {
            label: 'Content',
            type: 'button',
            name: 'glasses',
            text: 'Choose glasses',
            full: 1,
            command: (editor, model) => chooseGlasses(editor, model)
          }
        ],
        glasses: items,
        draggable: true,
        attributes: {
          class: 'owl-carousel',
          'data-gjs-type': OWL_TYPE
        },
        components:
          (model) => renderContent(model.attributes.glasses),
        // [
        // { type: OWL_ITEM },
        // ],
        jsSrc: opts.jsOwl,
        cssSrc: opts.cssOwl,
        script: function () {
          const initOwl = function () {
            const owl = $('.owl-carousel');
            owl.owlCarousel({
              margin: 10,
              loop: true,
              responsive: {
                0: {
                  items: 1
                },
                600: {
                  items: 2
                },
                1000: {
                  items: 3
                }
              }
            });
          };
          const script = document.createElement('script');
          script.onload = initOwl;
          script.src = '{[ jsSrc ]}';
          document.body.appendChild(script);
          const link = document.createElement('link');
          link.rel = 'stylesheet';
          link.href = '{[ cssSrc ]}';
          document.head.appendChild(link);
        }
      }
    },
    {
      isComponent(el) {
        if (el.getAttribute) {
          console.log(`${OWL_CONTAINER} isComponent`, el.getAttribute('data-gjs-type'));
          if (el.getAttribute('data-gjs-type') == OWL_CONTAINER) {
            return { type: OWL_CONTAINER };
          }
        }
      }
    });

  const containerView = defaultView.extend({
    ...defaultView.prototype.defaults,
    events: {
      click: 'click'
    },

    init() {
      // TODO: this doesn't work, need to rerender the view when the model changes...
      this.listenTo(this.model, 'change:attributes:glasses', this.render())
    },

    click(event) {
      event.preventDefault();
      event.stopPropagation();
      chooseGlasses(editor, this.model)
    }
  });

  domc.addType(OWL_CONTAINER, {
    model: containerModel,
    view: containerView
  });
};

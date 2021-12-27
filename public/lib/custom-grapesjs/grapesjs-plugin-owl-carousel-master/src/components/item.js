import { OWL_ITEM } from '../consts';

export default (editor, opts = {}) => {
  const domc = editor.DomComponents;

  const defaultType = domc.getType('default');
  const defaultModel = defaultType.model;
  const defaultView = defaultType.view;

  // REMOVE THIS AND USE THE TRAITS
  const items = [
    {
      name: 'Glasses #1',
      img: 'http://gpj.localhost/files/uploads/feature-modern.png',
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
        },
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
      name: 'Glasses #2',
      img: 'http://gpj.localhost/files/uploads/feature-module.png',
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
    },{
      name: 'Glasses #3',
      img: 'http://gpj.localhost/files/uploads/feature-options.png',
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
    },
  ];
  const renderSurcharges = (surcharges) => surcharges.map(surcharge => `
    <div className="row item-options">
      <div className="col-6 text-left">${surcharge.name}</div>
      <div className="col-6 text-right">&euro; ${surcharge.price}</div>
    </div>`)
    .join('');

  const renderItems = (items) => items.map(({ name, img, price, surcharges }) => `
                <div class="item">
                  <div class="item-img">
                    <img src="${img}" alt="" />
                  </div>
          
                  <div class="item-body">
                    <div class="item-title">${name}</div>
                    <div class="row item-options">
                      <div class="col-6 text-left">Price</div>
                      <div class="col-6 text-right">&euro; ${price}</div>
                    </div>
          
                    <div class="item-title">Extra</div>
                    
                    ${renderSurcharges(surcharges)}
                  </div>
                </div>
              `).join('');

  domc.addType(OWL_ITEM, {
      model: defaultModel.extend({
          defaults: {
            ...defaultModel.prototype.defaults,
            tagName: 'div',
            type: OWL_ITEM,
            attributes: {
              // class: 'item',
              'data-gjs-type': OWL_ITEM
            },
            components: [
              {
                // tagName: 'div',
                content: `${renderItems(items)}`
              }
            ]
          }
        },
        {
          isComponent(el) {
            if (el.getAttribute) {
              console.log(`${OWL_ITEM} isComponent`, el.getAttribute('data-gjs-type'));
              if (el.getAttribute('data-gjs-type') == OWL_ITEM) {
                return { type: OWL_ITEM };
              }
            }
          }
        }),
      view: defaultView
    }
  );
};

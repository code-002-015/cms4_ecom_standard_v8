
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

export default renderItems;

import { OWL_CONTAINER, OWL_TYPE } from './consts';

export default (editor, opts = {}) => {
  const bm = editor.BlockManager;

  bm.add(OWL_TYPE, {
    label: 'Carousel',
    category: opts.gridsCategory || 'Basic',
    content:
    // `<div>Hello world ${OWL_TYPE}</div>`,
      {
        type: OWL_CONTAINER
      }
  });

  bm.add('test', {
    label: 'test',
    category: opts.gridsCategory || 'Basic',
    content:
    `<div>Hello world ${OWL_TYPE}</div>`
  });
}

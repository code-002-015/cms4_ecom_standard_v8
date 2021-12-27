import { OWL_CONTAINER, OWL_TYPE } from './consts';

export default (editor, opts = {}) => {
  const cmdm = editor.Commands;

  cmdm.add('show-glasses', {
    run(editor, sender) {
      editor.Modal.open({
        title: 'Select glasses',
        content: 'Glasses form....',
      })
        .onceClose(() => {
        // TODO:
        // load glasses
        // make glasses selectable in a form
        // fetch selectedGlasses JSON
          const selectedGlasses = [
            {
              name: 'loaded #3',
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
          const selectedComponent = editor.getSelected();
          if (selectedComponent.is(OWL_CONTAINER)) {
            selectedComponent.set('glasses', selectedGlasses);
          }
          this.stopCommand();
        });
    },
    stop(editor) {
      editor.Modal.close();
    }
  });
}

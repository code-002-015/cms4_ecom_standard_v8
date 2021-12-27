import loadCommands from './commands';
import loadComponents from './components';
import loadBlocks from './blocks';
import en from './locale/en';

export default (editor, opts = {}) => {
  const options = {
    ...{
      i18n: {}
      // default options
    },
    cssOwl: 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css',
    jsOwl: 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js',
    start: 25,
    ...opts,
  };

  // Define require GrapesJS API
  const domComponents = editor.DomComponents;
  const blockManager = editor.BlockManager;
  const canvas = editor.Canvas;
  const trait = editor.Canvas;

  // Add commands
  loadCommands(editor, options);
  // Add components
  loadComponents(editor, options);
  // Add blocks
  loadBlocks(editor, options);
  // Load i18n files
  editor.I18n && editor.I18n.addMessages({
    en,
    ...options.i18n
  });

  editor.on('load', () => {
    // const blocks = blockManager.getAll();
    // console.log(JSON.stringify(blocks));
    editor.addComponents('test',
      { at: 0 }
    );
  });
};

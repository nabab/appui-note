(() => {
  return {
    props: ['source'],
    methods: {
      setDefault(source){
        this.post(this.root + '/actions/masks/default', {id_note: this.source.id_note}, d => {
          if (d.success) {
            const defaults = this.masks.findAll('appui-note-masks-default').filter(a => {
              return (a.source.id_type === this.source.id_type) && (a.source.default === 1);
            });
            if (defaults.length) {
              defaults[0].source.default = 0;
            }

            this.source.default = 1;
            appui.success(bbn._('Saved'));
          }
					else {
						appui.error(bbn._('Error'));
					}
        });
      }
    }
  }
})();

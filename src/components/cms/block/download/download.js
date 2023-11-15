(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data() {
      let obj = {
        type: 'media',
        text: '',
        value: ''
      };
      return {
        emptyObj: obj,
        defaultConfig: {
          content: [bbn.fn.clone(obj)]
        }
      };
    },
    methods: {
      addItem(){
        this.source.content.push(bbn.fn.clone(this.emptyObj));
      }
    },
    components: {
      file: {
        template: `
<div class="bbn-bordered bbn-radius bbn-spadded bbn-grid-fields"
     style="border-style: dashed">
  <label>` + bbn._('Type') + `</label>
  <bbn-radiobuttons :source="types"
                    v-model="source.type"/>
  <template v-if="source.type === 'media'">
    <label>` + bbn._('Media') + `</label>
    <div class="appui-note-cms-block-download-preview bbn-flex">
      <bbn-button icon="nf nf-fae-galery"
                  :notext="true"
                  @click="openExplorer"
                  title="<?=_('Select a media')?>"
                  class="bbn-right-sspace"/>
      <!--<img class="bbn-bordered bbn-radius"
            :src="source.content"
            v-if="!!source.content">-->
    </div>
  </template>
  <template v-if="source.type === 'url'">
    <label>` + bbn._('URL') + `</label>
    <bbn-input v-model="source.value"
              class="bbn-w-100"/>
  </template>
  <label>` + bbn._('Text') + `</label>
  <bbn-input v-model="source.text"
             class="bbn-w-100"/>
</div>`,
        props: {
          source: {
            type: Object,
            required: true
          }
        },
        data(){
          return {
            types: [{
              text: bbn._('Media'),
              value: 'media'
            }, {
              text: bbn._('URL'),
              value: 'url'
            }]
          }
        },
        methods: {
          openExplorer(){
            this.getPopup().open({
              component: this.$options.components.gallery,
              componentOptions: {
                onSelection: this.onSelection
              },
              title: bbn._('Select a media'),
              width: '90%',
              height: '90%'
            });
          }
        }
      }
    }
  }
})();
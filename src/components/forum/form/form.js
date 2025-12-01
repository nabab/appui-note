/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 12/04/2018
 * Time: 18:36
 */
(() => {
  return {
    props: {
      source: {
        type: Object
      },
      data: {
        type: Object,
        default(){
          return {}
        }
      },
      formAction: {
        type: String
      },
      fileSave: {
        type: String
      },
      fileRemove: {
        type: String
      },
      imageDom: {
        type: String
      },
      linkPreview: {
        type: String
      },
      categories: {
        type: Array
      }
    },
    data(){
      return {
        canLock : true,
				editorTypes: [{
          text: bbn._('Simple text'),
          value: 'bbn-textarea'
        }, {
          text: bbn._('Rich text'),
          value: 'bbn-rte'
        }, {
          text: bbn._('Markdown'),
          value: 'bbn-markdown'
        }, {
          text: bbn._('PHP code'),
          value: 'bbn-code',
          mode: 'php'
        }, {
          text: bbn._('JavaScript code'),
          value: 'bbn-code',
          mode: 'javascript'
        }, {
          text: bbn._('CSS code'),
          value: 'bbn-code',
          mode: 'less'
        }],
        editorType: 'bbn-rte',
        ref: bbn.dt().unix()
      }
    },
    computed: {
      formData(){
        return bbn.fn.extend(true, {ref: this.ref}, this.data);
      }
    },
    methods: {
      switchEditorType(){
        let mode;
        if (this.$refs.editorType.widget) {
          this.editorType = this.$refs.editorType.widget.value();
          if ((this.editorType === 'bbn-code')
            && (mode = this.$refs.editorType.widget.dataItem()['mode'])
          ) {
            setTimeout(() => {
              this.$refs.editor.widget.setOption('mode', mode);
            }, 500);
          }
        }
      },
			linkEnter(){
        const link = (this.$refs.link.$refs.element.value.indexOf('http') !== 0 ? 'http://' : '') +
                this.$refs.link.$refs.element.value,
              idx = this.source.links.push({
                inProgress: true,
                content: {
                  url: link,
                  description: false
                },
                image: false,
                title: false,
                error: false
              }) - 1;
				if (this.linkPreview) {
					this.post(this.linkPreview, {
	          url: link,
	          ref: this.ref
	        }, d => {
	          if (d.data && d.data.realurl) {
	            if (d.data.picture) {
	              this.source.links[idx].image = d.data.picture;
	            }
	            if (d.data.title) {
	              this.source.links[idx].title = d.data.title;
	            }
	            if (d.data.desc) {
	              this.source.links[idx].content.description = d.data.desc;
	            }
	            this.source.links[idx].inProgress = false;
	            this.$refs.link.$refs.element.value = '';
	          }
	          else{
	            this.source.links[idx].error = true;
	          }
	        });
				}
      },
      linkRemove(idx){
        if ( idx !== undefined){
          this.confirm(bbn._('Are you sure you want to remove this link?'), () => {
            this.source.links.splice(idx, 1);
          });
        }
      },
      changeVersion(d){
        if (d) {
          if ((this.source.category !== undefined) &&
            (d.category !== undefined)
          ){
            this.$set(this.source, 'category', d.category);
          }
          this.$set(this.source, 'creation', d.creation);
          this.$set(this.source, 'creator', d.id_user);
          this.$set(this.source, 'locked', d.locked);
          this.$set(this.source, 'text', d.content);
          if ( this.source.title !== undefined ){
            this.$set(this.source, 'title', d.title);
          }
          this.$set(this.source, 'files', d.files);
          this.$set(this.source, 'links', d.links);
          this.$forceUpdate();
        }
      },
      onFormSuccess(d, ev) {
        this.$emit('success', d, ev);
      }
    },
    mounted(){
      let forum =  this.closest('bbn-container').find('appui-note-forum');
      if (forum) {
        this.canLock = forum.canLock;
      }
    }
  }
})();
